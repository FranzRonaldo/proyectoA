@extends('layouts.master')

@section('title')
    Registrar Consumo
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Consumos @endslot
        @slot('title') Registrar Consumo @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('consumos.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="socio_id" class="form-label">Socio</label>
                            <select class="form-control" id="socio_id" name="socio_id" required>
                                <option value="" selected disabled>Seleccione un socio</option>
                                @foreach($sociosData as $data)
                                    <option value="{{ $data['socio']->id }}" 
                                            data-lectura-anterior="{{ isset($nextMonthYear[$data['socio']->id]['lectura_anterior']) ? $nextMonthYear[$data['socio']->id]['lectura_anterior'] : '' }}"
                                            data-mes="{{ $data['mes'] }}"
                                            data-anio="{{ $data['anio'] }}">
                                        {{ $data['socio']->persona->nombre }} {{ $data['socio']->persona->apellido }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="mes" class="form-label">Mes</label>
                            <select class="form-control" id="mes" name="mes" required>
                                @foreach(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $index => $month)
                                    <option value="{{ $index + 1 }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number" class="form-control" id="anio" name="anio" required min="2000" max="{{ date('Y') }}">
                        </div>

                        <div class="mb-3">
                            <label for="lectura_anterior" class="form-label">Lectura Anterior (m³)</label>
                            <input type="number" class="form-control" id="lectura_anterior" name="lectura_anterior" step="0.01" readonly>
                            <small class="form-text text-muted">Si es el primer registro del socio, deje este campo en blanco.</small>
                        </div>

                        <div class="mb-3">
                            <label for="lectura_actual" class="form-label">Lectura Actual (m³)</label>
                            <input type="number" class="form-control" id="lectura_actual" name="lectura_actual" required step="0.01">
                        </div>

                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('socio_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var lecturaAnterior = selectedOption.getAttribute('data-lectura-anterior');
            var mes = selectedOption.getAttribute('data-mes');
            var anio = selectedOption.getAttribute('data-anio');

            document.getElementById('lectura_anterior').value = lecturaAnterior || '';
            document.getElementById('lectura_anterior').readOnly = lecturaAnterior !== '';

            document.getElementById('mes').value = mes || '';
            document.getElementById('anio').value = anio || '';
        });
    </script>
@endsection
