<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', fn (Blueprint $t) => $t->boolean('is_admin')->default(false));
        Schema::table('projets', function (Blueprint $t) {
            $t->string('slug')->nullable()->unique();
            $t->string('statut')->default('en_cours');
            $t->string('publication')->default('brouillon');
            $t->string('localisation')->nullable();
            foreach (['contexte', 'solution', 'objectifs', 'beneficiaires', 'equipe', 'financement_note'] as $f) {
                $t->text($f)->nullable();
            }
            foreach (['indicateurs', 'etapes', 'depenses', 'faq', 'montants_suggeres'] as $f) {
                $t->json($f)->nullable();
            }
            $t->unsignedBigInteger('budget_centimes')->nullable();
            $t->boolean('dons_actifs')->default(false);
            $t->string('seo_title')->nullable();
            $t->string('meta_description')->nullable();
        });
        // Preserve the visibility of projects already displayed on the public site.
        DB::table('projets')->orderBy('id')->each(function ($v) {
            if ($v->image && ! DB::table('projet_images')->where('projet_id', $v->id)->exists()) {
                DB::table('projet_images')->insert(['projet_id' => $v->id, 'chemin' => $v->image, 'ordre' => 0, 'created_at' => now(), 'updated_at' => now()]);
            }
            DB::table('projets')->where('id', $v->id)->update(['slug' => (Str::slug($v->titre) ?: 'projet').'-'.$v->id, 'publication' => 'publie']);
        });
        Schema::create('categories', function (Blueprint $t) {
            $t->id();
            $t->string('nom')->unique();
            $t->timestamps();
        });
        Schema::create('articles', function (Blueprint $t) {
            $t->id();
            $t->string('titre');
            $t->string('slug')->unique();
            $t->text('extrait')->nullable();
            $t->longText('contenu');
            $t->string('image')->nullable();
            $t->string('image_alt')->nullable();
            $t->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $t->string('publication')->default('brouillon');
            $t->timestamp('published_at')->nullable();
            $t->string('seo_title')->nullable();
            $t->string('meta_description')->nullable();
            $t->timestamps();
        });
        Schema::create('article_projet', function (Blueprint $t) {
            $t->foreignId('article_id')->constrained()->cascadeOnDelete();
            $t->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $t->primary(['article_id', 'projet_id']);
        });
        Schema::create('donations', function (Blueprint $t) {
            $t->id();
            $t->uuid('reference')->unique();
            $t->foreignId('projet_id')->nullable()->constrained('projets')->nullOnDelete();
            $t->unsignedBigInteger('amount_centimes');
            $t->string('currency', 3)->default('eur');
            $t->string('status')->default('pending');
            $t->string('stripe_session_id')->nullable()->unique();
            $t->timestamp('confirmed_at')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
        Schema::dropIfExists('article_projet');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('categories');
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn('is_admin'));
        Schema::table('projets', fn (Blueprint $t) => $t->dropColumn(['slug', 'statut', 'publication', 'localisation', 'contexte', 'solution', 'objectifs', 'beneficiaires', 'equipe', 'financement_note', 'indicateurs', 'etapes', 'depenses', 'faq', 'montants_suggeres', 'budget_centimes', 'dons_actifs', 'seo_title', 'meta_description']));
    }
};
