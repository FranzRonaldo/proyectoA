@extends('layouts.master')
@section('title')
    @lang('translation.Edit_Activity')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Activities @endslot
        @slot('title') Editar la actividad @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('actividades.update', $actividad->id) }}" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nombre de la actividad</label>
                            <input class="form-control" placeholder="Inserte el nombre de la actividad" type="text" name="nombre" value="{{ $actividad->nombre }}" required>
                            <div class="invalid-feedback">Porfavor ingrese el nombre de la actividad</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripcion de la actividad</label>
                            <textarea class="form-control" placeholder="Breve descripcion" name="descripcion" rows="3">{{ $actividad->descripcion }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha</label>
                            <input class="form-control" placeholder="Seleccione la fecha" type="date" name="fecha" value="{{ $actividad->fecha }}" required>
                            <div class="invalid-feedback">Please select a valid date</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Multa (Bs)</label>
                            <input class="form-control" placeholder="Inserte la multa en bs." type="number" name="multa" value="{{ $actividad->multa }}" required>
                            <div class="invalid-feedback">Please provide a valid amount</div>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
