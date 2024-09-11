@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Registrar Pago</h1>
    <form action="{{ route('pagos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="consumo_id">Consumo</label>
            <select name="consumo_id" id="consumo_id" class="form-control">
                @foreach ($consumos as $consumo)
                    <option value="{{ $consumo->id }}">{{ $consumo->id }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="monto_pagado">Monto Pagado</label>
            <input type="number" name="monto_pagado" id="monto_pagado" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="fecha_pago">Fecha Pago</label>
            <input type="date" name="fecha_pago" id="fecha_pago" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <input type="text" name="estado" id="estado" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
