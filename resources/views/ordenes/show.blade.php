@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de la Orden de {{ ucfirst($tipo) }}</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Orden #{{ $orden->id }}</h5>
            <p class="card-text"><strong>Fecha:</strong> {{ $orden->fecha }}</p>
            @if($tipo == 'entrada')
                <p class="card-text"><strong>Proveedor:</strong> {{ $orden->proveedor }}</p>
            @else
                <p class="card-text"><strong>Beneficiario:</strong> {{ $orden->beneficiario->nombre }}</p>
            @endif
            <p class="card-text"><strong>Observaciones:</strong> {{ $orden->observaciones }}</p>
        </div>
    </div>

    <h3>Items</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Lote</th>
                <th>Fecha Vencimiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orden->items as $item)
            <tr>
                <td>{{ $item->producto->nombre }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->lote }}</td>
                <td>{{ $item->fecha_vencimiento }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('ordenes.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
