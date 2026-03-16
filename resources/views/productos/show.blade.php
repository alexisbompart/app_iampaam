@extends('layouts.app')

@section('content')
<style>
    .detail-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 1px solid #e8f5e8;
    }
    .section-title {
        color: #2e7d32;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #4caf50;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
    }
    .info-item {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #4caf50;
    }
    .info-label {
        font-weight: 600;
        color: #2e7d32;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value {
        color: #333;
        margin: 0;
        font-size: 1rem;
    }
    .badge-disponible {
        background-color: #4caf50;
        color: white;
    }
    .badge-agotado {
        background-color: #f44336;
        color: white;
    }
    .badge-bajo {
        background-color: #ff9800;
        color: white;
    }
    .header-card {
        background: linear-gradient(135deg, #4caf50, #2e7d32);
        color: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .beneficiario-tag {
        background: rgba(255,255,255,0.2);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.85rem;
        border: 1px solid rgba(255,255,255,0.3);
        display: inline-block;
        margin: 0.2rem;
    }
</style>

<div class="container-fluid">
    <!-- Header Card -->
    <div class="header-card">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-box me-3"></i>{{ $producto->nombre }}
                </h1>
                @if($producto->tipo)
                <p class="mb-2 fs-5">
                    <i class="fas fa-tag me-2"></i>Tipo: {{ $producto->tipo }}
                </p>
                @endif
                <div class="d-flex gap-3">
                    <span class="badge fs-6 px-3 py-2 bg-light text-dark">
                        <i class="fas fa-cubes me-1"></i>Stock: {{ $producto->stock }} {{ $producto->unidad }}
                    </span>
                    @if($producto->stock == 0)
                        <span class="badge fs-6 px-3 py-2 badge-agotado">
                            <i class="fas fa-circle me-1"></i>Agotado
                        </span>
                    @elseif($producto->stock <= 10)
                        <span class="badge fs-6 px-3 py-2 badge-bajo">
                            <i class="fas fa-circle me-1"></i>Stock Bajo
                        </span>
                    @else
                        <span class="badge fs-6 px-3 py-2 badge-disponible">
                            <i class="fas fa-circle me-1"></i>Disponible
                        </span>
                    @endif
                </div>
            </div>
            <div class="text-end">
                <div class="btn-group" role="group">
                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-light btn-lg">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del Producto -->
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-info-circle me-2"></i>Información del Producto
        </h3>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Nombre</div>
                <div class="info-value">{{ $producto->nombre }}</div>
            </div>
            @if($producto->tipo)
            <div class="info-item">
                <div class="info-label">Tipo</div>
                <div class="info-value">{{ $producto->tipo }}</div>
            </div>
            @endif
            @if($producto->descripcion)
            <div class="info-item">
                <div class="info-label">Descripción</div>
                <div class="info-value">{{ $producto->descripcion }}</div>
            </div>
            @endif
            @if($producto->proveedor)
            <div class="info-item">
                <div class="info-label">Proveedor</div>
                <div class="info-value">{{ $producto->proveedor }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Inventario -->
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-warehouse me-2"></i>Inventario
        </h3>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Stock Actual</div>
                <div class="info-value">{{ $producto->stock }} {{ $producto->unidad }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Unidad de Medida</div>
                <div class="info-value">{{ $producto->unidad ?? 'N/A' }}</div>
            </div>
            @if($producto->fecha_vencimiento)
            <div class="info-item">
                <div class="info-label">Fecha de Vencimiento</div>
                <div class="info-value">{{ $producto->fecha_vencimiento->format('d/m/Y') }}</div>
            </div>
            @endif
            <div class="info-item">
                <div class="info-label">Total Entregado</div>
                <div class="info-value">{{ $producto->ordenEntregaItems->sum('cantidad') }} {{ $producto->unidad }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Estado</div>
                <div class="info-value">
                    @if($producto->stock == 0)
                        <span class="badge badge-agotado">Agotado</span>
                    @elseif($producto->stock <= 10)
                        <span class="badge badge-bajo">Stock Bajo</span>
                    @else
                        <span class="badge badge-disponible">Disponible</span>
                    @endif
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Fecha de Registro</div>
                <div class="info-value">{{ $producto->created_at->format('d/m/Y H:i') }}</div>
            </div>
            @if($producto->updated_at != $producto->created_at)
            <div class="info-item">
                <div class="info-label">Última Actualización</div>
                <div class="info-value">{{ $producto->updated_at->format('d/m/Y H:i') }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Beneficiarios que han recibido este producto -->
    @php
        $beneficiariosUnicos = collect();
        foreach($producto->ordenEntregaItems as $item) {
            if($item->ordenEntrega && $item->ordenEntrega->beneficiario) {
                $beneficiariosUnicos->push($item->ordenEntrega->beneficiario);
            }
        }
        $beneficiariosUnicos = $beneficiariosUnicos->unique('id');
    @endphp

    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-users me-2"></i>Beneficiarios que han recibido este producto
            <span class="badge bg-success ms-2">{{ $beneficiariosUnicos->count() }}</span>
        </h3>
        @if($beneficiariosUnicos->count() > 0)
            <div class="d-flex flex-wrap gap-2">
                @foreach($beneficiariosUnicos as $beneficiario)
                    <a href="{{ route('beneficiarios.show', $beneficiario) }}" class="text-decoration-none">
                        <span style="background:#e8f5e8; color:#2e7d32; padding:0.35rem 0.75rem; border-radius:15px; font-size:0.85rem; border:1px solid #c8e6c9; display:inline-block;">
                            <i class="fas fa-user me-1"></i>{{ $beneficiario->nombre }}
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                No se ha entregado este producto a ningún beneficiario aún.
            </p>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="text-center mb-4">
        <div class="btn-group" role="group">
            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-lg">
                <i class="fas fa-edit me-2"></i>Editar Producto
            </a>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Volver al Listado
            </a>
        </div>
    </div>
</div>
@endsection
