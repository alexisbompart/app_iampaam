<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
        Producto::create([
            'nombre' => 'Medicamento A',
            'tipo' => 'Medicamento',
            'descripcion' => 'Descripción del medicamento A',
            'stock' => 100,
            'unidad' => 'cajas',
            'fecha_vencimiento' => '2025-12-31',
            'proveedor' => 'Proveedor 1',
        ]);

        Producto::create([
            'nombre' => 'Aparato B',
            'tipo' => 'Aparato',
            'descripcion' => 'Descripción del aparato B',
            'stock' => 50,
            'unidad' => 'unidades',
            'fecha_vencimiento' => null,
            'proveedor' => 'Proveedor 2',
        ]);
    }
}
