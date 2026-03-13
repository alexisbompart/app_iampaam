@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Producto</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $producto->nombre }}</h5>
            <p class="card-text"><strong>Tipo:</strong> {{ $producto->tipo }}</p>
            <p class="card-text"><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
            <p class="card-text"><strong>Stock:</strong> {{ $producto->stock }}</p>
            <p class="card-text"><strong>Unidad:</strong> {{ $producto->unidad }}</p>
            <p class="card-text"><strong>Fecha de Vencimiento:</strong> {{ $producto->fecha_vencimiento }}</p>
            <p class="card-text"><strong>Proveedor:</strong> {{ $producto->proveedor }}</p>
        </div>
    </div>
    <a href="{{ route('productos.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
