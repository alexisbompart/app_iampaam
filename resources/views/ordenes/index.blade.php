@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Órdenes</h1>
    <a href="{{ route('ordenes.create', 'entrada') }}" class="btn btn-primary mb-3">Crear Orden de Entrada</a>
    <a href="{{ route('ordenes.create', 'entrega') }}" class="btn btn-secondary mb-3">Crear Orden de Entrega</a>

    <h2>Órdenes de Entrada</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordenesEntrada as $orden)
            <tr>
                <td>{{ $orden->id }}</td>
                <td>{{ $orden->fecha }}</td>
                <td>{{ $orden->proveedor }}</td>
                <td>
                    <a href="{{ route('ordenes.show', ['tipo' => 'entrada', 'orden' => $orden]) }}" class="btn btn-info btn-sm">Ver</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Órdenes de Entrega</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Beneficiario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordenesEntrega as $orden)
            <tr>
                <td>{{ $orden->id }}</td>
                <td>{{ $orden->fecha }}</td>
                <td>{{ $orden->beneficiario->nombre }}</td>
                <td>
                    <a href="{{ route('ordenes.show', ['tipo' => 'entrega', 'orden' => $orden]) }}" class="btn btn-info btn-sm">Ver</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
