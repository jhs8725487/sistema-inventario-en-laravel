<?php

namespace Database\Seeders;
use App\Models\Sucursal;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Categoria::factory(50)->create();
        Sucursal::factory(10)->create();
        Producto::factory(200)->create();

        User::create([
            'name' => 'Joel Herrera',
            'email' => 'jhericoo8322@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

      
    }
}
