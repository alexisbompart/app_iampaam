@extends('layouts.app')

@section('content')
<style>
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .table thead th {
        background-color: #2e7d32;
        color: white;
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    .table tbody tr:hover {
        background-color: #f1f8e9;
    }
    .search-container {
        background: white;
        border-radius: 12px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 1px solid #e8f5e8;
    }
    .section-header {
        color: #2e7d32;
        font-weight: 600;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #4caf50;
        margin-bottom: 1rem;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-success mb-1">
                <i class="fas fa-clipboard-list me-2"></i>Gestión de Órdenes
            </h1>
            <p class="text-muted mb-0">Instituto de Atención al Adulto Mayor y Protección a la Ancianidad</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('ordenes.create', 'entrada') }}" class="btn btn-success btn-lg">
                <i class="fas fa-arrow-down me-2"></i>Nueva Orden de Entrada
            </a>
            <a href="{{ route('ordenes.create', 'entrega') }}" class="btn btn-outline-success btn-lg">
                <i class="fas fa-arrow-up me-2"></i>Nueva Orden de Entrega
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h3 class="text-success">{{ $ordenesEntrada->count() }}</h3>
                    <p class="text-muted mb-0">Órdenes de Entrada</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h3 class="text-info">{{ $ordenesEntrega->count() }}</h3>
                    <p class="text-muted mb-0">Órdenes de Entrega</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <h3 class="text-warning">{{ $ordenesEntrada->count() + $ordenesEntrega->count() }}</h3>
                    <p class="text-muted mb-0">Total Órdenes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-secondary">
                <div class="card-body text-center">
                    <h3 class="text-secondary">{{ $ordenesEntrega->unique('beneficiario_id')->count() }}</h3>
                    <p class="text-muted mb-0">Beneficiarios Atendidos</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Órdenes de Entrada -->
    <div class="search-container mb-4">
        <h4 class="section-header">
            <i class="fas fa-arrow-circle-down me-2 text-success"></i>Órdenes de Entrada
        </h4>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>Observaciones</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ordenesEntrada as $orden)
                    <tr>
                        <td><span class="badge bg-secondary">{{ $orden->id }}</span></td>
                        <td>{{ $orden->fecha instanceof \Carbon\Carbon ? $orden->fecha->format('d/m/Y') : $orden->fecha }}</td>
                        <td><strong>{{ $orden->proveedor ?? 'No especificado' }}</strong></td>
                        <td><small class="text-muted">{{ Str::limit($orden->observaciones, 60) ?? '—' }}</small></td>
                        <td class="text-center">
                            <a href="{{ route('ordenes.show', ['tipo' => 'entrada', 'orden' => $orden]) }}" class="btn btn-sm btn-outline-info" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-3 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>No hay órdenes de entrada registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Órdenes de Entrega -->
    <div class="search-container">
        <h4 class="section-header">
            <i class="fas fa-arrow-circle-up me-2 text-info"></i>Órdenes de Entrega
        </h4>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Beneficiario</th>
                        <th>Observaciones</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ordenesEntrega as $orden)
                    <tr>
                        <td><span class="badge bg-secondary">{{ $orden->id }}</span></td>
                        <td>{{ $orden->fecha instanceof \Carbon\Carbon ? $orden->fecha->format('d/m/Y') : $orden->fecha }}</td>
                        <td><strong>{{ $orden->beneficiario->nombre ?? 'No especificado' }}</strong></td>
                        <td><small class="text-muted">{{ Str::limit($orden->observaciones, 60) ?? '—' }}</small></td>
                        <td class="text-center">
                            <a href="{{ route('ordenes.show', ['tipo' => 'entrega', 'orden' => $orden]) }}" class="btn btn-sm btn-outline-info" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-3 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>No hay órdenes de entrega registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
