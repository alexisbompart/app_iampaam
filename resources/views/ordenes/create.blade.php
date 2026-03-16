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
    .item-row {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        border-left: 4px solid #4caf50;
    }
</style>

<div class="container-fluid">
    <div class="form-section">
        <h1 class="text-center mb-4" style="color: #2e7d32;">
            @if($tipo == 'entrada')
                <i class="fas fa-arrow-circle-down me-2"></i>Crear Orden de Entrada
            @else
                <i class="fas fa-arrow-circle-up me-2"></i>Crear Orden de Entrega
            @endif
        </h1>
        <p class="text-center text-muted mb-4">Instituto de Atención al Adulto Mayor y Protección a la Ancianidad</p>

        <form action="{{ route('ordenes.store', $tipo) }}" method="POST">
            @csrf

            <!-- Información General -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle me-2"></i>Información General
                </h3>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="fecha" class="form-label">Fecha *</label>
                        <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" required>
                        @error('fecha') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    @if($tipo == 'entrada')
                    <div class="col-md-8">
                        <label for="proveedor" class="form-label">Proveedor *</label>
                        <input type="text" class="form-control @error('proveedor') is-invalid @enderror" id="proveedor" name="proveedor" required>
                        @error('proveedor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    @else
                    <div class="col-md-8">
                        <label for="beneficiario_id" class="form-label">Beneficiario *</label>
                        <select class="form-control @error('beneficiario_id') is-invalid @enderror" id="beneficiario_id" name="beneficiario_id" required>
                            <option value="">Seleccionar beneficiario...</option>
                            @foreach($beneficiarios as $beneficiario)
                                <option value="{{ $beneficiario->id }}">{{ $beneficiario->nombre }} — {{ $beneficiario->cedula ?? 'Sin cédula' }}</option>
                            @endforeach
                        </select>
                        @error('beneficiario_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones" rows="3" placeholder="Notas o comentarios adicionales">{{ old('observaciones') }}</textarea>
                    @error('observaciones') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Productos / Items -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-boxes me-2"></i>Productos
                </h3>

                <div id="items">
                    <div class="item-row">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Producto *</label>
                                <select class="form-control" name="productos[]" required>
                                    <option value="">Seleccionar producto...</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->nombre }} (Stock: {{ $producto->stock }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Cantidad *</label>
                                <input type="number" class="form-control" name="cantidades[]" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Lote</label>
                                <input type="text" class="form-control" name="lotes[]" placeholder="Opcional">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Fecha Vencimiento</label>
                                <input type="date" class="form-control" name="fechas_vencimiento[]">
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-outline-danger remove-item" title="Remover">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-item" class="btn btn-outline-success mt-2">
                    <i class="fas fa-plus me-2"></i>Agregar Producto
                </button>
            </div>

            <!-- Botones -->
            <div class="text-center">
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save me-2"></i>Crear Orden
                    </button>
                    <a href="{{ route('ordenes.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('add-item').addEventListener('click', function() {
    const items = document.getElementById('items');
    const newRow = items.querySelector('.item-row').cloneNode(true);
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    newRow.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
    items.appendChild(newRow);
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-item')) {
        if (document.querySelectorAll('.item-row').length > 1) {
            e.target.closest('.item-row').remove();
        }
    }
});
</script>
@endsection
