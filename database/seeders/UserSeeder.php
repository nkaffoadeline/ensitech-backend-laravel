<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // N'oubliez pas d'importer le modèle User
use Illuminate\Support\Facades\Hash; // N'oubliez pas d'importer la façade Hash

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Patrick',
            'username' => 'adelinematho@gmail.com', // Utilisez une adresse email unique
            'password' => Hash::make('adel123'), // Le mot de passe hashé
            'role' => 'directeur', // Le rôle défini pour Patrick
            //'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Sophie',
            'username' => 'arolle@example.com',
            'password' => Hash::make('123'), // Le mot de passe hashé
            'role' => 'responsable', // Le rôle défini pour Sophie
            //'email_verified_at' => now(),
        ]);
    }
}