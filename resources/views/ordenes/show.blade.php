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
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
    .header-card {
        background: linear-gradient(135deg, #4caf50, #2e7d32);
        color: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .table thead th {
        background-color: #2e7d32;
        color: white;
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
    }
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }
</style>

<div class="container-fluid">
    <!-- Header Card -->
    <div class="header-card">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h1 class="mb-2">
                    @if($tipo == 'entrada')
                        <i class="fas fa-arrow-circle-down me-3"></i>Orden de Entrada #{{ $orden->id }}
                    @else
                        <i class="fas fa-arrow-circle-up me-3"></i>Orden de Entrega #{{ $orden->id }}
                    @endif
                </h1>
                <p class="mb-2 fs-5">
                    <i class="fas fa-calendar me-2"></i>
                    {{ $orden->fecha instanceof \Carbon\Carbon ? $orden->fecha->format('d/m/Y') : $orden->fecha }}
                </p>
                @if($tipo == 'entrada' && $orden->proveedor)
                <p class="mb-0">
                    <i class="fas fa-truck me-2"></i>Proveedor: {{ $orden->proveedor }}
                </p>
                @elseif($tipo == 'entrega' && $orden->beneficiario)
                <p class="mb-0">
                    <i class="fas fa-user me-2"></i>Beneficiario: {{ $orden->beneficiario->nombre }}
                </p>
                @endif
            </div>
            <div class="text-end">
                <a href="{{ route('ordenes.index') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Información General -->
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-info-circle me-2"></i>Información General
        </h3>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Número de Orden</div>
                <div class="info-value">#{{ $orden->id }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tipo</div>
                <div class="info-value">
                    @if($tipo == 'entrada')
                        <span class="badge bg-success">Entrada</span>
                    @else
                        <span class="badge bg-info">Entrega</span>
                    @endif
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Fecha</div>
                <div class="info-value">{{ $orden->fecha instanceof \Carbon\Carbon ? $orden->fecha->format('d/m/Y') : $orden->fecha }}</div>
            </div>
            @if($tipo == 'entrada' && $orden->proveedor)
            <div class="info-item">
                <div class="info-label">Proveedor</div>
                <div class="info-value">{{ $orden->proveedor }}</div>
            </div>
            @elseif($tipo == 'entrega' && $orden->beneficiario)
            <div class="info-item">
                <div class="info-label">Beneficiario</div>
                <div class="info-value">
                    <a href="{{ route('beneficiarios.show', $orden->beneficiario) }}" class="text-success text-decoration-none">
                        {{ $orden->beneficiario->nombre }}
                    </a>
                </div>
            </div>
            @if($orden->beneficiario->cedula)
            <div class="info-item">
                <div class="info-label">Cédula del Beneficiario</div>
                <div class="info-value">{{ $orden->beneficiario->cedula }}</div>
            </div>
            @endif
            @endif
            @if($orden->observaciones)
            <div class="info-item">
                <div class="info-label">Observaciones</div>
                <div class="info-value">{{ $orden->observaciones }}</div>
            </div>
            @endif
            <div class="info-item">
                <div class="info-label">Fecha de Registro</div>
                <div class="info-value">{{ $orden->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>

    <!-- Productos -->
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-boxes me-2"></i>Productos de la Orden
            <span class="badge bg-success ms-2">{{ $orden->items->count() }} items</span>
        </h3>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Lote</th>
                        <th>Fecha Vencimiento</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orden->items as $item)
                    <tr>
                        <td><strong>{{ $item->producto->nombre ?? 'N/A' }}</strong></td>
                        <td>{{ $item->cantidad }} {{ $item->producto->unidad ?? '' }}</td>
                        <td>{{ $item->lote ?? '—' }}</td>
                        <td>
                            @if($item->fecha_vencimiento)
                                {{ $item->fecha_vencimiento instanceof \Carbon\Carbon ? $item->fecha_vencimiento->format('d/m/Y') : $item->fecha_vencimiento }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">Sin productos registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Botones -->
    <div class="text-center mb-4">
        <a href="{{ route('ordenes.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left me-2"></i>Volver al Listado
        </a>
    </div>
</div>
@endsection
