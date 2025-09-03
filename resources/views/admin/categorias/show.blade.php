@extends('adminlte::page')

@section('content_header')
 <nav aria-label="breadcrumb" style="font-size:18pt">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ url('/admin') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/categorias') }}">Categorías</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Detalle de Categoría</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title"><b>Detalle de la Categoría</b></h3>
              </div>

              <div class="card-body" style="display: block;">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombre" class="form-label">Nombre de la categoría</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                  </div>
                                  <input type="text" name="nombre" id="nombre" 
                                         class="form-control" 
                                         value="{{ $categoria->nombre }}" 
                                         readonly>
                                </div>

                                <label for="descripcion" class="form-label">Descripción de la categoria</label>
                                <textarea name="descripcion" id="descripcion" 
                                          class="form-control" rows="3" 
                                          readonly>{{ $categoria->descripcion }}</textarea>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <a href="{{ url('/admin/categorias') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>      
                </form>
              </div>
            </div>
        </div>
    </div>
@stop
