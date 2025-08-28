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

    <li class="breadcrumb-item active" aria-current="page">Creacion de categorias</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><b>Llene los datos del formulario</b></h3>

                
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">

               <form action="{{ url('/admin/categorias/create') }}" method="POST"">

                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre de la categoría <b>(*)</b></label>

                       

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-tags"></i></span>
                  </div>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Escribe el nombre de la categoría" required>
                </div>

                  {{-- Mensaje de error en small --}}
    @error('nombre')
        <small class="text-danger fst-italic">{{ $message }}</small>
    @enderror

                <label for="descripcion" class="form-label">Descripción de la categoria <b>(opcional)</b></label>
                <textarea name="descripcion" id="descripcion" 
                          class="form-control" rows="3" 
                          placeholder="Escribe una descripción (opcional)"></textarea>
                            
                        </div>
                    </div>
                </div>
                <br>
                   <div class="row">
        <div class="col-md-12 text-end">
            <div class="form-group">
                 <a href="{{ url('/admin/categorias') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            
        </div>
    </div>      
               </form>



                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
    </div>
@stop

@section('css')
  
@stop

@section('js')


   
@stop