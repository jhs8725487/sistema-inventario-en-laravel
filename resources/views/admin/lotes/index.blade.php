@extends('adminlte::page')

@section('content_header')
<nav aria-label="breadcrumb" style="font-size:18pt">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ url('/admin') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/lotes') }}">Lotes</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Listado de lotes</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
          <div class="card-header">
            <h3 class="card-title"><b>Lotes registrados</b></h3>

            <div class="card-tools">
                <a href="{{ url('/admin/lotes/create') }}" class="btn btn-primary">
                    Crear nuevo
                </a>
            </div>
          </div>

          <div class="card-body table-responsive">
            <table id="example1" class="table table-striped table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th style="text-align:center">Nro</th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Cliente</th>
                        <th>Cantidad Inicial</th>
                        <th>Cantidad Actual</th>
                        <th>Fecha Entrada</th>
                        <th>Fecha Vencimiento</th>
                        <th>Precio Compra</th>
                        <th>Estado</th>
                        <th style="text-align:center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lotes as $lote)
                        <tr class="{{ $lote->is_expired ? 'table-danger' : '' }}">
                            <td style="text-align:center; font-weight:bold;">
                                {{ $loop->iteration }}
                            </td>

                            <td>{{ $lote->codigo }}</td>

                            <td>{{ $lote->producto->nombre ?? 'Sin producto' }}</td>

                            <td>{{ $lote->cliente->nombre ?? 'Sin cliente' }}</td>

                            <td>{{ $lote->cantidad_inicial }}</td>

                            <td>{{ $lote->cantidad_actual }}</td>

                            <td>{{ $lote->fecha_entrada }}</td>

                            <td>{{ $lote->fecha_vencimiento }}</td>

                            <td>{{ number_format($lote->precio_compra, 2) }}</td>

                            <td style="text-align: center;">
                                @if ($lote->is_expired)
                                    <span class="badge bg-danger">Vencido</span>
                                    @else
                                    <span class="badge bg-success">Vigente</span>
                                @endif
                            </td>

                            <td style="text-align:center; white-space:nowrap;">
                                <div class="btn-group" role="group">
                                    <a href="{{ url('/admin/lotes/' . $lote->id) }}" class="btn btn-info" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ url('/admin/lotes/' . $lote->id . '/edit') }}" class="btn btn-success" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <form action="{{ url('/admin/lotes/' . $lote->id) }}" id="formEliminar{{ $lote->id }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="confirmarEliminacion{{ $lote->id }}(event)" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>

                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script>
                                function confirmarEliminacion{{ $lote->id }}(event) {
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
                                            document.getElementById('formEliminar{{ $lote->id }}').submit();
                                        }
                                    });
                                }
                                </script>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if(method_exists($lotes, 'links'))
                <div class="mt-2">
                    {{ $lotes->links() }}
                </div>
            @endif
          </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
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
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Lotes",
            "infoEmpty": "Mostrando 0 a 0 de 0 Lotes",
            "infoFiltered": "(Filtrado de _MAX_ total Lotes)",
            "lengthMenu": "Mostrar _MENU_ Lotes",
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
            { "orderable": false, "targets": [10] } // Desactivar orden en Acciones
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
