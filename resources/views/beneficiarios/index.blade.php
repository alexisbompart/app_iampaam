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
    .badge-activo {
        background-color: #4caf50;
    }
    .badge-inactivo {
        background-color: #f44336;
    }
    .badge-suspendido {
        background-color: #ff9800;
    }
    .btn-actions {
        white-space: nowrap;
    }
    .search-container {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 1px solid #e8f5e8;
    }
</style>

<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-success mb-1">
                <i class="fas fa-users me-2"></i>Gestión de Beneficiarios
            </h1>
            <p class="text-muted mb-0">Instituto de Atención al Adulto Mayor y Protección a la Ancianidad</p>
        </div>
        <a href="{{ route('beneficiarios.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus me-2"></i>Nuevo Beneficiario
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h3 class="text-success">{{ $beneficiarios->count() }}</h3>
                    <p class="text-muted mb-0">Total Beneficiarios</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h3 class="text-success">{{ $beneficiarios->where('estado_beneficiario', 'activo')->count() }}</h3>
                    <p class="text-muted mb-0">Beneficiarios Activos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <h3 class="text-warning">{{ $beneficiarios->where('genero', 'femenino')->count() }}</h3>
                    <p class="text-muted mb-0">Mujeres</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h3 class="text-info">{{ $beneficiarios->where('genero', 'masculino')->count() }}</h3>
                    <p class="text-muted mb-0">Hombres</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="search-container">
        <div class="row">
            <div class="col-md-8">
                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Buscar por nombre o cédula..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-success">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-4 text-end">
                <div class="btn-group" role="group">
                    <a href="{{ route('beneficiarios.index') }}" class="btn btn-outline-secondary {{ !request('filter') ? 'active' : '' }}">Todos</a>
                    <a href="{{ route('beneficiarios.index', ['filter' => 'activos']) }}" class="btn btn-outline-success {{ request('filter') == 'activos' ? 'active' : '' }}">Activos</a>
                    <a href="{{ route('beneficiarios.index', ['filter' => 'inactivos']) }}" class="btn btn-outline-danger {{ request('filter') == 'inactivos' ? 'active' : '' }}">Inactivos</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Beneficiaries Table -->
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Cédula</th>
                    <th>Edad</th>
                    <th>Género</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Fecha Registro</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($beneficiarios as $beneficiario)
                <tr>
                    <td>
                        <span class="badge bg-secondary">{{ $beneficiario->id }}</span>
                    </td>
                    <td>
                        <strong>{{ $beneficiario->nombre }}</strong>
                        @if($beneficiario->persona_referencia)
                            <br><small class="text-muted">Ref: {{ $beneficiario->persona_referencia }}</small>
                        @endif
                    </td>
                    <td>{{ $beneficiario->cedula ?? 'No registrada' }}</td>
                    <td>
                        @if($beneficiario->edad)
                            {{ $beneficiario->edad }} años
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if($beneficiario->genero == 'masculino')
                            <i class="fas fa-mars text-primary"></i> Masculino
                        @elseif($beneficiario->genero == 'femenino')
                            <i class="fas fa-venus text-danger"></i> Femenino
                        @else
                            <i class="fas fa-genderless text-secondary"></i> Otro
                        @endif
                    </td>
                    <td>
                        {{ $beneficiario->telefono ?? 'No registrado' }}
                        @if($beneficiario->telefono_alternativo)
                            <br><small class="text-muted">Alt: {{ $beneficiario->telefono_alternativo }}</small>
                        @endif
                    </td>
                    <td>
                        @if($beneficiario->estado_beneficiario == 'activo')
                            <span class="badge badge-activo">Activo</span>
                        @elseif($beneficiario->estado_beneficiario == 'inactivo')
                            <span class="badge badge-inactivo">Inactivo</span>
                        @else
                            <span class="badge badge-suspendido">Suspendido</span>
                        @endif
                    </td>
                    <td>
                        @if($beneficiario->fecha_ingreso)
                            {{ $beneficiario->fecha_ingreso->format('d/m/Y') }}
                        @else
                            {{ $beneficiario->created_at->format('d/m/Y') }}
                        @endif
                    </td>
                    <td class="text-center btn-actions">
                        <div class="btn-group" role="group">
                            <a href="{{ route('beneficiarios.show', $beneficiario) }}" class="btn btn-sm btn-outline-info" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('beneficiarios.edit', $beneficiario) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('beneficiarios.destroy', $beneficiario) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de eliminar este beneficiario?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No hay beneficiarios registrados</h5>
                        <p class="text-muted">Comience registrando su primer beneficiario.</p>
                        <a href="{{ route('beneficiarios.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Registrar Primer Beneficiario
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($beneficiarios->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $beneficiarios->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
