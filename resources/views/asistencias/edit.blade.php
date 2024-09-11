@extends('layouts.master')

@section('title')
    Editar Asistencia
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Asistencias @endslot
        @slot('title') Editar Asistencia @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('asistencias.update', $asistencia->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Socio</label>
                                <select class="form-select" name="socio_id" required>
                                    @foreach($socios as $socio)
                                        <option value="{{ $socio->id }}" {{ $socio->id == $asistencia->socio_id ? 'selected' : '' }}>
                                            {{ $socio->codigo }} - {{ $socio->persona->nombre }} {{ $socio->persona->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Actividad</label>
                                <select class="form-select" name="actividad_id" required>
                                    @foreach($actividades as $actividad)
                                        <option value="{{ $actividad->id }}" {{ $actividad->id == $asistencia->actividad_id ? 'selected' : '' }}>
                                            {{ $actividad->nombre_actividad }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Asistió</label>
                            <select class="form-select" name="asistio" required>
                                <option value="1" {{ $asistencia->asistio ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ !$asistencia->asistio ? 'selected' : '' }}>No</option>
                            </select>
                            <div class="invalid-feedback">Indique si el socio asistió.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
