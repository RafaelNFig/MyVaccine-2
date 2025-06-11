<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
{
        // Cria 20 usuários
        \App\Models\User::factory()->count(20)->create();

        // Cria 10 vacinas
        \App\Models\Vaccine::factory()->count(10)->create();

        // Cria 10 posts
        \App\Models\Post::factory()->count(10)->create();

        // Cria 30 stocks
        \App\Models\Stock::factory()->count(30)->create();

        // Cria 15 registros de vacinação
        \App\Models\VaccinationHistory::factory()->count(15)->create();
}

}