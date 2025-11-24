<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projets')->insert([
            [
                'titre' => 'Construction d\'une école',
                'description' => 'Construction d\'une école primaire pour 200 enfants.',
                'description_longue' => 'Ce projet vise à offrir un accès à l\'éducation à 200 enfants défavorisés en construisant une école équipée de 6 salles de classe, d\'une bibliothèque et de sanitaires.',
                'image' => 'Style1/images/ecole.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Campagne de vaccination',
                'description' => 'Vaccination contre la poliomyélite pour 500 enfants.',
                'description_longue' => 'Une campagne de vaccination massive pour protéger 500 enfants contre la poliomyélite et autres maladies évitables. Nous fournissons également des vitamines et des vermifuges.',
                'image' => 'Style1/images/soins.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Soutien aux femmes entrepreneures',
                'description' => 'Micro-crédits pour 50 femmes.',
                'description_longue' => 'Nous offrons des micro-crédits et une formation en gestion à 50 femmes pour les aider à lancer leur propre activité génératrice de revenus et devenir autonomes.',
                'image' => 'Style1/images/autonomisationfemmes.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Forage de puits',
                'description' => 'Accès à l\'eau potable pour un village.',
                'description_longue' => 'Construction d\'un puits à pompe manuelle pour fournir de l\'eau potable à un village de 1000 habitants, réduisant ainsi les maladies hydriques.',
                'image' => 'Style1/images/header1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
