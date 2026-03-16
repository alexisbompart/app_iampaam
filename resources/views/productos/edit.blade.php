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
            <i class="fas fa-edit me-2"></i>Editar Producto
        </h1>
        <p class="text-center text-muted mb-4">Instituto de Atención al Adulto Mayor y Protección a la Ancianidad</p>

        <form action="{{ route('productos.update', $producto) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Información del Producto -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle me-2"></i>Información del Producto
                </h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre del Producto *</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                        @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tipo" class="form-label">Tipo *</label>
                        <input type="text" class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" value="{{ old('tipo', $producto->tipo) }}" required>
                        @error('tipo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Inventario -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-warehouse me-2"></i>Inventario y Proveedor
                </h3>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="stock" class="form-label">Stock *</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $producto->stock) }}" min="0" required>
                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="unidad" class="form-label">Unidad de Medida *</label>
                        <input type="text" class="form-control @error('unidad') is-invalid @enderror" id="unidad" name="unidad" value="{{ old('unidad', $producto->unidad) }}" placeholder="ej: kg, litros, unidades" required>
                        @error('unidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                        <input type="date" class="form-control @error('fecha_vencimiento') is-invalid @enderror" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento', $producto->fecha_vencimiento ? $producto->fecha_vencimiento->format('Y-m-d') : '') }}">
                        @error('fecha_vencimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="proveedor" class="form-label">Proveedor</label>
                        <input type="text" class="form-control @error('proveedor') is-invalid @enderror" id="proveedor" name="proveedor" value="{{ old('proveedor', $producto->proveedor) }}">
                        @error('proveedor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="text-center">
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-warning btn-lg">
                        <i class="fas fa-save me-2"></i>Actualizar Producto
                    </button>
                    <a href="{{ route('productos.show', $producto) }}" class="btn btn-outline-info btn-lg">
                        <i class="fas fa-eye me-2"></i>Ver Producto
                    </a>
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
