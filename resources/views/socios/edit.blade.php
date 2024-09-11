@extends('layouts.master')
@section('title')
    Editar Socio
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Socios @endslot
        @slot('title') Editar Socio @endslot
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

                    <form action="{{ route('socios.update', $socio->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="red" class="form-label">Red:</label>
                                    <input type="text" name="red" id="red" class="form-control" value="{{ old('red', $socio->red) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="codigo" class="form-label">Código:</label>
                                    <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $socio->codigo) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ubicacion" class="form-label">Ubicación:</label>
                                    <input type="text" name="ubicacion" id="ubicacion" class="form-control" value="{{ old('ubicacion', $socio->ubicacion) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha_ingreso" class="form-label">Fecha de Ingreso:</label>
                                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" value="{{ old('fecha_ingreso', $socio->fecha_ingreso ? \Carbon\Carbon::parse($socio->fecha_ingreso)->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado:</label>
                                    <select name="estado" id="estado" class="form-select">
                                        <option value="1" {{ old('estado', $socio->estado) == 1 ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ old('estado', $socio->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="persona_id" class="form-label">Persona:</label>
                                    <select name="persona_id" id="persona_id" class="form-select">
                                        @foreach ($personas as $persona)
                                            <option value="{{ $persona->id }}" {{ old('persona_id', $socio->persona_id) == $persona->id ? 'selected' : '' }}>
                                                {{ $persona->nombre }} {{ $persona->apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
