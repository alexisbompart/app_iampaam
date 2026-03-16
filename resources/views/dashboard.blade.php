@extends('layouts.app')

@section('content')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #2e7d32 0%, #4caf50 60%, #66bb6a 100%);
        border-radius: 15px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 6px 20px rgba(46, 125, 50, 0.3);
        color: white;
    }

    .dashboard-header h1 {
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 0.25rem;
    }

    .dashboard-header p {
        opacity: 0.9;
        margin-bottom: 0;
    }

    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
        border: 1px solid #e8f5e8;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .stats-icon {
        width: 58px;
        height: 58px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        flex-shrink: 0;
    }

    .stats-beneficiarios .stats-icon { background: linear-gradient(135deg, #4caf50, #66bb6a); color: white; }
    .stats-productos .stats-icon     { background: linear-gradient(135deg, #1976d2, #42a5f5); color: white; }
    .stats-entradas .stats-icon      { background: linear-gradient(135deg, #e65100, #ffb74d); color: white; }
    .stats-entregas .stats-icon      { background: linear-gradient(135deg, #6a1b9a, #ce93d8); color: white; }

    .stats-info .stats-number {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1b5e20;
        line-height: 1;
        margin-bottom: 0.2rem;
    }

    .stats-info .stats-label {
        color: #558b2f;
        font-weight: 600;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stats-info small {
        color: #9e9e9e;
        font-size: 0.78rem;
    }

    .chart-container {
        background: white;
        border-radius: 14px;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
        border: 1px solid #e8f5e8;
    }

    .chart-title {
        color: #2e7d32;
        font-weight: 600;
        margin-bottom: 1.25rem;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e8f5e8;
    }

    .chart-wrapper {
        position: relative;
        height: 280px;
    }

    .summary-card {
        background: white;
        border-radius: 14px;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
        border: 1px solid #e8f5e8;
    }

    .summary-stat {
        text-align: center;
        padding: 1rem;
        border-radius: 10px;
        background: #f8fdf8;
        border: 1px solid #e8f5e8;
    }

    .summary-stat .number {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.3rem;
    }

    .summary-stat small {
        color: #666;
        font-size: 0.8rem;
    }

    .actions-section {
        background: linear-gradient(135deg, #f1f8e9 0%, #e8f5e8 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .action-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        border: 1px solid #e8f5e8;
        transition: all 0.3s ease;
        height: 100%;
    }

    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        border-color: #4caf50;
    }

    .action-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin: 0 auto 1rem;
    }

    .action-beneficiarios .action-icon { background: linear-gradient(135deg, #4caf50, #66bb6a); color: white; }
    .action-productos .action-icon     { background: linear-gradient(135deg, #1976d2, #42a5f5); color: white; }
    .action-ordenes .action-icon       { background: linear-gradient(135deg, #e65100, #ffb74d); color: white; }
    .action-usuarios .action-icon      { background: linear-gradient(135deg, #6a1b9a, #ce93d8); color: white; }

    .action-title {
        color: #2e7d32;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.05rem;
    }

    .btn-action {
        border-radius: 20px;
        padding: 0.4rem 1.1rem;
        font-size: 0.82rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    @media (max-width: 767px) {
        .dashboard-header h1 { font-size: 1.5rem; }
        .chart-wrapper { height: 220px; }
        .stats-card { padding: 1rem; }
    }
</style>

<div class="container-fluid">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1><i class="fas fa-tachometer-alt me-2"></i>Panel de Control</h1>
                <p class="fs-6">Instituto de Atención al Adulto Mayor y Protección a la Ancianidad</p>
                <p style="opacity:0.75; font-size:0.9rem; margin-top:0.5rem;">
                    <i class="fas fa-calendar-alt me-1"></i>{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                    &nbsp;|&nbsp;
                    <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                </p>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <img src="{{ asset('image/logo.png') }}" alt="Logo IAMPAM" class="img-fluid" style="max-height: 100px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2)); background:rgba(255,255,255,0.15); border-radius:10px; padding:6px;">
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-2">
        <div class="col-xl-3 col-md-6 mb-3">
            <a href="{{ route('beneficiarios.index') }}" class="text-decoration-none">
                <div class="stats-card stats-beneficiarios">
                    <div class="stats-icon"><i class="fas fa-users"></i></div>
                    <div class="stats-info">
                        <div class="stats-number">{{ $totalBeneficiarios }}</div>
                        <div class="stats-label">Beneficiarios</div>
                        <small>Personas registradas</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <a href="{{ route('productos.index') }}" class="text-decoration-none">
                <div class="stats-card stats-productos">
                    <div class="stats-icon"><i class="fas fa-boxes"></i></div>
                    <div class="stats-info">
                        <div class="stats-number">{{ $totalProductos }}</div>
                        <div class="stats-label">Productos</div>
                        <small>En inventario</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <a href="{{ route('ordenes.index') }}" class="text-decoration-none">
                <div class="stats-card stats-entradas">
                    <div class="stats-icon"><i class="fas fa-arrow-circle-down"></i></div>
                    <div class="stats-info">
                        <div class="stats-number">{{ $totalOrdenesEntrada }}</div>
                        <div class="stats-label">Órdenes Entrada</div>
                        <small>Recepciones registradas</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <a href="{{ route('ordenes.index') }}" class="text-decoration-none">
                <div class="stats-card stats-entregas">
                    <div class="stats-icon"><i class="fas fa-arrow-circle-up"></i></div>
                    <div class="stats-info">
                        <div class="stats-number">{{ $totalOrdenesEntrega }}</div>
                        <div class="stats-label">Órdenes Entrega</div>
                        <small>Distribuciones realizadas</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row mb-1">
        <!-- Gender Doughnut -->
        <div class="col-lg-5 mb-4">
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-venus-mars text-success"></i>Distribución por Género
                </div>
                <div class="chart-wrapper">
                    <canvas id="generoChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Product Stock Doughnut -->
        <div class="col-lg-7 mb-4">
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-boxes text-primary"></i>Estado del Inventario de Productos
                </div>
                <div class="chart-wrapper">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row mb-1">
        <!-- Monthly Orders Line -->
        <div class="col-lg-8 mb-4">
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-chart-line text-warning"></i>Órdenes de Entrega por Mes ({{ date('Y') }})
                </div>
                <div class="chart-wrapper">
                    <canvas id="ordenesMensualesChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Summary Stats -->
        <div class="col-lg-4 mb-4">
            <div class="summary-card h-100">
                <div class="chart-title">
                    <i class="fas fa-clipboard-check text-success"></i>Resumen Ejecutivo
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="summary-stat">
                            <div class="number text-warning">{{ $productosBajoStock }}</div>
                            <small>Productos<br>Stock Bajo</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="summary-stat">
                            <div class="number text-danger">{{ $productosAgotados }}</div>
                            <small>Productos<br>Agotados</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="summary-stat">
                            <div class="number text-info">{{ $beneficiariosMayores }}</div>
                            <small>Adultos<br>Mayores 65+</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="summary-stat">
                            <div class="number text-success">{{ $ordenesRecientes }}</div>
                            <small>Entregas<br>Últimos 30 días</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="summary-stat" style="background: linear-gradient(135deg, #e8f5e8, #f1f8e9);">
                            <div class="number text-success" style="font-size:1.4rem;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <small class="text-success fw-bold">Sistema Operativo</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Section -->
    <div class="actions-section">
        <h4 class="text-center mb-4 text-success fw-bold">
            <i class="fas fa-tasks me-2"></i>Acciones Rápidas
        </h4>
        <div class="row justify-content-center">
            @if(in_array(Auth::user()->role, ['admin', 'operador', 'consultor']))
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="action-card action-beneficiarios">
                        <div class="action-icon"><i class="fas fa-users"></i></div>
                        <h5 class="action-title">Beneficiarios</h5>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('beneficiarios.index') }}" class="btn btn-success btn-action">
                                <i class="fas fa-list me-1"></i>Ver Listado
                            </a>
                            @if(in_array(Auth::user()->role, ['admin', 'operador']))
                                <a href="{{ route('beneficiarios.create') }}" class="btn btn-outline-success btn-action">
                                    <i class="fas fa-plus me-1"></i>Crear Nuevo
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if(in_array(Auth::user()->role, ['admin', 'operador']))
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="action-card action-productos">
                        <div class="action-icon"><i class="fas fa-boxes"></i></div>
                        <h5 class="action-title">Productos</h5>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('productos.index') }}" class="btn btn-primary btn-action">
                                <i class="fas fa-list me-1"></i>Ver Inventario
                            </a>
                            <a href="{{ route('productos.create') }}" class="btn btn-outline-primary btn-action">
                                <i class="fas fa-plus me-1"></i>Agregar Producto
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="action-card action-ordenes">
                        <div class="action-icon"><i class="fas fa-clipboard-list"></i></div>
                        <h5 class="action-title">Órdenes</h5>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('ordenes.index') }}" class="btn btn-warning btn-action">
                                <i class="fas fa-list me-1"></i>Ver Órdenes
                            </a>
                            <a href="{{ route('ordenes.create', 'entrada') }}" class="btn btn-outline-warning btn-action">
                                <i class="fas fa-arrow-down me-1"></i>Orden Entrada
                            </a>
                            <a href="{{ route('ordenes.create', 'entrega') }}" class="btn btn-outline-secondary btn-action">
                                <i class="fas fa-arrow-up me-1"></i>Orden Entrega
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if(Auth::user()->role == 'admin')
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="action-card action-usuarios">
                        <div class="action-icon"><i class="fas fa-user-shield"></i></div>
                        <h5 class="action-title">Usuarios</h5>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('users.index') }}" class="btn btn-action" style="background: linear-gradient(135deg, #6a1b9a, #9c27b0); color:white; border:none;">
                                <i class="fas fa-users-cog me-1"></i>Gestionar
                            </a>
                            <a href="{{ route('users.create') }}" class="btn btn-outline-secondary btn-action">
                                <i class="fas fa-user-plus me-1"></i>Crear Usuario
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Segoe UI', Roboto, sans-serif";

    // ── 1. Gráfico de género (doughnut) ──────────────────────────────────────
    new Chart(document.getElementById('generoChart'), {
        type: 'doughnut',
        data: {
            labels: ['Masculino', 'Femenino', 'Otro / N/E'],
            datasets: [{
                data: [{{ $masculino }}, {{ $femenino }}, {{ $otro }}],
                backgroundColor: ['rgba(33,150,243,0.85)', 'rgba(233,30,99,0.85)', 'rgba(255,152,0,0.85)'],
                borderColor:     ['rgba(33,150,243,1)',    'rgba(233,30,99,1)',    'rgba(255,152,0,1)'],
                borderWidth: 2,
                hoverOffset: 12
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 20, usePointStyle: true, font: { size: 13 } }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    cornerRadius: 8,
                    callbacks: {
                        label: function(ctx) {
                            const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            const pct = total > 0 ? Math.round(ctx.parsed / total * 100) : 0;
                            return ` ${ctx.label}: ${ctx.parsed} (${pct}%)`;
                        }
                    }
                }
            }
        }
    });

    // ── 2. Gráfico de stock de productos (bar horizontal) ────────────────────
    new Chart(document.getElementById('stockChart'), {
        type: 'bar',
        data: {
            labels: ['Disponible (>10)', 'Stock Bajo (1-10)', 'Agotado (0)'],
            datasets: [{
                label: 'Productos',
                data: [{{ $productosDisponibles }}, {{ $productosBajoStock }}, {{ $productosAgotados }}],
                backgroundColor: [
                    'rgba(76,175,80,0.8)',
                    'rgba(255,152,0,0.8)',
                    'rgba(244,67,54,0.8)'
                ],
                borderColor: [
                    'rgba(76,175,80,1)',
                    'rgba(255,152,0,1)',
                    'rgba(244,67,54,1)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: { stepSize: 1 }
                },
                y: { grid: { display: false } }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    cornerRadius: 8,
                    callbacks: {
                        label: function(ctx) { return ` ${ctx.parsed.x} producto(s)`; }
                    }
                }
            }
        }
    });

    // ── 3. Gráfico de órdenes por mes (line) ─────────────────────────────────
    new Chart(document.getElementById('ordenesMensualesChart'), {
        type: 'line',
        data: {
            labels: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            datasets: [{
                label: 'Órdenes de Entrega',
                data: @json($ordenesMensuales),
                borderColor: 'rgba(76,175,80,1)',
                backgroundColor: 'rgba(76,175,80,0.12)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(46,125,50,1)',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 9
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: { stepSize: 1 }
                },
                x: { grid: { display: false } }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    cornerRadius: 8,
                    callbacks: {
                        title: function(ctx) { return ctx[0].label; },
                        label: function(ctx) { return ` Entregas: ${ctx.parsed.y}`; }
                    }
                }
            }
        }
    });
</script>
@endsection
