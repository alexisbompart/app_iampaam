@extends('layouts.app')

@section('content')
<style>
    .form-section {
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
</style>

<div class="container-fluid">
    <div class="form-section">
        <h1 class="text-center mb-4" style="color: #2e7d32;">
            <i class="fas fa-user-plus me-2"></i>Crear Nuevo Usuario
        </h1>
        <p class="text-center text-muted mb-4">Instituto de Atención al Adulto Mayor y Protección a la Ancianidad</p>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <!-- Datos del Usuario -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-id-card me-2"></i>Datos del Usuario
                </h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre Completo *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Correo Electrónico *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Contraseña *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="form-label">Rol *</label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Seleccionar rol...</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="operador" {{ old('role') == 'operador' ? 'selected' : '' }}>Operador</option>
                            <option value="consultor" {{ old('role') == 'consultor' ? 'selected' : '' }}>Consultor</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="text-center">
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save me-2"></i>Crear Usuario
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
