<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Operador User',
            'email' => 'operador@example.com',
            'password' => bcrypt('password'),
            'role' => 'operador',
        ]);

        User::create([
            'name' => 'Consultor User',
            'email' => 'consultor@example.com',
            'password' => bcrypt('password'),
            'role' => 'consultor',
        ]);

        $this->call([
            BeneficiariosSeeder::class,
            ProductosSeeder::class,
        ]);
    }
}
