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

    <li class="breadcrumb-item active" aria-current="page">Listado de sucursales</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title"><b>Sucursales registradas</b></h3>

                <div class="card-tools">
                    <a href="{{ url('/admin/sucursales/create') }}" class="btn btn-primary">
                    Crear nuevo</a>
                </div>
              </div>

              <div class="card-body" style="display: block;">

<table id="example1" class="table table-striped table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th style="text-align:center">Nro</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Activa</th>
            <th style="text-align:center">Acciones</th>
        </tr>
    </thead>
    <tbody>
          @foreach ($sucursales as $sucursal)
            <tr>
                <td style="text-align: center; font-weight: bold; font-size: 16px;">
                    {{ $loop->iteration }}
                </td>
                <td>{{ $sucursal->nombre }}</td>
                <td>{{ $sucursal->direccion }}</td>
                <td>{{ $sucursal->telefono }}</td>
                <td>{{ $sucursal->email }}</td>
                <td style="text-align: center;">
                    @if ($sucursal->activa)
                        <span class="badge bg-success">Sí</span>
                    @else
                        <span class="badge bg-danger">No</span>
                    @endif
                </td>
                <td style="text-align: center">
                    <div class="btn-group" role="group">
                        <a href="{{ url('/admin/sucursales/' . $sucursal->id) }}" class="btn btn-info">
                          <i class="fas fa-eye"></i> Ver
                        </a>

                        <a href="{{ url('/admin/sucursales/' . $sucursal->id . '/edit') }}" class="btn btn-success">
                            <i class="fas fa-pencil-alt"></i> Editar
                        </a>

                        <form action="{{ url('/admin/sucursales/' . $sucursal->id) }}" id="miformulario{{ $sucursal->id }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="confirmarEliminacion{{ $sucursal->id }}(event)">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </form>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <script>
                        function confirmarEliminacion{{ $sucursal->id }}(event) {
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
                                    document.getElementById('miformulario{{ $sucursal->id }}').submit();
                                }
                            });
                        }
                        </script>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

              </div>
            </div>
          </div>
    </div>
@stop

@section('css')
   <style>
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
</style>
@stop

@section('js')
    <script>
    $(function () {
        $("#example1").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Sucursales",
                "infoEmpty": "Mostrando 0 a 0 de 0 Sucursales",
                "infoFiltered": "(Filtrado de _MAX_ total Sucursales)",
                "lengthMenu": "Mostrar _MENU_ Sucursales",
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
