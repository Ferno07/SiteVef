<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membres', function (Blueprint $table) {
            $table->id();
            $table->string('prenom');
            $table->string('nom');
            $table->string('poste');                  // Titre/rôle dans l'association
            $table->text('bio')->nullable();           // Courte description
            $table->string('photo')->nullable();       // Chemin vers la photo uploadée
            $table->integer('ordre')->default(0);      // Ordre d'affichage (plus petit = premier)
            $table->boolean('actif')->default(true);   // Visible sur le site public ?
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membres');
    }
};
