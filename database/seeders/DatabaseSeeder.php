<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categoria;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Categoria::factory(100)->create();

      
    }
}
