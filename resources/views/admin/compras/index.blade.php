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
    <li class="breadcrumb-item active" aria-current="page">Listado de compras</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
          <div class="card-header">
            <h3 class="card-title"><b>Compras registradas</b></h3>

            <div class="card-tools">
                <a href="{{ url('/admin/compras/create') }}" class="btn btn-primary">
                Crear nuevo</a>
            </div>
          </div>

          <div class="card-body table-responsive" style="display: block;">
            <table id="example1" class="table table-striped table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th style="text-align:center">Nro</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                        <th style="text-align:center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras as $compra)
                        <tr>
                            <td style="text-align: center; font-weight: bold;">
                                {{ $loop->iteration }}
                            </td>
                            <td>{{ $compra->fecha }}</td>
                            <td>{{ number_format($compra->total, 2) }}</td>
                            <td style="text-align: center;">
                                @if ($compra->estado == 'pendiente')
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @elseif ($compra->estado == 'aprobada')
                                    <span class="badge bg-success">Aprobada</span>
                                @elseif ($compra->estado == 'anulada')
                                    <span class="badge bg-danger">Anulada</span>
                                @else
                                    <span class="badge bg-secondary">{{ $compra->estado }}</span>
                                @endif
                            </td>
                            <td title="{{ $compra->observaciones }}">
                                {{ \Illuminate\Support\Str::limit($compra->observaciones, 60) }}
                            </td>
                            <td style="text-align:center; white-space:nowrap;">
                                <div class="btn-group" role="group">
                                    <a href="{{ url('/admin/compras/' . $compra->id) }}" class="btn btn-info" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ url('/admin/compras/' . $compra->id . '/edit') }}" class="btn btn-success" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <form action="{{ url('/admin/compras/' . $compra->id) }}" id="formEliminar{{ $compra->id }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="confirmarEliminacion{{ $compra->id }}(event)" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>

                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script>
                                function confirmarEliminacion{{ $compra->id }}(event) {
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
                                            document.getElementById('formEliminar{{ $compra->id }}').submit();
                                        }
                                    });
                                }
                                </script>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if(method_exists($compras, 'links'))
                <div class="mt-2">
                    {{ $compras->links() }}
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
</style>
@stop

@section('js')
<script>
$(function () {
    $("#example1").DataTable({
        "pageLength": 10,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Compras",
            "infoEmpty": "Mostrando 0 a 0 de 0 Compras",
            "infoFiltered": "(Filtrado de _MAX_ total Compras)",
            "lengthMenu": "Mostrar _MENU_ Compras",
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
            { "orderable": false, "targets": [5] } // Acciones sin ordenamiento
        ],
        buttons: [
            { text: '<i class="fas fa-copy"></i> COPIAR', extend: 'copy', className: 'btn btn-dafault' },
            { text: '<i class="fas fa-file-pdf"></i> PDF', extend: 'pdf', className: 'btn btn-danger' },
            { text: '<i class="fas fa-file-csv"></i> CSV', extend: 'csv', className: 'btn btn-info' },
            { text: '<i class="fas fa-file-excel"></i> EXCEL', extend: 'excel', className: 'btn btn-success' },
            { text: '<i class="fas fa-print"></i> IMPRIMIR', extend: 'print', className: 'btn btn-warning' }
        ]
    }).buttons().container().appendTo('#example1_wrapper .row:eq(0)');
});
</script>
@stop
