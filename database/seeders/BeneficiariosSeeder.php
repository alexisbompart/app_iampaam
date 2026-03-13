<?php

namespace Database\Seeders;

use App\Models\Beneficiario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeneficiariosSeeder extends Seeder
{
    public function run(): void
    {
        Beneficiario::create([
            'nombre' => 'Juan Pérez',
            'fecha_nacimiento' => '1980-05-15',
            'genero' => 'masculino',
            'direccion' => 'Calle 123, Ciudad',
            'telefono' => '555-1234',
            'email' => 'juan@example.com',
        ]);

        Beneficiario::create([
            'nombre' => 'María García',
            'fecha_nacimiento' => '1975-08-20',
            'genero' => 'femenino',
            'direccion' => 'Avenida 456, Ciudad',
            'telefono' => '555-5678',
            'email' => 'maria@example.com',
        ]);
    }
}
