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
    <li class="breadcrumb-item active" aria-current="page">Listado de productos</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
          <div class="card-header">
            <h3 class="card-title"><b>Productos registrados</b></h3>

            <div class="card-tools">
                <a href="{{ url('/admin/productos/create') }}" class="btn btn-primary">
                Crear nuevo</a>
            </div>
          </div>

          <div class="card-body table-responsive" style="display: block;">
            <table id="example1" class="table table-striped table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th style="text-align:center">Nro</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Imagen</th>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Precio Compra</th>
                        <th>Precio Venta</th>
                        <th>Stock Min</th>
                        <th>Stock Max</th>
                        <th>Unidad</th>
                        <th style="text-align:center">Estado</th>
                        <th style="text-align:center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td style="text-align: center; font-weight: bold;">
                                {{ $loop->iteration }}
                            </td>

                            <td>{{ $producto->codigo }}</td>

                            <td>{{ $producto->nombre }}</td>

                            <td>
                                <img
                                  src="{{ $producto->imagen ? asset('storage/' . $producto->imagen) : asset('img/no-image.png') }}"
                                  alt="{{ $producto->nombre }}"
                                  class="product-thumb"
                                />
                            </td>

                            <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>

                            <td title="{{ $producto->descripcion }}">
                                {{ \Illuminate\Support\Str::limit($producto->descripcion, 60) }}
                            </td>

                            <td>{{ number_format($producto->precio_compra, 2) }}</td>

                            <td>{{ number_format($producto->precio_venta, 2) }}</td>

                            <td>{{ $producto->stock_minimo }}</td>

                            <td>{{ $producto->stock_maximo }}</td>

                            <td>{{ $producto->unidad_medida }}</td>

                            <td style="text-align: center;">
                                @if ($producto->estado == 'activo' || $producto->estado === 1)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>

                            <td style="text-align:center; white-space:nowrap;">
                                <div class="btn-group" role="group">
                                    <a href="{{ url('/admin/productos/' . $producto->id) }}" class="btn btn-info" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ url('/admin/productos/' . $producto->id . '/edit') }}" class="btn btn-success" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <form action="{{ url('/admin/productos/' . $producto->id) }}" id="formEliminar{{ $producto->id }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="confirmarEliminacion{{ $producto->id }}(event)" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- SweetAlert (uno por fila — opcionalmente puedes moverlo fuera del loop y hacer algo genérico) -->
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script>
                                function confirmarEliminacion{{ $producto->id }}(event) {
                                    event.preventDefault();
                                    Swal.fire({
                                        title: "¿Estás seguro?",
                                        text: "¡No podrás revertir esto!",
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#3085d6",
                                        cancelButtonColor: "#d33",
                                        confirmButtonText: "Sí, eliminar!",
                                        cancelButtonText: "Cancelar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.getElementById('formEliminar{{ $producto->id }}').submit();
                                        }
                                    });
                                }
                                </script>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Si usas paginación -->
            @if(method_exists($productos, 'links'))
                <div class="mt-2">
                    {{ $productos->links() }}
                </div>
            @endif
          </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .product-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    #example1_wrapper .dt-buttons {
        background-color: transparent;
        box-shadow: none;
        border: none;
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 15px;
    }
    #example1_wrapper .btn {
        color: #fff;
        border-radius: 4px;
        padding: 5px 15px;
        font-size: 14px;
    }
    .btn-danger { background-color: #dc3545; border: none; }
    .btn-success { background-color: #28a745; border: none; }
    .btn-info { background-color: #17a2b8; border: none; }
    .btn-warning { background-color: #ffc107; color: #212529; border: none; }
    .btn-default { background-color: #6e7176; color: #212529; border: none; }
    td { vertical-align: middle; }
</style>
@stop

@section('js')
<script>
$(function () {
    $("#example1").DataTable({ 
        "pageLength": 10,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
            "infoEmpty": "Mostrando 0 a 0 de 0 Productos",
            "infoFiltered": "(Filtrado de _MAX_ total Productos)",
            "lengthMenu": "Mostrar _MENU_ Productos",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscador:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "columnDefs": [
            { "orderable": false, "targets": [3, 12] } // desactivar orden en columnas imagen y acciones (índices según tu tabla)
        ],
        buttons: [
            { text: '<i class="fas fa-copy"></i> COPIAR', extend: 'copy', className: 'btn btn-default' },
            { text: '<i class="fas fa-file-pdf"></i> PDF', extend: 'pdf', className: 'btn btn-danger' },
            { text: '<i class="fas fa-file-csv"></i> CSV', extend: 'csv', className: 'btn btn-info' },
            { text: '<i class="fas fa-file-excel"></i> EXCEL', extend: 'excel', className: 'btn btn-success' },
            { text: '<i class="fas fa-print"></i> IMPRIMIR', extend: 'print', className: 'btn btn-warning' }
        ]
    }).buttons().container().appendTo('#example1_wrapper .row:eq(0)');
});
</script>
@stop
