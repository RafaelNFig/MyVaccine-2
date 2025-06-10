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
    $this->call([
        UsersSeeder::class,
        VaccinesSeeder::class,
        PostsSeeder::class,
        StocksSeeder::class,
        VaccinationHistorySeeder::class,
    ]);
}
}
