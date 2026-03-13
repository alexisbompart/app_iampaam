@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Orden de {{ ucfirst($tipo) }}</h1>
    <form action="{{ route('ordenes.store', $tipo) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" required>
        </div>
        @if($tipo == 'entrada')
            <div class="mb-3">
                <label for="proveedor" class="form-label">Proveedor</label>
                <input type="text" class="form-control" id="proveedor" name="proveedor" required>
            </div>
        @else
            <div class="mb-3">
                <label for="beneficiario_id" class="form-label">Beneficiario</label>
                <select class="form-control" id="beneficiario_id" name="beneficiario_id" required>
                    @foreach($beneficiarios as $beneficiario)
                        <option value="{{ $beneficiario->id }}">{{ $beneficiario->nombre }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
        </div>

        <h3>Items</h3>
        <div id="items">
            <div class="item-row mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Producto</label>
                        <select class="form-control" name="productos[]" required>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="cantidades[]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Lote</label>
                        <input type="text" class="form-control" name="lotes[]">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha Vencimiento</label>
                        <input type="date" class="form-control" name="fechas_vencimiento[]">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-item">Remover</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" id="add-item" class="btn btn-secondary">Agregar Item</button>

        <br><br>
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>

<script>
document.getElementById('add-item').addEventListener('click', function() {
    const items = document.getElementById('items');
    const newRow = items.querySelector('.item-row').cloneNode(true);
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    items.appendChild(newRow);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-item')) {
        if (document.querySelectorAll('.item-row').length > 1) {
            e.target.closest('.item-row').remove();
        }
    }
});
</script>
@endsection
