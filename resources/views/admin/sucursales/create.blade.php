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

    <li class="breadcrumb-item active" aria-current="page">Creación de sucursales</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><b>Llene los datos del formulario</b></h3>
              </div>

              <div class="card-body" style="display: block;">
                <form action="{{ url('/admin/sucursales/create') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">

                            {{-- Nombre --}}
                            <div class="form-group">
                                <label for="nombre" class="form-label">Nombre de la sucursal <b>(*)</b></label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                  </div>
                                    <input type="text" name="nombre" id="nombre" class="form-control" 
                                           value="{{ old('nombre') }}"
                                           placeholder="Escribe el nombre de la sucursal" required>
                                </div>
                                @error('nombre')
                                    <small class="text-danger fst-italic">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Dirección --}}
                            <div class="form-group">
                                <label for="direccion" class="form-label">Dirección <b>(*)</b></label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                  </div>
                                    <input type="text" name="direccion" id="direccion" class="form-control" 
                                           value="{{ old('direccion') }}"
                                           placeholder="Escribe la dirección de la sucursal" required>
                                </div>
                                @error('direccion')
                                    <small class="text-danger fst-italic">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Teléfono --}}
                            <div class="form-group">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                  </div>
                                    <input type="text" name="telefono" id="telefono" class="form-control" 
                                           value="{{ old('telefono') }}"
                                           placeholder="Ej: 76543210">
                                </div>
                                @error('telefono')
                                    <small class="text-danger fst-italic">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="form-group">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                  </div>
                                    <input type="email" name="email" id="email" class="form-control" 
                                           value="{{ old('email') }}"
                                           placeholder="ejemplo@correo.com">
                                </div>
                                @error('email')
                                    <small class="text-danger fst-italic">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Activa --}}
                            <div class="form-group">
                                <label for="activa" class="form-label">Sucursal activa</label>
                                <select name="activa" id="activa" class="form-control">
                                    <option value="1" {{ old('activa') == '1' ? 'selected' : '' }}>Sí</option>
                                    <option value="0" {{ old('activa') == '0' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <a href="{{ url('/admin/sucursales') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>      
                </form>
              </div>
            </div>
          </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
