<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\OrdenEntrada;
use App\Models\OrdenEntrega;
use App\Models\Beneficiario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OrdenesController extends Controller
{
    public function index()
    {
        $ordenesEntrada = OrdenEntrada::all();
        $ordenesEntrega = OrdenEntrega::all();
        return view('ordenes.index', compact('ordenesEntrada', 'ordenesEntrega'));
    }

    public function create($tipo)
    {
        $productos = Producto::all();
        if ($tipo == 'entrega') {
            $beneficiarios = Beneficiario::all();
            return view('ordenes.create', compact('tipo', 'beneficiarios', 'productos'));
        }
        return view('ordenes.create', compact('tipo', 'productos'));
    }

    public function store(Request $request, $tipo)
    {
        if ($tipo == 'entrada') {
            $request->validate([
                'fecha' => 'required|date',
                'proveedor' => 'required|string|max:255',
                'observaciones' => 'nullable|string',
                'productos' => 'required|array',
                'productos.*' => 'required|exists:productos,id',
                'cantidades' => 'required|array',
                'cantidades.*' => 'required|integer|min:1',
                'lotes' => 'nullable|array',
                'fechas_vencimiento' => 'nullable|array',
            ]);
            $orden = OrdenEntrada::create($request->only(['fecha', 'proveedor', 'observaciones']));
        } elseif ($tipo == 'entrega') {
            $request->validate([
                'fecha' => 'required|date',
                'beneficiario_id' => 'required|exists:beneficiarios,id',
                'observaciones' => 'nullable|string',
                'productos' => 'required|array',
                'productos.*' => 'required|exists:productos,id',
                'cantidades' => 'required|array',
                'cantidades.*' => 'required|integer|min:1',
                'lotes' => 'nullable|array',
                'fechas_vencimiento' => 'nullable|array',
            ]);
            $orden = OrdenEntrega::create($request->only(['fecha', 'beneficiario_id', 'observaciones']));
        }

        // Crear items y actualizar stock
        foreach ($request->productos as $index => $productoId) {
            $producto = Producto::find($productoId);
            $cantidad = $request->cantidades[$index];

            if ($tipo == 'entrada') {
                $producto->increment('stock', $cantidad);
            } elseif ($tipo == 'entrega') {
                if ($producto->stock < $cantidad) {
                    return back()->withErrors(['stock' => 'Stock insuficiente para ' . $producto->nombre]);
                }
                $producto->decrement('stock', $cantidad);
            }

            $itemData = [
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'lote' => $request->lotes[$index] ?? null,
                'fecha_vencimiento' => $request->fechas_vencimiento[$index] ?? null,
            ];
            if ($tipo == 'entrada') {
                $itemData['orden_entrada_id'] = $orden->id;
                $orden->items()->create($itemData);
            } else {
                $itemData['orden_entrega_id'] = $orden->id;
                $orden->items()->create($itemData);
            }
        }

        // Limpiar caché del dashboard para reflejar cambios en las órdenes y stock
        Cache::forget('dashboard_stats');
        Cache::forget('dashboard_ordenes_mensuales');

        return redirect()->route('ordenes.index')->with('success', 'Orden creada exitosamente.');
    }

    public function show($tipo, $id)
    {
        if ($tipo == 'entrada') {
            $orden = OrdenEntrada::with('items.producto')->findOrFail($id);
        } elseif ($tipo == 'entrega') {
            $orden = OrdenEntrega::with('items.producto')->findOrFail($id);
        }
        return view('ordenes.show', compact('orden', 'tipo'));
    }
}
