@extends('adminlte::page')

@section('content_header')
<nav aria-label="breadcrumb" style="font-size:18pt">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ url('/admin') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/prestamos') }}">Préstamos</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Detalle del Préstamo</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
<div class="row">

    {{-- Datos del Cliente --}}
    <div class="col-md-4">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><b>Datos del Cliente</b></h3>
            </div>
            <div class="card-body">
                <p><i class="fas fa-id-card"></i> <b>CI:</b> {{ $prestamo->cliente->ci }}</p>
                <p><i class="fas fa-user"></i> <b>Nombre:</b> {{ $prestamo->cliente->nombre }} {{ $prestamo->cliente->apellido }}</p>
                <p><i class="fas fa-envelope"></i> <b>Email:</b> {{ $prestamo->cliente->email ?? 'No registrado' }}</p>
                <p><i class="fas fa-phone"></i> <b>Teléfono:</b> {{ $prestamo->cliente->telefono ?? 'Sin número' }}</p>
                <p><i class="fas fa-calendar"></i> <b>Fecha de nacimiento:</b> {{ $prestamo->cliente->fecha_nacimiento ?? 'No registrada' }}</p>
                <p><i class="fas fa-venus-mars"></i> <b>Género:</b> {{ $prestamo->cliente->genero ?? 'No especificado' }}</p>
            </div>
        </div>
    </div>

    {{-- Datos del Préstamo --}}
    <div class="col-md-4">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><b>Datos del Préstamo</b></h3>
            </div>
            <div class="card-body">
                <p><i class="fas fa-money-bill"></i> <b>Monto Prestado:</b> {{ number_format($prestamo->monto_prestado, 2) }}</p>
                <p><i class="fas fa-percent"></i> <b>Tasa de Interés:</b> {{ $prestamo->tasa_interes }}%</p>
                <p><i class="fas fa-calendar-alt"></i> <b>Modalidad:</b> {{ $prestamo->modalidad }}</p>
                <p><i class="fas fa-list-ol"></i> <b>Nro de Cuotas:</b> {{ $prestamo->nro_cuotas }}</p>
                <p><i class="fas fa-hand-holding-usd"></i> <b>Monto Total:</b> {{ number_format($prestamo->monto_total, 2) }}</p>
                <p><i class="fas fa-clock"></i> <b>Estado:</b> {{ ucfirst($prestamo->estado) }}</p>
            </div>
        </div>
    </div>

    {{-- Datos de los Pagos --}}
    <div class="col-md-4">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><b>Datos de los Pagos</b></h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>N° de Cuota</th>
                            <th>Monto</th>
                            <th>Fecha de Pago</th>
                            <th>Estado</th>
                            <th>Fecha Cancelado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prestamo->pagos as $index => $pago)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ number_format($pago->monto_pagado, 2) }}</td>
                                <td>{{ $pago->fecha_pago }}</td>
                                <td>
                                    <span class="badge 
                                        @if($pago->estado == 'pendiente') bg-warning 
                                        @elseif($pago->estado == 'cancelado') bg-success 
                                        @else bg-secondary @endif">
                                        {{ ucfirst($pago->estado) }}
                                    </span>
                                </td>
                                <td>{{ $pago->fecha_cancelado ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- Botón volver --}}
<div class="row mt-3">
    <div class="col-md-12 text-end">
        <a href="{{ url('/admin/prestamos') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>
@stop
