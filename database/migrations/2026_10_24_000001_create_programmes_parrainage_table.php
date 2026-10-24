<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programmes_parrainage', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('titre', 150);
            $table->string('accroche', 255);
            $table->text('description');
            $table->unsignedInteger('montant_mensuel_centimes')->nullable();
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->timestamps();
        });

        // Programmes réels définis par l’association. Aucun dossier de bénéficiaire.
        DB::table('programmes_parrainage')->insert([
            [
                'code' => 'enfant',
                'titre' => 'Parrainer un enfant',
                'accroche' => 'Accompagner un enfant dans son parcours scolaire et son quotidien.',
                'description' => 'Un parrainage individuel pour contribuer aux frais de scolarité et aux repas d’un enfant accompagné par l’association. Notre équipe échange avec vous et organise la mise en place du parrainage.',
                'montant_mensuel_centimes' => 2500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'sante',
                'titre' => 'Parrainage santé',
                'accroche' => 'S’engager chaque mois pour faciliter l’accès aux soins.',
                'description' => 'Un soutien mensuel aux besoins de santé des personnes vulnérables accompagnées par l’association. Vous choisissez le montant de votre contribution et échangez avec notre équipe pour en définir les modalités.',
                'montant_mensuel_centimes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('programmes_parrainage');
    }
};
