@extends('layouts.master')
@section('title')
    Crear Persona
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Contacts @endslot
        @slot('title') Crear Persona @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <!-- Mostrar errores de validación -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('personas.store') }}" method="POST">
                        @csrf

                        <!-- Nombre y Apellido -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre:</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="apellido" class="form-label">Apellido:</label>
                                    <input type="text" name="apellido" id="apellido" class="form-control" value="{{ old('apellido') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Teléfono y Número de Carnet -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono:</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="numero_carnet" class="form-label">Número de Carnet:</label>
                                    <input type="text" name="numero_carnet" id="numero_carnet" class="form-control" value="{{ old('numero_carnet') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado:</label>
                                    <select name="estado" id="estado" class="form-select" required>
                                        <option value="1" {{ old('estado', 1) == 1 ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ old('estado') == 0 ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
                            <a href="{{ route('personas.index') }}" class="btn btn-secondary waves-effect waves-light">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
