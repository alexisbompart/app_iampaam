<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductosController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'unidad' => 'required|string|max:255',
            'fecha_vencimiento' => 'nullable|date',
            'proveedor' => 'nullable|string|max:255',
        ]);

        Producto::create($request->all());

        // Limpiar caché del dashboard para reflejar cambios en el inventario
        Cache::forget('dashboard_stats');
        Cache::forget('dashboard_ordenes_mensuales');

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'unidad' => 'required|string|max:255',
            'fecha_vencimiento' => 'nullable|date',
            'proveedor' => 'nullable|string|max:255',
        ]);

        $producto->update($request->all());

        // Limpiar caché del dashboard para reflejar cambios en el inventario
        Cache::forget('dashboard_stats');
        Cache::forget('dashboard_ordenes_mensuales');

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        // Limpiar caché del dashboard para reflejar cambios en el inventario
        Cache::forget('dashboard_stats');
        Cache::forget('dashboard_ordenes_mensuales');

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
