@extends('layouts.master')
@section('title')
    Crear Socio
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Socios @endslot
        @slot('title') Crear Socio @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('socios.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="red" class="form-label">Red:</label>
                                    <input type="text" name="red" id="red" class="form-control" value="{{ old('red') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="codigo" class="form-label">Código:</label>
                                    <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ubicacion" class="form-label">Ubicación:</label>
                                    <input type="text" name="ubicacion" id="ubicacion" class="form-control" value="{{ old('ubicacion') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha_ingreso" class="form-label">Fecha de Ingreso:</label>
                                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" value="{{ old('fecha_ingreso') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado:</label>
                                    <select name="estado" id="estado" class="form-select">
                                        <option value="1" {{ old('estado') == 1 ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ old('estado') == 0 ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="persona_id" class="form-label">Persona:</label>
                                    <select name="persona_id" id="persona_id" class="form-select">
                                        @foreach ($personas as $persona)
                                            <option value="{{ $persona->id }}" {{ old('persona_id') == $persona->id ? 'selected' : '' }}>
                                                {{ $persona->nombre }} {{ $persona->apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
