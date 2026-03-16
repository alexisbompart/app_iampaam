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
    .badge-admin { background-color: #2e7d32; }
    .badge-operador { background-color: #2196f3; }
    .badge-consultor { background-color: #ff9800; }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-success mb-1">
                <i class="fas fa-users-cog me-2"></i>Gestión de Usuarios
            </h1>
            <p class="text-muted mb-0">Instituto de Atención al Adulto Mayor y Protección a la Ancianidad</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-user-plus me-2"></i>Nuevo Usuario
        </a>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h3 class="text-success">{{ $users->count() }}</h3>
                    <p class="text-muted mb-0">Total Usuarios</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h3 class="text-success">{{ $users->where('role', 'admin')->count() }}</h3>
                    <p class="text-muted mb-0">Administradores</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h3 class="text-info">{{ $users->where('role', 'operador')->count() }}</h3>
                    <p class="text-muted mb-0">Operadores</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <h3 class="text-warning">{{ $users->where('role', 'consultor')->count() }}</h3>
                    <p class="text-muted mb-0">Consultores</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Fecha de Registro</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td><span class="badge bg-secondary">{{ $user->id }}</span></td>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge badge-admin">Administrador</span>
                        @elseif($user->role == 'operador')
                            <span class="badge badge-operador">Operador</span>
                        @else
                            <span class="badge badge-consultor">Consultor</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de eliminar este usuario?')">
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
                    <td colspan="6" class="text-center py-4">
                        <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>
                        <h5 class="text-muted">No hay usuarios registrados</h5>
                        <a href="{{ route('users.create') }}" class="btn btn-success">
                            <i class="fas fa-user-plus me-2"></i>Crear Primer Usuario
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
