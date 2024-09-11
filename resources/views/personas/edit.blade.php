@extends('layouts.master')
@section('title')
    Editar Persona
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Contacts @endslot
        @slot('title') Editar Persona @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('personas.update', $persona->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nombre y Apellido -->
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre:</label>
                                    <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre', $persona->nombre) }}" required>
                                    @error('nombre')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="apellido" class="form-label">Apellido:</label>
                                    <input type="text" id="apellido" name="apellido" class="form-control" value="{{ old('apellido', $persona->apellido) }}" required>
                                    @error('apellido')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Teléfono y Número de Carnet -->
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono:</label>
                                    <input type="text" id="telefono" name="telefono" class="form-control" value="{{ old('telefono', $persona->telefono) }}" required>
                                    @error('telefono')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="numero_carnet" class="form-label">Número de Carnet:</label>
                                    <input type="text" id="numero_carnet" name="numero_carnet" class="form-control" value="{{ old('numero_carnet', $persona->numero_carnet) }}" required>
                                    @error('numero_carnet')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado:</label>
                                    <select name="estado" id="estado" class="form-select" required>
                                        <option value="1" {{ old('estado', $persona->estado) == 1 ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ old('estado', $persona->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                    @error('estado')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Actualizar</button>
                            <a href="{{ route('personas.index') }}" class="btn btn-secondary waves-effect waves-light">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
