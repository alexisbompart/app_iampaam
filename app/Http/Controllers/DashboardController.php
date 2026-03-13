<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use App\Models\Producto;
use App\Models\OrdenEntrada;
use App\Models\OrdenEntrega;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Cache general statistics to improve response time. Refrescar cada 5 minutos.
        $stats = Cache::remember('dashboard_stats', now()->addMinutes(5), function () {
            $totalBeneficiarios = Beneficiario::count();
            $totalProductos = Producto::count();
            $totalOrdenesEntrada = OrdenEntrada::count();
            $totalOrdenesEntrega = OrdenEntrega::count();

            // Estadísticas de género
            $generos = Beneficiario::selectRaw('genero, count(*) as count')
                ->groupBy('genero')
                ->pluck('count', 'genero');

            $masculino = $generos->get('masculino', 0);
            $femenino = $generos->get('femenino', 0);
            $otro = $generos->get('otro', 0);

            // Estadísticas adicionales para análisis
            $productosBajoStock = Producto::where('stock', '<=', 10)->count();
            $ordenesRecientes = OrdenEntrega::where('created_at', '>=', now()->subDays(30))->count();

            // Calcular adultos mayores usando comparación de fechas para aprovechar índices.
            $beneficiariosMayores = Beneficiario::where('fecha_nacimiento', '<=', now()->subYears(65))->count();

            return [
                'totalBeneficiarios' => $totalBeneficiarios,
                'totalProductos' => $totalProductos,
                'totalOrdenesEntrada' => $totalOrdenesEntrada,
                'totalOrdenesEntrega' => $totalOrdenesEntrega,
                'masculino' => $masculino,
                'femenino' => $femenino,
                'otro' => $otro,
                'productosBajoStock' => $productosBajoStock,
                'ordenesRecientes' => $ordenesRecientes,
                'beneficiariosMayores' => $beneficiariosMayores,
            ];
        });

        // Datos para gráficas adicionales (actualizar cada 5 minutos)
        $ordenesMensuales = Cache::remember('dashboard_ordenes_mensuales', now()->addMinutes(5), function () {
            $ordenesPorMes = OrdenEntrega::selectRaw('EXTRACT(MONTH FROM created_at) as mes, COUNT(*) as total')
                ->whereYear('created_at', date('Y'))
                ->groupBy('mes')
                ->orderBy('mes')
                ->pluck('total', 'mes')
                ->toArray();

            $ordenesMensuales = [];
            for ($i = 1; $i <= 12; $i++) {
                $ordenesMensuales[] = $ordenesPorMes[$i] ?? 0;
            }

            return $ordenesMensuales;
        });

        return view('dashboard', array_merge($stats, ['ordenesMensuales' => $ordenesMensuales]));
    }
}
