@extends('layouts.master')

@section('title')
    Detalle de Consumos del Socio
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Consumos @endslot
        @slot('title') Detalle de Consumos del Socio @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4>Consumos de {{ $socio->persona->nombre }} {{ $socio->persona->apellido }}</h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Mes</th>
                                    <th>Año</th>
                                    <th>Lectura Anterior (m³)</th>
                                    <th>Lectura Actual (m³)</th>
                                    <th>Consumo (m³)</th>
                                    <th>Monto a Cobrar (Bs)</th>
                                    <th>Estado de Pago</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                @endphp
                                @foreach($consumos as $consumo)
                                    <tr>
                                        <td>{{ $meses[$consumo->mes - 1] }}</td>
                                        <td>{{ $consumo->anio }}</td>
                                        <td>{{ $consumo->lectura_anterior }}</td>
                                        <td>{{ $consumo->lectura_actual }}</td>
                                        <td>{{ $consumo->lectura_actual - $consumo->lectura_anterior }}</td>
                                        <td>{{ $consumo->monto_cobrar }}</td>
                                        <td>{{ $consumo->estado_pago ? 'Pagado' : 'Pendiente' }}</td>
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
