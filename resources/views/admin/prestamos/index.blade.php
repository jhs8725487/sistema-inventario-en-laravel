@extends('adminlte::page')

@section('content_header')
<nav aria-label="breadcrumb" style="font-size:18pt">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="{{ url('/admin') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Listado de préstamos</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title"><b>Préstamos registrados</b></h3>
        <div class="card-tools">
          <a href="{{ route('prestamos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Registrar nuevo
          </a>

        </div>
      </div>

      <div class="card-body table-responsive">
        <table id="example1" class="table table-striped table-bordered table-hover table-sm">
          <thead>
            <tr>
              <th style="text-align:center">N°</th>
              <th>Cliente</th>
              <th>Modalidad</th>
              <th>Monto prestado</th>
              <th>N° Cuotas</th>
              <th>Estado</th>
              <th style="text-align:center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($prestamos as $prestamo)
            <tr>
              <td style="text-align:center; font-weight:bold;">{{ $loop->iteration }}</td>
              <td>{{ $prestamo->cliente->nombre }} {{ $prestamo->cliente->apellido }}</td>
              <td>{{ $prestamo->modalidad }}</td>
              <td>{{ number_format($prestamo->monto_prestado, 2) }}</td>
              <td>{{ $prestamo->nro_cuotas  }}</td>
              <td style="text-align:center;">
                @if ($prestamo->estado == 'pendiente')
                  <span class="badge bg-warning">Pendiente</span>
                @elseif ($prestamo->estado == 'pagado')
                  <span class="badge bg-success">Pagado</span>
                @else
                  <span class="badge bg-danger">Vencido</span>
                @endif
              </td>
              <td style="text-align:center; white-space:nowrap;">
                <div class="btn-group" role="group">
                <a href="{{ route('prestamos.show', $prestamo->id) }}" class="btn btn-info" title="Ver">
                <i class="fas fa-eye"></i>
                </a>
                  <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalEditarPrestamo{{ $prestamo->id }}" title="Editar">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ url('/admin/prestamos/' . $prestamo->id) }}" id="formEliminar{{ $prestamo->id }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="confirmarEliminacion{{ $prestamo->id }}(event)" title="Eliminar">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </form>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                  function confirmarEliminacion{{ $prestamo->id }}(event) {
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
                        document.getElementById('formEliminar{{ $prestamo->id }}').submit();
                      }
                    });
                  }
                </script>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

        @if(method_exists($prestamos, 'links'))
        <div class="mt-2">
          {{ $prestamos->links() }}
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
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Préstamos",
            "infoEmpty": "Mostrando 0 a 0 de 0 Préstamos",
            "infoFiltered": "(Filtrado de _MAX_ total Préstamos)",
            "lengthMenu": "Mostrar _MENU_ Préstamos",
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
