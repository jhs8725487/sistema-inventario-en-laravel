@extends('adminlte::page')

@section('content_header')
 <nav aria-label="breadcrumb" style="font-size:18pt">
  <ol class="breadcrumb">
   <li class="breadcrumb-item">
    <a href="{{ url('/admin') }}">Inicio</a>
   </li>
   <li class="breadcrumb-item">
    <a href="{{ url('/admin/productos') }}">Productos</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page">Detalle del producto</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>Información del Producto</b></h3>
    </div>

    <div class="card-body">
        <div class="row">
            {{-- Categoría --}}
            <div class="col-md-3">
                <label>Categoría:</label>
                <p>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</p>
            </div>

            {{-- Código --}}
            <div class="col-md-3">
                <label>Código:</label>
                <p>{{ $producto->codigo }}</p>
            </div>

            {{-- Nombre --}}
            <div class="col-md-3">
                <label>Nombre:</label>
                <p>{{ $producto->nombre }}</p>
            </div>

            {{-- Imagen --}}
            <div class="col-md-3">
                <label>Imagen:</label><br>
                @if($producto->imagen)
                    <img src="{{ asset('storage/'.$producto->imagen) }}" 
                         alt="Imagen del producto" 
                         style="max-width:100%; height:150px; border:1px solid #ddd; padding:3px;">
                @else
                    <p>No hay imagen</p>
                @endif
            </div>
        </div>

        <br>

        {{-- Descripción --}}
        <div class="form-group">
            <label>Descripción:</label>
            <p>{{ $producto->descripcion }}</p>
        </div>

        <br>

        <div class="row">
            <div class="col-md-2">
                <label>Precio compra:</label>
                <p>{{ number_format($producto->precio_compra, 2) }} Bs</p>
            </div>

            <div class="col-md-2">
                <label>Precio venta:</label>
                <p>{{ number_format($producto->precio_venta, 2) }} Bs</p>
            </div>

            <div class="col-md-2">
                <label>Stock mínimo:</label>
                <p>{{ $producto->stock_minimo }}</p>
            </div>

            <div class="col-md-2">
                <label>Stock máximo:</label>
                <p>{{ $producto->stock_maximo }}</p>
            </div>

            <div class="col-md-2">
                <label>Unidad de medida:</label>
                <p>{{ $producto->unidad_medida }}</p>
            </div>

            <div class="col-md-2">
                <label>Estado:</label>
                <p>
                    @if($producto->estado)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="card-footer text-end">
        <a href="{{ url('/admin/productos') }}" class="btn btn-secondary">Volver</a>
        <a href="{{ url('/admin/productos/'.$producto->id.'/edit') }}" class="btn btn-primary">Editar</a>
    </div>
</div>
@stop
