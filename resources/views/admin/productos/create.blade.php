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
   <li class="breadcrumb-item active" aria-current="page">Creación de un producto</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>Llene los datos del formulario</b></h3>
    </div>

    <form action="{{ url('/admin/productos/create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            <div class="row">
                {{-- Categoría --}}
                <div class="col-md-3">
                    <label for="categoria_id">Categoría <b>(*)</b></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-tags"></i></span></div>
                        <select name="categoria_id" id="categoria_id" class="form-control" required>
                            <option value="">-- Seleccione --</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Código --}}
                <div class="col-md-3">
                    <label for="codigo">Código <b>(*)</b></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-barcode"></i></span></div>
                        <input type="text" name="codigo" id="codigo" class="form-control"
                               value="{{ old('codigo') }}" placeholder="Ej: P001" required>
                    </div>
                </div>

                {{-- Nombre --}}
                <div class="col-md-3">
                    <label for="nombre">Nombre <b>(*)</b></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-box"></i></span></div>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                               value="{{ old('nombre') }}" placeholder="Nombre del producto" required>
                    </div>
                </div>

                {{-- Imagen --}}
                <div class="col-md-3">
                    <label for="imagen">Imagen del producto <b>(*)</b></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-image"></i></span></div>
                        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" required
                               onchange="previewImage(event)">
                    </div>
                    <div class="mt-2">
                        <img id="preview" src="#" alt="Vista previa de la imagen" style="max-width: 100%; height: 120px; display:none; border:1px solid #ddd; padding:3px;"/>
                    </div>
                </div>
            </div>

            <br>

            {{-- Descripción --}}
            <div class="form-group">
                <label for="descripcion">Descripción <b>(*)</b></label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="4" placeholder="Escribe la descripción..." required>{{ old('descripcion') }}</textarea>
            </div>

            <br>

            <div class="row">
                {{-- Precio compra --}}
                <div class="col-md-2">
                    <label for="precio_compra">Precio compra <b>(*)</b></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-money-bill"></i></span></div>
                        <input type="number" step="0.01" name="precio_compra" id="precio_compra" class="form-control"
                               value="{{ old('precio_compra') }}" required>
                    </div>
                </div>

                {{-- Precio venta --}}
                <div class="col-md-2">
                    <label for="precio_venta">Precio venta <b>(*)</b></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span></div>
                        <input type="number" step="0.01" name="precio_venta" id="precio_venta" class="form-control"
                               value="{{ old('precio_venta') }}" required>
                    </div>
                </div>

                {{-- Stock mínimo --}}
                <div class="col-md-2">
                    <label for="stock_minimo">Stock mínimo <b>(*)</b></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-arrow-down"></i></span></div>
                        <input type="number" name="stock_minimo" id="stock_minimo" class="form-control"
                               value="{{ old('stock_minimo') }}" required>
                    </div>
                </div>

                {{-- Stock máximo --}}
                <div class="col-md-2">
                    <label for="stock_maximo">Stock máximo <b>(*)</b></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-arrow-up"></i></span></div>
                        <input type="number" name="stock_maximo" id="stock_maximo" class="form-control"
                               value="{{ old('stock_maximo') }}" required>
                    </div>
                </div>

                {{-- Unidad medida --}}
                <div class="col-md-2">
                    <label for="unidad_medida">Unidad <b>(*)</b></label>
                    <select name="unidad_medida" id="unidad_medida" class="form-control" required>
                        <option value="">-- Seleccione --</option>
                        <option value="Unidad" {{ old('unidad_medida') == 'Unidad' ? 'selected' : '' }}>Unidad</option>
                        <option value="Litro" {{ old('unidad_medida') == 'Litro' ? 'selected' : '' }}>Litro</option>
                        <option value="Kg" {{ old('unidad_medida') == 'Kg' ? 'selected' : '' }}>Kg</option>
                        <option value="Caja" {{ old('unidad_medida') == 'Caja' ? 'selected' : '' }}>Caja</option>
                    </select>
                </div>

                {{-- Estado --}}
                <div class="col-md-2">
                    <label for="estado">Estado <b>(*)</b></label>
                    <select name="estado" id="estado" class="form-control" required>
                        <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ url('/admin/productos') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
@stop

@section('js')
<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@stop
