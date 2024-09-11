@extends('layouts.master')
@section('title')
    Lista de Socios
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Socios @endslot
        @slot('title') Lista de Socios @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <a href="{{ route('socios.create') }}" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus me-2"></i> Crear Socio</a>
                        </div>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Identificador</th>
                                    <th>Persona</th>
                                    <th>Red</th>
                                    <th>Código</th>
                                    <th>Ubicación</th>
                                    <th>Fecha de Ingreso</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($socios as $socio)
                                    <tr>
                                        <td>{{ $socio->identificador_socio }}</td>
                                        <td>{{ $socio->persona->nombre }}</td>
                                        <td>{{ $socio->red }}</td>
                                        <td>{{ $socio->codigo ?? 'No asignado' }}</td>
                                        <td>{{ $socio->ubicacion }}</td>
                                        <td>{{ \Carbon\Carbon::parse($socio->fecha_ingreso)->format('Y-m-d') }}</td>
                                        <td>{{ $socio->estado ? 'Activo' : 'Inactivo' }}</td>
                                        <td>
                                            <a href="{{ route('socios.edit', $socio->id) }}" class="text-primary"><i class="uil uil-pen font-size-18"></i></a>
                                            <form action="{{ route('socios.destroy', $socio->id) }}" method="POST" style="display:inline;">
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
