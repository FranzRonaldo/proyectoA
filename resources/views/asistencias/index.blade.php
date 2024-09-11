@extends('layouts.master')

@section('title')
    Lista de Asistencias
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Asistencias @endslot
        @slot('title') Lista de Asistencias @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <a href="{{ route('asistencias.create') }}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus me-2"></i> Registrar Asistencia</a>
                        </div>
                    </div>
                    
                    <!-- Formulario para agregar socios a una actividad -->
                    <form action="{{ route('asistencias.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="actividad_id" class="form-label">Seleccionar Actividad</label>
                                <select id="actividad_id" name="actividad_id" class="form-select" required>
                                    <option value="" disabled selected>Seleccione una actividad</option>
                                    @foreach($actividades as $actividad)
                                        <option value="{{ $actividad->id }}">{{ $actividad->nombre_actividad }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="socio_id" class="form-label">Seleccionar Socios</label>
                                <select id="socio_id" name="socio_ids[]" class="form-select" multiple required>
                                    @foreach($socios as $socio)
                                        @if($socio->estado == 1)
                                            <option value="{{ $socio->id }}">{{ $socio->codigo }} - {{ $socio->persona->nombre }} {{ $socio->persona->apellido }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="asistio" class="form-label">¿Asistió?</label>
                                <select id="asistio" name="asistio" class="form-select" required>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Socios a Actividad</button>
                    </form>
                    
                    <div class="table-responsive mb-4 mt-4">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Socio</th>
                                    <th>Actividad</th>
                                    <th>Asistió</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($asistencias as $asistencia)
                                    <tr>
                                        <td>{{ $asistencia->socio->codigo }} - {{ $asistencia->socio->persona->nombre }}</td>
                                        <td>{{ $asistencia->actividad->nombre_actividad }}</td>
                                        <td>{{ $asistencia->asistio ? 'Sí' : 'No' }}</td>
                                        <td>
                                            <a href="{{ route('asistencias.edit', $asistencia->id) }}" class="text-primary"><i class="uil uil-pen font-size-18"></i></a>
                                            <form action="{{ route('asistencias.destroy', $asistencia->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger"><i class="uil uil-trash-alt font-size-18"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
