<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
     public function run()
    {
       $this->call([
                UserSeeder::class, // <-- Cette ligne appelle votre seeder
                CourseSeeder::class, // <<< AJOUTEZ CETTE LIGNE
            ]);
     
    }
}

  
