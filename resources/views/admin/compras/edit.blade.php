@extends('adminlte::page')

@section('content_header')
<nav aria-label="breadcrumb" style="font-size:18pt">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="{{ url('/admin') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item">
      <a href="{{ url('/admin/compras') }}">Compras</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Compra nro {{ $compra->id }}</li>
  </ol>
</nav>
<hr>
@stop

@section('content')

{{-- Paso 1: Datos de la compra --}}
<div class="card">
    <div class="card-header bg-teal">
        <h5 class="mb-0 text-white"><b>Paso 1 | Compra creada</b></h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <strong>Cliente</strong><br>
                {{ $compra->cliente->nombre ?? 'Sin cliente' }}
            </div>
            <div class="col-md-3">
                <strong>Fecha de la compra</strong><br>
                {{ $compra->fecha }}
            </div>
            <div class="col-md-3">
                <strong>Observaciones</strong><br>
                {{ $compra->observaciones ?? 'ninguna' }}
            </div>
            <div class="col-md-3">
                <strong>Estado de la compra</strong><br>
                {{ $compra->estado }}
            </div>
        </div>
    </div>
</div>

{{-- Paso 2: Agregar productos --}}
<div class="card mt-3">
    <div class="card-header bg-primary">
        <h5 class="mb-0 text-white"><b>Paso 2 | Agregar productos</b></h5>
    </div>
    <div class="card-body">

        {{-- Aquí está tu componente Livewire para agregar productos --}}
        <livewire:admin.compras.items-compra :compra="$compra" />

        {{-- 🔸 Botones debajo del formulario --}}
        <div class="mt-3 d-flex justify-content-start gap-2">
            {{-- Botón Enviar Correo --}}
            <a href="{{ route('compras.enviarCorreo', $compra) }}" 
                class="btn btn-light btn-sm" 
                title="Enviar correo al cliente">
                <i class="fas fa-envelope text-primary"></i> Enviar correo
            </a>

            {{-- Botón Finalizar Compra --}}
            {{-- Botón Finalizar Compra + Select de Sucursal --}}
<form action="{{ route('compras.finalizar', $compra) }}" method="POST" class="d-flex align-items-center gap-2">
    @csrf

    {{-- Select de Sucursal --}}
    <select name="sucursal_id" class="form-control form-control-sm w-auto" required>
        <option value="">Sucursal...</option>
        @foreach($sucursales as $sucursal)
            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
        @endforeach
    </select>

    {{-- Botón Finalizar --}}
    <button type="submit" class="btn btn-success btn-sm">
        <i class="fas fa-check"></i> Finalizar compra
    </button>
</form>
        </div>

    </div>
</div>


@stop

@section('css')
<style>
    .select2-container .select2-selection--single {
        height: 40px !important;
    }
    .gap-2 {
        gap: 0.5rem;
    }
</style>
@stop

@section('js')
@stop

@livewireStyles
@livewireScripts
