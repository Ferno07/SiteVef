<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->string('candidature_nom');
            $table->string('candidature_prenom');
            $table->date('candidature_dateNaissance');
            $table->string('candidature_email')->unique();
            $table->string('candidature_telephone');
            $table->string('candidature_adresse');
            $table->string('candidature_typeParticipation');
            $table->string('candidature_autreType')->nullable();
            $table->text('candidature_disponibilites');
            $table->string('candidature_preferenceAction');
            $table->text('candidature_motivation');
            $table->boolean('candidature_rgpd')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
