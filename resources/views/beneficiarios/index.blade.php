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
    .btn-productos-otorgados {
        background: linear-gradient(135deg, #1976d2, #42a5f5);
        border: none;
        color: white;
    }
    .btn-productos-otorgados:hover {
        background: linear-gradient(135deg, #1565c0, #1976d2);
        color: white;
    }
    #modalProductosTabla th {
        background-color: #2e7d32;
        color: white;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    .modal-header-custom {
        background: linear-gradient(135deg, #2e7d32, #4caf50);
        color: white;
        border-radius: 0;
    }
    .modal-header-custom .btn-close {
        filter: invert(1);
    }
    .badge-cantidad {
        background-color: #1976d2;
        font-size: 0.85rem;
        padding: 0.3rem 0.6rem;
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
                        @php
                            $entregas = $beneficiario->ordenEntregas->flatMap(function($orden) {
                                return $orden->items->map(function($item) use ($orden) {
                                    return [
                                        'orden_id' => $orden->id,
                                        'fecha'    => $orden->fecha
                                                        ? \Carbon\Carbon::parse($orden->fecha)->format('d/m/Y')
                                                        : $orden->created_at->format('d/m/Y'),
                                        'producto' => $item->producto ? $item->producto->nombre : 'Producto eliminado',
                                        'cantidad' => $item->cantidad,
                                        'lote'     => $item->lote ?? '—',
                                    ];
                                });
                            })->values()->toArray();
                        @endphp
                        <div class="btn-group" role="group">
                            <button type="button"
                                class="btn btn-sm btn-productos-otorgados"
                                title="Productos otorgados"
                                data-bs-toggle="modal"
                                data-bs-target="#modalProductos"
                                data-nombre="{{ $beneficiario->nombre }}"
                                data-cedula="{{ $beneficiario->cedula ?? 'S/N' }}"
                                data-productos='@json($entregas)'>
                                <i class="fas fa-gift"></i>
                            </button>
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

<!-- Modal: Productos Otorgados -->
<div class="modal fade" id="modalProductos" tabindex="-1" aria-labelledby="modalProductosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <div>
                    <h5 class="modal-title mb-0" id="modalProductosLabel">
                        <i class="fas fa-gift me-2"></i>Productos Otorgados
                    </h5>
                    <small id="modalSubtitulo" class="opacity-75"></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Sin entregas -->
                <div id="modalSinEntregas" class="text-center py-5 d-none">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Este beneficiario no tiene productos otorgados</h6>
                </div>
                <!-- Tabla de productos -->
                <div id="modalConEntregas">
                    <div class="px-3 pt-3 pb-1">
                        <span class="badge bg-success me-1" id="modalTotalOrdenes"></span>
                        <span class="badge bg-primary" id="modalTotalProductos"></span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="modalProductosTabla">
                            <thead>
                                <tr>
                                    <th style="width:110px;">Fecha</th>
                                    <th>Producto</th>
                                    <th style="width:90px;" class="text-center">Cantidad</th>
                                    <th style="width:120px;">Lote</th>
                                    <th style="width:80px;" class="text-center">Orden</th>
                                </tr>
                            </thead>
                            <tbody id="modalProductosTbody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('modalProductos').addEventListener('show.bs.modal', function (e) {
    const btn       = e.relatedTarget;
    const nombre    = btn.dataset.nombre;
    const cedula    = btn.dataset.cedula;
    const productos = JSON.parse(btn.dataset.productos || '[]');

    document.getElementById('modalProductosLabel').innerHTML =
        '<i class="fas fa-gift me-2"></i>Productos Otorgados';
    document.getElementById('modalSubtitulo').textContent =
        nombre + ' — C.I.: ' + cedula;

    const sinEntregas   = document.getElementById('modalSinEntregas');
    const conEntregas   = document.getElementById('modalConEntregas');
    const tbody         = document.getElementById('modalProductosTbody');
    const badgeOrdenes  = document.getElementById('modalTotalOrdenes');
    const badgeProductos= document.getElementById('modalTotalProductos');

    tbody.innerHTML = '';

    if (productos.length === 0) {
        sinEntregas.classList.remove('d-none');
        conEntregas.classList.add('d-none');
        return;
    }

    sinEntregas.classList.add('d-none');
    conEntregas.classList.remove('d-none');

    const ordenesUnicas = new Set(productos.map(p => p.orden_id)).size;
    badgeOrdenes.textContent  = ordenesUnicas + ' orden(es) de entrega';
    badgeProductos.textContent = productos.length + ' ítem(s) en total';

    productos.forEach(function(p) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><small>${p.fecha}</small></td>
            <td><strong>${p.producto}</strong></td>
            <td class="text-center"><span class="badge badge-cantidad">${p.cantidad}</span></td>
            <td><small class="text-muted">${p.lote}</small></td>
            <td class="text-center"><small class="badge bg-secondary">#${p.orden_id}</small></td>
        `;
        tbody.appendChild(tr);
    });
});
</script>
@endsection
