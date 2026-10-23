<div class="admin-panel" id="actualites">
<div class="panel-header">
<h1>Actualités</h1>
<p>Articles, suivi des projets et catégories</p>
</div>
<div class="panel-content">
<section class="editorial-section">
<div class="editorial-actions">
<h2>Articles ({{ $articles->count() }})</h2>
<a class="btn btn-primary" href="{{ route('admin.articles.create') }}">Créer une actualité</a>
</div>
<div class="table-scroll">
<table class="editorial-table">
<thead>
<tr>
<th>Titre</th>
<th>Catégorie</th>
<th>Visibilité</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
@forelse($articles as $article)<tr>
<td>{{ $article->titre }}</td>
<td>{{ $article->category?->nom ?? '—' }}</td>
<td>{{ $article->publication }}</td>
<td>
<div class="editorial-actions">
<a class="btn btn-secondary" href="{{ route('admin.articles.edit',$article) }}">Modifier</a>
<a href="{{ route('admin.articles.preview',$article) }}">Aperçu</a>
<form method="post" action="{{ route('admin.articles.destroy',$article) }}" onsubmit="return confirm('Supprimer cet article ?')">
@csrf @method('DELETE')<button class="btn btn-secondary">Supprimer</button>
</form>
</div>
</td>
</tr>
@empty<tr>
<td colspan="4">Aucune actualité. Vos publications apparaîtront ici.</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</section>
<section class="editorial-section">
<h2>Catégories</h2>
<form method="post" action="{{ route('admin.categories.store') }}" class="editorial-actions">
@csrf<label for="category-new">Nouvelle catégorie</label>
<input id="category-new" name="nom" required maxlength="100">
<button class="btn btn-primary">Ajouter</button>
</form>
@foreach($categories as $category)<div class="editorial-actions" style="margin-top:16px">
<form method="post" action="{{ route('admin.categories.update',$category) }}">
@csrf @method('PUT')<label for="cat-{{ $category->id }}">Nom de la catégorie</label>
<input id="cat-{{ $category->id }}" name="nom" value="{{ $category->nom }}" required maxlength="100">
<button class="btn btn-secondary">Renommer</button>
</form>
<form method="post" action="{{ route('admin.categories.destroy',$category) }}" onsubmit="return confirm('Supprimer cette catégorie ? Les articles seront conservés.')">
@csrf @method('DELETE')<button class="btn btn-secondary">Supprimer</button>
</form>
</div>
@endforeach
</section>
</div>
</div>
<div class="admin-panel" id="dons">
<div class="panel-header">
<h1>Dons et collectes</h1>
<p>Seules les confirmations signées de Stripe valident les paiements.</p>
</div>
<div class="panel-content">
@if(!config('cashier.secret') || !config('cashier.webhook.secret'))<div class="editorial-section">
<p>La collecte en ligne nécessite la configuration de Stripe et de son secret de webhook. Aucun paiement n’est simulé.</p>
</div>
@endif
<section class="editorial-section">
<h2>Collectes par projet</h2>
<div class="table-scroll">
<table class="editorial-table">
<thead>
<tr>
<th>Projet</th>
<th>Objectif</th>
<th>Confirmé</th>
<th>Progression</th>
</tr>
</thead>
<tbody>
@foreach($projets as $project)@php($collected=$project->collected)<tr>
<td>{{ $project->titre }}</td>
<td>{{ $project->budget_centimes !== null ? number_format($project->budget_centimes/100,2,',',' ').' €' : 'Non renseigné' }}</td>
<td>{{ number_format($collected/100,2,',',' ') }} €</td>
<td>
@if($project->budget_centimes>0)<progress max="{{ $project->budget_centimes }}" value="{{ min($collected,$project->budget_centimes) }}" aria-label="Progression de {{ $project->titre }}">
</progress> {{ round($collected/$project->budget_centimes*100) }} % @else — @endif
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</section>
<section class="editorial-section">
<h2>Transactions</h2>
<div class="table-scroll">
<table class="editorial-table">
<thead>
<tr>
<th>Date</th>
<th>Référence</th>
<th>Projet</th>
<th>Montant</th>
<th>Statut</th>
</tr>
</thead>
<tbody>
@forelse($donations as $donation)<tr>
<td>{{ $donation->created_at->format('d/m/Y H:i') }}</td>
<td>{{ $donation->reference }}</td>
<td>{{ $donation->projet?->titre ?? 'Don général' }}</td>
<td>{{ number_format($donation->amount_centimes/100,2,',',' ') }} €</td>
<td>{{ ['pending'=>'En attente','confirmed'=>'Confirmé','failed'=>'Échoué','expired'=>'Expiré'][$donation->status] ?? $donation->status }}</td>
</tr>
@empty<tr>
<td colspan="5">Aucune transaction enregistrée.</td>
</tr>
@endforelse
</tbody>
</table>
</div>{{ $donations->fragment('dons')->links() }}</section>
</div>
</div>
