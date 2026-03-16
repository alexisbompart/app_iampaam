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
    .badge-disponible {
        background-color: #4caf50;
    }
    .badge-agotado {
        background-color: #f44336;
    }
    .badge-bajo {
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
                <i class="fas fa-boxes me-2"></i>Gestión de Productos
            </h1>
            <p class="text-muted mb-0">Instituto de Atención al Adulto Mayor y Protección a la Ancianidad</p>
        </div>
        <a href="{{ route('productos.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus me-2"></i>Nuevo Producto
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h3 class="text-success">{{ $productos->count() }}</h3>
                    <p class="text-muted mb-0">Total Productos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h3 class="text-success">{{ $productos->where('stock', '>', 0)->count() }}</h3>
                    <p class="text-muted mb-0">Con Stock Disponible</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <h3 class="text-warning">{{ $productos->where('stock', '>', 0)->where('stock', '<=', 10)->count() }}</h3>
                    <p class="text-muted mb-0">Stock Bajo (≤10)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <h3 class="text-danger">{{ $productos->where('stock', 0)->count() }}</h3>
                    <p class="text-muted mb-0">Agotados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="search-container">
        <div class="row">
            <div class="col-md-8">
                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Buscar por nombre o tipo..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-success">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-4 text-end">
                <div class="btn-group" role="group">
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary {{ !request('filter') ? 'active' : '' }}">Todos</a>
                    <a href="{{ route('productos.index', ['filter' => 'disponibles']) }}" class="btn btn-outline-success {{ request('filter') == 'disponibles' ? 'active' : '' }}">Disponibles</a>
                    <a href="{{ route('productos.index', ['filter' => 'agotados']) }}" class="btn btn-outline-danger {{ request('filter') == 'agotados' ? 'active' : '' }}">Agotados</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Stock</th>
                    <th>Unidad</th>
                    <th>Proveedor</th>
                    <th>Vencimiento</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                <tr>
                    <td>
                        <span class="badge bg-secondary">{{ $producto->id }}</span>
                    </td>
                    <td>
                        <strong>{{ $producto->nombre }}</strong>
                        @if($producto->descripcion)
                            <br><small class="text-muted">{{ Str::limit($producto->descripcion, 50) }}</small>
                        @endif
                    </td>
                    <td>{{ $producto->tipo ?? 'N/A' }}</td>
                    <td>
                        <strong>{{ $producto->stock }}</strong>
                    </td>
                    <td>{{ $producto->unidad ?? 'N/A' }}</td>
                    <td>{{ $producto->proveedor ?? 'No registrado' }}</td>
                    <td>
                        @if($producto->fecha_vencimiento)
                            {{ $producto->fecha_vencimiento->format('d/m/Y') }}
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>
                        @if($producto->stock == 0)
                            <span class="badge badge-agotado">Agotado</span>
                        @elseif($producto->stock <= 10)
                            <span class="badge badge-bajo">Stock Bajo</span>
                        @else
                            <span class="badge badge-disponible">Disponible</span>
                        @endif
                    </td>
                    <td class="text-center btn-actions">
                        <div class="btn-group" role="group">
                            <a href="{{ route('productos.show', $producto) }}" class="btn btn-sm btn-outline-info" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de eliminar este producto?')">
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
                        <i class="fas fa-boxes fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No hay productos registrados</h5>
                        <p class="text-muted">Comience registrando su primer producto.</p>
                        <a href="{{ route('productos.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Registrar Primer Producto
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($productos, 'hasPages') && $productos->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $productos->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
