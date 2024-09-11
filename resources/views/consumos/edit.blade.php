@extends('layouts.master')

@section('title')
    Editar Consumo
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Consumos @endslot
        @slot('title') Editar Consumo @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('consumos.update', $consumo->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="socio_id" class="form-label">Socio</label>
                            <select name="socio_id" id="socio_id" class="form-control" required>
                                @foreach($socios as $socio)
                                    <option value="{{ $socio->id }}" {{ $socio->id == $consumo->socio_id ? 'selected' : '' }}>
                                        {{ $socio->persona->nombre }} {{ $socio->persona->apellido }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mes" class="form-label">Mes</label>
                            <select name="mes" id="mes" class="form-control" required>
                                @foreach(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $index => $month)
                                    <option value="{{ $index + 1 }}" {{ ($index + 1) == $consumo->mes ? 'selected' : '' }}>
                                        {{ $month }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number" name="anio" id="anio" class="form-control" value="{{ $consumo->anio }}" required min="2000" max="{{ date('Y') }}">
                        </div>
                        <div class="mb-3">
                            <label for="lectura_anterior" class="form-label">Lectura Anterior (m³)</label>
                            <input type="number" step="0.01" name="lectura_anterior" id="lectura_anterior" class="form-control" value="{{ $consumo->lectura_anterior }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="lectura_actual" class="form-label">Lectura Actual (m³)</label>
                            <input type="number" step="0.01" name="lectura_actual" id="lectura_actual" class="form-control" value="{{ $consumo->lectura_actual }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="estado_pago" class="form-label">Estado de Pago</label>
                            <select name="estado_pago" id="estado_pago" class="form-control" required>
                                <option value="0" {{ $consumo->estado_pago == 0 ? 'selected' : '' }}>Pendiente</option>
                                <option value="1" {{ $consumo->estado_pago == 1 ? 'selected' : '' }}>Pagado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
