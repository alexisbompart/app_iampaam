@extends('layouts.app')

@section('content')
<style>
    .productos-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    .productos-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .productos-header {
        background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    .productos-content {
        padding: 2rem;
    }
    .producto-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #4caf50;
        transition: all 0.3s ease;
    }
    .producto-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .producto-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .producto-nombre {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2e7d32;
        margin: 0;
    }
    .producto-stats {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .stat-item {
        background: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        text-align: center;
        min-width: 80px;
    }
    .stat-value {
        font-weight: 600;
        color: #2e7d32;
        display: block;
    }
    .stat-label {
        font-size: 0.8rem;
        color: #666;
    }
    .beneficiarios-section {
        margin-top: 1rem;
    }
    .beneficiarios-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    .beneficiarios-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .beneficiario-tag {
        background: #e8f5e8;
        color: #2e7d32;
        padding: 0.25rem 0.5rem;
        border-radius: 15px;
        font-size: 0.8rem;
        border: 1px solid #c8e6c9;
    }
    .no-beneficiarios {
        color: #666;
        font-style: italic;
        font-size: 0.9rem;
    }
    .acciones-btn {
        background: #4caf50;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: background 0.3s ease;
    }
    .acciones-btn:hover {
        background: #45a049;
        color: white;
        text-decoration: none;
    }
    .acciones-btn-danger {
        background: #f44336;
    }
    .acciones-btn-danger:hover {
        background: #d32f2f;
    }
    .acciones-btn-warning {
        background: #ff9800;
    }
    .acciones-btn-warning:hover {
        background: #f57c00;
    }
    .acciones-btn-info {
        background: #2196f3;
    }
    .acciones-btn-info:hover {
        background: #1976d2;
    }
    .create-btn {
        background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);
        border: none;
        padding: 1rem 2rem;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    }
    .create-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        color: white;
        text-decoration: none;
    }
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #666;
    }
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
</style>

<div class="productos-container">
    <div class="container-fluid">
        <div class="productos-card">
            <div class="productos-header">
                <h1 class="mb-0">
                    <i class="fas fa-boxes me-3"></i>
                    Gestión de Productos
                </h1>
                <p class="mb-0 mt-2">Instituto de Atención al Adulto Mayor y Protección a la Ancianidad</p>
            </div>

            <div class="productos-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Lista de Productos
                    </h3>
                    <a href="{{ route('productos.create') }}" class="create-btn">
                        <i class="fas fa-plus me-2"></i>
                        Crear Producto
                    </a>
                </div>

                @if($productos->count() > 0)
                    @foreach($productos as $producto)
                        <div class="producto-item">
                            <div class="producto-header">
                                <h4 class="producto-nombre">
                                    <i class="fas fa-box me-2"></i>
                                    {{ $producto->nombre }}
                                </h4>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('productos.show', $producto) }}" class="acciones-btn acciones-btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('productos.edit', $producto) }}" class="acciones-btn acciones-btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="acciones-btn acciones-btn-danger" onclick="return confirm('¿Está seguro de eliminar este producto?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="producto-stats">
                                <div class="stat-item">
                                    <span class="stat-value">{{ $producto->tipo ?? 'N/A' }}</span>
                                    <span class="stat-label">Tipo</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-value">{{ $producto->stock }}</span>
                                    <span class="stat-label">Stock</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-value">{{ $producto->unidad ?? 'N/A' }}</span>
                                    <span class="stat-label">Unidad</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-value">{{ $producto->ordenEntregaItems->sum('cantidad') }}</span>
                                    <span class="stat-label">Entregado</span>
                                </div>
                                @if($producto->fecha_vencimiento)
                                    <div class="stat-item">
                                        <span class="stat-value">{{ $producto->fecha_vencimiento->format('d/m/Y') }}</span>
                                        <span class="stat-label">Vencimiento</span>
                                    </div>
                                @endif
                            </div>

                            @if($producto->descripcion)
                                <p class="mb-3 text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    {{ $producto->descripcion }}
                                </p>
                            @endif

                            <div class="beneficiarios-section">
                                <div class="beneficiarios-title">
                                    <i class="fas fa-users me-1"></i>
                                    Beneficiarios que han recibido este producto:
                                </div>
                                @php
                                    $beneficiariosUnicos = collect();
                                    foreach($producto->ordenEntregaItems as $item) {
                                        if($item->ordenEntrega && $item->ordenEntrega->beneficiario) {
                                            $beneficiariosUnicos->push($item->ordenEntrega->beneficiario);
                                        }
                                    }
                                    $beneficiariosUnicos = $beneficiariosUnicos->unique('id')->take(5);
                                @endphp

                                @if($beneficiariosUnicos->count() > 0)
                                    <div class="beneficiarios-list">
                                        @foreach($beneficiariosUnicos as $beneficiario)
                                            <span class="beneficiario-tag">
                                                <i class="fas fa-user me-1"></i>
                                                {{ $beneficiario->nombre }}
                                            </span>
                                        @endforeach
                                        @php
                                            $totalBeneficiarios = collect();
                                            foreach($producto->ordenEntregaItems as $item) {
                                                if($item->ordenEntrega && $item->ordenEntrega->beneficiario) {
                                                    $totalBeneficiarios->push($item->ordenEntrega->beneficiario);
                                                }
                                            }
                                            $totalUnicos = $totalBeneficiarios->unique('id')->count();
                                        @endphp
                                        @if($totalUnicos > 5)
                                            <span class="beneficiario-tag">
                                                <i class="fas fa-plus me-1"></i>
                                                +{{ $totalUnicos - 5 }} más
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <div class="no-beneficiarios">
                                        <i class="fas fa-info-circle me-1"></i>
                                        No se ha entregado a ningún beneficiario aún
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <h4>No hay productos registrados</h4>
                        <p>Comience creando su primer producto para el inventario</p>
                        <a href="{{ route('productos.create') }}" class="create-btn">
                            <i class="fas fa-plus me-2"></i>
                            Crear Primer Producto
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
