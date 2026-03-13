@extends('layouts.app')

@section('content')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #e8f5e8 0%, #f1f8e9 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .welcome-text {
        color: #2e7d32;
        font-weight: 300;
    }

    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 1px solid #e8f5e8;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        min-height: 170px;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .stats-beneficiarios .stats-icon { background: linear-gradient(135deg, #4caf50, #66bb6a); color: white; }
    .stats-productos .stats-icon { background: linear-gradient(135deg, #2196f3, #42a5f5); color: white; }
    .stats-entradas .stats-icon { background: linear-gradient(135deg, #ff9800, #ffb74d); color: white; }
    .stats-entregas .stats-icon { background: linear-gradient(135deg, #9c27b0, #ba68c8); color: white; }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2e7d32;
        margin-bottom: 0.5rem;
    }

    .stats-label {
        color: #558b2f;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .chart-container {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 1px solid #e8f5e8;
        position: relative;
        overflow: hidden;
    }

    .chart-container canvas {
        width: 100% !important;
        height: auto !important;
    }

    @media (max-width: 767px) {
        .chart-container {
            padding: 1.25rem;
        }

        .chart-title {
            font-size: 1.05rem;
        }

        .stats-number {
            font-size: 2rem;
        }

        .stats-card {
            padding: 1.25rem;
        }

        .dashboard-header {
            padding: 1.5rem;
        }

        .dashboard-header h1 {
            font-size: 2rem;
        }

        .actions-section {
            padding: 1.5rem;
        }
    }

    .chart-loading {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.85);
        z-index: 10;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        border-radius: 12px;
        gap: 0.5rem;
        font-weight: 600;
        color: #2e7d32;
    }

    .chart-title {
        color: #2e7d32;
        font-weight: 600;
        margin-bottom: 1.5rem;
        font-size: 1.25rem;
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
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 1px solid #e8f5e8;
        transition: all 0.3s ease;
        height: 100%;
    }

    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        border-color: #4caf50;
    }

    .action-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin: 0 auto 1rem;
    }

    .action-beneficiarios .action-icon { background: linear-gradient(135deg, #4caf50, #66bb6a); color: white; }
    .action-productos .action-icon { background: linear-gradient(135deg, #2196f3, #42a5f5); color: white; }
    .action-ordenes .action-icon { background: linear-gradient(135deg, #ff9800, #ffb74d); color: white; }
    .action-usuarios .action-icon { background: linear-gradient(135deg, #9c27b0, #ba68c8); color: white; }

    .action-title {
        color: #2e7d32;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .btn-custom {
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #4caf50, #66bb6a);
        border: none;
        color: white;
    }

    .btn-primary-custom:hover {
        background: linear-gradient(135deg, #388e3c, #4caf50);
        transform: translateY(-1px);
    }

    .btn-success-custom {
        background: linear-gradient(135deg, #66bb6a, #81c784);
        border: none;
        color: white;
    }

    .btn-success-custom:hover {
        background: linear-gradient(135deg, #4caf50, #66bb6a);
        transform: translateY(-1px);
    }

    .btn-warning-custom {
        background: linear-gradient(135deg, #ffb74d, #ffcc80);
        border: none;
        color: #333;
    }

    .btn-warning-custom:hover {
        background: linear-gradient(135deg, #ff9800, #ffb74d);
        transform: translateY(-1px);
    }
</style>

<div class="container-fluid">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold text-success mb-2">Bienvenido al Sistema IAMPAM</h1>
                <p class="welcome-text fs-5">Instituto de Atención al Adulto Mayor y Protección a la Ancianidad</p>
                <p class="text-muted">Gestiona eficientemente los beneficiarios, productos y órdenes de tu institución</p>
            </div>
            <div class="col-lg-4 text-center">
                <img src="{{ asset('image/logo.png') }}" alt="Logo IAMPAM" class="img-fluid" style="max-height: 120px;">
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card stats-beneficiarios">
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-number">{{ $totalBeneficiarios }}</div>
                <div class="stats-label">Beneficiarios Registrados</div>
                <small class="text-muted">Personas atendidas por la institución</small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card stats-productos">
                <div class="stats-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stats-number">{{ $totalProductos }}</div>
                <div class="stats-label">Productos en Inventario</div>
                <small class="text-muted">Artículos disponibles para distribución</small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card stats-entradas">
                <div class="stats-icon">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <div class="stats-number">{{ $totalOrdenesEntrada }}</div>
                <div class="stats-label">Órdenes de Entrada</div>
                <small class="text-muted">Recepción de productos y donaciones</small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card stats-entregas">
                <div class="stats-icon">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <div class="stats-number">{{ $totalOrdenesEntrega }}</div>
                <div class="stats-label">Órdenes de Entrega</div>
                <small class="text-muted">Distribución a beneficiarios</small>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="chart-container">
                <h3 class="chart-title">
                    <i class="fas fa-chart-pie me-2"></i>Distribución por Género
                </h3>
                <div id="generoChartLoader" class="chart-loading">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <div class="mt-2">Cargando gráfico...</div>
                </div>
                <canvas id="generoChart" height="300"></canvas>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="chart-container">
                <h3 class="chart-title">
                    <i class="fas fa-chart-bar me-2"></i>Estadísticas Generales
                </h3>
                <div id="generalChartLoader" class="chart-loading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <div class="mt-2">Cargando gráfico...</div>
                </div>
                <canvas id="generalChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Additional Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="chart-container">
                <h3 class="chart-title">
                    <i class="fas fa-chart-line me-2"></i>Órdenes de Entrega por Mes
                </h3>
                <div id="mensualesChartLoader" class="chart-loading">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <div class="mt-2">Cargando gráfico...</div>
                </div>
                <canvas id="ordenesMensualesChart" height="300"></canvas>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="chart-container">
                <h3 class="chart-title">
                    <i class="fas fa-chart-donut me-2"></i>Resumen Ejecutivo
                </h3>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="p-3">
                            <div class="display-4 text-warning">{{ $productosBajoStock }}</div>
                            <small class="text-muted">Productos con Stock Bajo</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3">
                            <div class="display-4 text-info">{{ $beneficiariosMayores }}</div>
                            <small class="text-muted">Adultos Mayores (65+ años)</small>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="p-3">
                            <div class="display-4 text-success">{{ $ordenesRecientes }}</div>
                            <small class="text-muted">Órdenes Recientes (30 días)</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3">
                            <div class="h4 text-primary">Estado del Sistema</div>
                            <small class="text-muted">Funcionando correctamente</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Section -->
    <div class="actions-section">
        <h2 class="text-center mb-4 text-success">
            <i class="fas fa-tasks me-2"></i>Acciones Disponibles
        </h2>
        <div class="row">
            @if(in_array(Auth::user()->role, ['admin', 'operador', 'consultor']))
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="action-card action-beneficiarios">
                        <div class="action-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="action-title">Beneficiarios</h5>
                        <a href="{{ route('beneficiarios.index') }}" class="btn btn-custom btn-primary-custom me-2 mb-2">
                            <i class="fas fa-list me-1"></i>Ver Listado
                        </a>
                        @if(in_array(Auth::user()->role, ['admin', 'operador']))
                            <br>
                            <a href="{{ route('beneficiarios.create') }}" class="btn btn-custom btn-success-custom">
                                <i class="fas fa-plus me-1"></i>Crear Nuevo
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            @if(in_array(Auth::user()->role, ['admin', 'operador']))
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="action-card action-productos">
                        <div class="action-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <h5 class="action-title">Productos</h5>
                        <a href="{{ route('productos.index') }}" class="btn btn-custom btn-primary-custom me-2 mb-2">
                            <i class="fas fa-list me-1"></i>Ver Inventario
                        </a>
                        <br>
                        <a href="{{ route('productos.create') }}" class="btn btn-custom btn-success-custom">
                            <i class="fas fa-plus me-1"></i>Agregar Producto
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="action-card action-ordenes">
                        <div class="action-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h5 class="action-title">Órdenes</h5>
                        <a href="{{ route('ordenes.index') }}" class="btn btn-custom btn-primary-custom me-2 mb-2">
                            <i class="fas fa-list me-1"></i>Ver Órdenes
                        </a>
                        <br>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('ordenes.create', 'entrada') }}" class="btn btn-custom btn-success-custom">
                                <i class="fas fa-arrow-down me-1"></i>Orden Entrada
                            </a>
                            <a href="{{ route('ordenes.create', 'entrega') }}" class="btn btn-custom btn-warning-custom">
                                <i class="fas fa-arrow-up me-1"></i>Orden Entrega
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if(Auth::user()->role == 'admin')
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="action-card action-usuarios">
                        <div class="action-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h5 class="action-title">Administración</h5>
                        <a href="{{ route('users.index') }}" class="btn btn-custom btn-primary-custom me-2 mb-2">
                            <i class="fas fa-users-cog me-1"></i>Gestionar Usuarios
                        </a>
                        <br>
                        <a href="{{ route('users.create') }}" class="btn btn-custom btn-success-custom">
                            <i class="fas fa-user-plus me-1"></i>Crear Usuario
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de distribución por género
    const ctxGenero = document.getElementById('generoChart').getContext('2d');
    const generoChart = new Chart(ctxGenero, {
        type: 'doughnut',
        data: {
            labels: ['Masculino', 'Femenino', 'Otro'],
            datasets: [{
                data: [{{ $masculino }}, {{ $femenino }}, {{ $otro }}],
                backgroundColor: [
                    'rgba(76, 175, 80, 0.8)',
                    'rgba(156, 39, 176, 0.8)',
                    'rgba(255, 152, 0, 0.8)'
                ],
                borderColor: [
                    'rgba(76, 175, 80, 1)',
                    'rgba(156, 39, 176, 1)',
                    'rgba(255, 152, 0, 1)'
                ],
                borderWidth: 2,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12,
                            family: "'Inter', sans-serif"
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    cornerRadius: 8,
                    displayColors: false
                }
            }
        }
    });
    document.getElementById('generoChartLoader').style.display = 'none';

    // Gráfico general de estadísticas
    const ctxGeneral = document.getElementById('generalChart').getContext('2d');
    const generalChart = new Chart(ctxGeneral, {
        type: 'bar',
        data: {
            labels: ['Beneficiarios', 'Productos', 'Órdenes Entrada', 'Órdenes Entrega'],
            datasets: [{
                label: 'Total',
                data: [{{ $totalBeneficiarios }}, {{ $totalProductos }}, {{ $totalOrdenesEntrada }}, {{ $totalOrdenesEntrega }}],
                backgroundColor: [
                    'rgba(76, 175, 80, 0.7)',
                    'rgba(33, 150, 243, 0.7)',
                    'rgba(255, 152, 0, 0.7)',
                    'rgba(156, 39, 176, 0.7)'
                ],
                borderColor: [
                    'rgba(76, 175, 80, 1)',
                    'rgba(33, 150, 243, 1)',
                    'rgba(255, 152, 0, 1)',
                    'rgba(156, 39, 176, 1)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 12,
                            family: "'Inter', sans-serif"
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12,
                            family: "'Inter', sans-serif"
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            return 'Total: ' + context.parsed.y;
                        }
                    }
                }
            }
        }
    });
    document.getElementById('generalChartLoader').style.display = 'none';

    // Gráfico de órdenes mensuales
    const ctxMensuales = document.getElementById('ordenesMensualesChart').getContext('2d');
    const ordenesMensualesChart = new Chart(ctxMensuales, {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            datasets: [{
                label: 'Órdenes de Entrega',
                data: @json($ordenesMensuales),
                borderColor: 'rgba(76, 175, 80, 1)',
                backgroundColor: 'rgba(76, 175, 80, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(76, 175, 80, 1)',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 12,
                            family: "'Inter', sans-serif"
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12,
                            family: "'Inter', sans-serif"
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        title: function(context) {
                            return 'Mes: ' + context[0].label;
                        },
                        label: function(context) {
                            return 'Órdenes: ' + context.parsed.y;
                        }
                    }
                }
            }
        }
    });
    // Remover el loader al terminar de renderizar
    document.getElementById('generoChartLoader').style.display = 'none';
    document.getElementById('generalChartLoader').style.display = 'none';
    document.getElementById('mensualesChartLoader').style.display = 'none';
</script>
@endsection
