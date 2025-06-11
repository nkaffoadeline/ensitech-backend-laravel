<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course; // Assurez-vous d'importer le modèle Course

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'title' => 'Réseaux et Télécom',
            'description' => 'Introduction aux concepts de réseaux et télécommunications.',
            'duration' => '20h15min',
        ]);

        Course::create([
            'title' => 'Analyse 1',
            'description' => 'Étude des fonctions et des limites en mathématiques.',
            'duration' => '12h30min',
        ]);

        Course::create([
            'title' => 'Algèbre 1',
            'description' => "Fondements de l'algèbre linéaire et des équations.",
            'duration' => '15h45min',
        ]);

        Course::create([
            'title' => "Introduction à l'informatique",
            'description' => "Présentation des bases de l'informatique et de la programmation.",
            'duration' => '8h',
        ]);

        Course::create([
            'title' => 'Algorithmique 1',
            'description' => 'Concepts de base des algorithmes et structures de données.',
            'duration' => '25h30min',
        ]);
    }
}
