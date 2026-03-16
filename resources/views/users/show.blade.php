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
    .badge-admin { background-color: #2e7d32; }
    .badge-operador { background-color: #2196f3; }
    .badge-consultor { background-color: #ff9800; }
</style>

<div class="container-fluid">
    <!-- Header Card -->
    <div class="header-card">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-user-circle me-3"></i>{{ $user->name }}
                </h1>
                <p class="mb-2 fs-5">
                    <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                </p>
                <span class="badge fs-6 px-3 py-2 badge-{{ $user->role }}">
                    @if($user->role == 'admin') Administrador
                    @elseif($user->role == 'operador') Operador
                    @else Consultor
                    @endif
                </span>
            </div>
            <div class="text-end">
                <div class="btn-group" role="group">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-light btn-lg">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Datos del Usuario -->
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-id-card me-2"></i>Datos del Usuario
        </h3>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Nombre Completo</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Correo Electrónico</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Rol</div>
                <div class="info-value">
                    @if($user->role == 'admin')
                        <span class="badge badge-admin">Administrador</span>
                    @elseif($user->role == 'operador')
                        <span class="badge badge-operador">Operador</span>
                    @else
                        <span class="badge badge-consultor">Consultor</span>
                    @endif
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Fecha de Registro</div>
                <div class="info-value">{{ $user->created_at->format('d/m/Y H:i') }}</div>
            </div>
            @if($user->updated_at != $user->created_at)
            <div class="info-item">
                <div class="info-label">Última Actualización</div>
                <div class="info-value">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Botones -->
    <div class="text-center mb-4">
        <div class="btn-group" role="group">
            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-lg">
                <i class="fas fa-edit me-2"></i>Editar Usuario
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Volver al Listado
            </a>
        </div>
    </div>
</div>
@endsection
