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
    <li class="breadcrumb-item active" aria-current="page">Creación de una compra</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>Llene los datos del formulario</b></h3>
    </div>

    <form action="{{ url('/admin/compras/create') }}" method="POST">
        @csrf
        <div class="card-body">

            <div class="row">
                {{-- Cliente --}}
                <div class="col-md-4">
                    <label for="cliente_id">Cliente <b>(*)</b></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                        <select name="cliente_id" id="cliente_id" class="form-control" required>
                            <option value="">-- Seleccione --</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

               

                {{-- Fecha --}}
                <div class="col-md-4">
                    <label for="fecha">Fecha <b>(*)</b></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                        <input type="date" name="fecha" id="fecha" class="form-control" 
                               value="{{ old('fecha', date('Y-m-d')) }}" required>
                    </div>
                </div>
            </div>

            <br>


            <br>

            {{-- Observaciones --}}
            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" id="observaciones" class="form-control" rows="3"
                          placeholder="Escriba detalles adicionales...">{{ old('observaciones') }}</textarea>
            </div>

        </div>

        <div class="card-footer text-end">
            <a href="{{ url('/admin/compras') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Crear compra y añadir productos</button>
        </div>
    </form>
</div>
@stop
