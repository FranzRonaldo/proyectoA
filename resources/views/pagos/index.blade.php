@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Pagos</h1>
    <a href="{{ route('pagos.create') }}" class="btn btn-primary">Registrar Pago</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Consumo</th>
                <th>Monto Pagado</th>
                <th>Fecha Pago</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pagos as $pago)
                <tr>
                    <td>{{ $pago->id }}</td>
                    <td>{{ $pago->consumo->id }}</td>
                    <td>{{ $pago->monto_pagado }}</td>
                    <td>{{ $pago->fecha_pago }}</td>
                    <td>{{ $pago->estado }}</td>
                    <td>
                        <a href="{{ route('pagos.edit', $pago->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('pagos.destroy', $pago->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
