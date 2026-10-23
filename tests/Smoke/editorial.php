<?php

require dirname(__DIR__, 2).'/vendor/autoload.php';
$app = require dirname(__DIR__, 2).'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$app['env'] = 'testing';
config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:', 'session.driver' => 'array', 'cache.default' => 'array', 'mail.default' => 'array']);
Illuminate\Support\Facades\DB::purge();
Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
echo "Migrations OK\n";
$project = App\Models\Projet::create(['titre' => 'Test technique', 'description' => 'Résumé', 'slug' => 'test-technique', 'publication' => 'publie', 'statut' => 'en_cours']);
$article = App\Models\Article::create(['titre' => 'Suivi', 'slug' => 'suivi', 'contenu' => "## Un titre\nUn texte [projet](/projets/test-technique)", 'publication' => 'publie', 'published_at' => now()]);
$article->projets()->attach($project);
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
foreach (['/', '/projets', '/projets/test-technique', '/actualites', '/actualites/suivi', '/don', '/don/merci', '/sitemap.xml'] as $path) {
    $request = Illuminate\Http\Request::create($path);
    $response = $kernel->handle($request);
    echo "$path ".$response->getStatusCode()."\n";
    if ($response->getStatusCode() !== 200) {
        file_put_contents('/tmp/editorial-error.html', $response->getContent());
        exit(1);
    }
    $kernel->terminate($request, $response);
}
$user = App\Models\User::create(['name' => 'Test', 'email' => 'test@example.test', 'password' => 'not-used']);
Illuminate\Support\Facades\Auth::login($user);
$response = $kernel->handle(Illuminate\Http\Request::create('/administrateur'));
if ($response->getStatusCode() !== 403) {
    throw new Exception('Non-admin must be denied');
}
echo "Non-admin forbidden OK\n";
$user->forceFill(['is_admin' => true])->save();
foreach (['/administrateur', '/administrateur/projets/'.$project->id.'/editer', '/administrateur/projets/'.$project->id.'/apercu', '/administrateur/articles/creer', '/administrateur/articles/'.$article->id.'/editer', '/administrateur/articles/'.$article->id.'/apercu'] as $path) {
    $response = $kernel->handle(Illuminate\Http\Request::create($path));
    echo "$path ".$response->getStatusCode()."\n";
    if ($response->getStatusCode() !== 200) {
        file_put_contents('/tmp/editorial-error.html', $response->getContent());
        exit(1);
    }
}

function check($condition, $message)
{
    if (! $condition) {
        throw new RuntimeException($message);
    } echo $message." OK\n";
}
$draft = App\Models\Projet::create(['titre' => 'Confidentiel', 'slug' => 'confidentiel', 'publication' => 'brouillon', 'statut' => 'a_venir']);
check($kernel->handle(Illuminate\Http\Request::create('/projets/confidentiel'))->getStatusCode() === 404, 'Draft hidden from public');
$response = $kernel->handle(Illuminate\Http\Request::create('/administrateur/enregistrer-projet', 'POST', [
    'titre' => 'Nouveau projet', 'publication' => 'brouillon', 'statut' => 'a_venir', 'budget' => '125.50',
    'indicateurs_texte' => 'Bénéficiaires | 25', 'etapes_texte' => 'Préparation | Recueil des besoins', 'depenses_texte' => 'Matériel | 125.50', 'faq_texte' => 'Comment aider ? | Contactez-nous', 'montants_texte' => '10, 25, 50',
]));
check($response->isRedirect(), 'Project form submitted');
$new = App\Models\Projet::where('titre', 'Nouveau projet')->firstOrFail();
check($new->budget_centimes === 12550 && $new->publication === 'brouillon' && $new->faq[0][0] === 'Comment aider ?', 'Project data persisted');
$response = $kernel->handle(Illuminate\Http\Request::create('/administrateur/articles', 'POST', ['titre' => 'Article créé', 'publication' => 'publie', 'contenu' => '## Titre réel', 'projets' => [$new->id]]));
check($response->isRedirect(), 'Article form submitted');
$created = App\Models\Article::where('titre', 'Article créé')->firstOrFail();
check($created->projets->contains($new) && $created->published_at !== null, 'Article publication and project association');
$originalSlug = $new->slug;
$kernel->handle(Illuminate\Http\Request::create('/administrateur/projet/'.$new->id, 'PUT', ['titre' => 'Titre modifié', 'publication' => 'publie', 'statut' => 'en_cours']));
check($new->fresh()->slug === $originalSlug, 'Project URL stable after title change');
config(['cashier.webhook.secret' => 'whsec_test_only']);
$d = App\Models\Donation::create(['reference' => (string) Illuminate\Support\Str::uuid(), 'projet_id' => $project->id, 'amount_centimes' => 2500, 'currency' => 'eur', 'status' => 'pending', 'stripe_session_id' => 'cs_test_123']);
$payload = json_encode(['id' => 'evt_test', 'object' => 'event', 'type' => 'checkout.session.completed', 'data' => ['object' => ['id' => 'cs_test_123', 'object' => 'checkout.session', 'metadata' => ['donation_reference' => $d->reference], 'amount_total' => 2500, 'currency' => 'eur', 'payment_status' => 'paid']]]);
function webhook($kernel, $payload, $signature)
{
    return $kernel->handle(Illuminate\Http\Request::create('/stripe/webhook', 'POST', [], [], [], ['HTTP_STRIPE_SIGNATURE' => $signature, 'CONTENT_TYPE' => 'application/json'], $payload));
}
check(webhook($kernel, $payload, 'invalid')->getStatusCode() === 400 && $d->fresh()->status === 'pending', 'Invalid webhook rejected');
$time = time();
$signature = 't='.$time.',v1='.hash_hmac('sha256', $time.'.'.$payload, 'whsec_test_only');
check(webhook($kernel, $payload, $signature)->getStatusCode() === 200 && $d->fresh()->status === 'confirmed', 'Signed payment confirmed');
webhook($kernel, $payload, $signature);
check($project->collected === 2500, 'Duplicate webhook does not double collection');
$kernel->handle(Illuminate\Http\Request::create('/don/merci?session_id=untrusted'));
check($project->collected === 2500, 'Browser return cannot change collection');
Illuminate\Support\Facades\Auth::logout();
check($kernel->handle(Illuminate\Http\Request::create('/posts/'.$project->id, 'DELETE'))->isRedirect(), 'Anonymous deletion blocked');
check(App\Models\Projet::find($project->id) !== null, 'Project retained after unauthorized deletion');
$ordinary = App\Models\User::create(['name' => 'Ordinary', 'email' => 'ordinary@example.test', 'password' => 'not-used']);
Illuminate\Support\Facades\Auth::login($ordinary);
foreach (['/administrateur/projet/'.$project->id => 'PUT', '/administrateur/articles/'.$article->id => 'DELETE', '/posts/'.$project->id => 'DELETE'] as $path => $method) {
    check($kernel->handle(Illuminate\Http\Request::create($path, $method))->getStatusCode() === 403, 'Ordinary account blocked: '.$method.' '.$path);
}
Illuminate\Support\Facades\Auth::login($user);
$request = Illuminate\Http\Request::create('/administrateur/articles', 'POST', ['titre' => 'Upload interdit', 'contenu' => 'Texte', 'publication' => 'brouillon'], [], ['image' => Illuminate\Http\UploadedFile::fake()->create('script.php', 1, 'application/x-httpd-php')], ['HTTP_ACCEPT' => 'application/json']);
check($kernel->handle($request)->getStatusCode() === 422, 'Executable upload rejected');
check(! str_contains(App\Services\ArticleText::line('<script>alert(1)</script>'), ' <script>') && ! str_contains(App\Services\ArticleText::line('<script>alert(1)</script>'), '<script>'), 'Article HTML escaped');
check(App\Services\Money::cents(655957, 'xof') === 100000, 'FCFA conversion uses the official parity');
check(App\Services\Money::cents(10, 'eur') === 1000, 'Euro conversion preserves cents');
check(App\Services\Money::fcfa(10) === '6 560 FCFA', 'FCFA display rounded to whole francs');
Illuminate\Support\Facades\Auth::logout();
$response = $kernel->handle(Illuminate\Http\Request::create('/projets/test-technique'));
check(! str_contains($response->getContent(), 'id="don"'), 'Project donation section hidden when collection is closed');
$project->update(['dons_actifs' => true]);
$response = $kernel->handle(Illuminate\Http\Request::create('/projets/test-technique'));
check(str_contains($response->getContent(), 'name="amount_currency"') && str_contains($response->getContent(), 'FCFA / XOF'), 'Project donation form offers euros and FCFA');
echo "Editorial smoke checks passed; database existed only in memory.\n";
