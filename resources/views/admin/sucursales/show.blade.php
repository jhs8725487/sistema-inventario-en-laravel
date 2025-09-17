@extends('adminlte::page')

@section('content_header')
 <nav aria-label="breadcrumb" style="font-size:18pt">
  <ol class="breadcrumb">
   
   <li class="breadcrumb-item">
    <a href="{{ url('/admin') }}">Inicio</a>
   </li>

    <li class="breadcrumb-item">
    <a href="{{ url('/admin/sucursales') }}">Sucursales</a>
    </li>

    <li class="breadcrumb-item active" aria-current="page">Detalle de sucursal</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title"><b>Información de la sucursal</b></h3>
              </div>

              <div class="card-body" style="display: block;">
                    {{-- Nombre --}}
                    <div class="form-group">
                        <label><i class="fas fa-building"></i> Nombre:</label>
                        <p class="form-control-plaintext">{{ $sucursal->nombre }}</p>
                    </div>

                    {{-- Dirección --}}
                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Dirección:</label>
                        <p class="form-control-plaintext">{{ $sucursal->direccion }}</p>
                    </div>

                    {{-- Teléfono --}}
                    <div class="form-group">
                        <label><i class="fas fa-phone"></i> Teléfono:</label>
                        <p class="form-control-plaintext">{{ $sucursal->telefono ?? 'No registrado' }}</p>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Correo electrónico:</label>
                        <p class="form-control-plaintext">{{ $sucursal->email ?? 'No registrado' }}</p>
                    </div>

                    {{-- Activa --}}
                    <div class="form-group">
                        <label><i class="fas fa-check-circle"></i> Activa:</label>
                        <p class="form-control-plaintext">
                            @if($sucursal->activa)
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </p>
                    </div>
              </div>

              <div class="card-footer text-end">
                <a href="{{ url('/admin/sucursales') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <a href="{{ url('/admin/sucursales/'.$sucursal->id.'/edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar
                </a>
              </div>
            </div>
          </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
