@extends('layouts.master')

@section('title')
    Registrar Asistencia
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Asistencias @endslot
        @slot('title') Registrar Asistencia @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('asistencias.store') }}" class="needs-validation" novalidate>
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Actividad</label>
                                <select class="form-select" name="actividad_id" required>
                                    <option value="">Seleccione una Actividad</option>
                                    @foreach($actividades as $actividad)
                                        <option value="{{ $actividad->id }}">{{ $actividad->nombre_actividad }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Seleccione una actividad válida.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Socios</label>
                                <select class="form-select" name="socio_ids[]" multiple required>
                                    @foreach($socios as $socio)
                                        @if($socio->estado == 1)
                                            <option value="{{ $socio->id }}">{{ $socio->codigo }} - {{ $socio->persona->nombre }} {{ $socio->persona->apellido }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Seleccione al menos un socio.</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">¿Asistió?</label>
                                <select class="form-select" name="asistio" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
