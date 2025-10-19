@extends('adminlte::page')

@section('content_header')
 <nav aria-label="breadcrumb" style="font-size:18pt">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ url('/admin') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Listado de clientes</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
          <div class="card-header">
            <h3 class="card-title"><b>Clientes registrados</b></h3>

            <div class="card-tools">
                        <!-- Botón que abre el modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCrearCliente">
                    <i class="fas fa-plus"></i> Crear nuevo
                </button>
            </div>
          </div>

          <div class="card-body table-responsive">
            <table id="example1" class="table table-striped table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th style="text-align:center">Nro</th>
                        <th>CI</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th style="text-align:center">Activo</th>
                        <th style="text-align:center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td style="text-align:center; font-weight:bold;">
                                {{ $loop->iteration }}
                            </td>
                            <td>{{ $cliente->ci }}</td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->apellido }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ $cliente->direccion }}</td>
                            <td style="text-align:center;">
                                @if ($cliente->activo)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </td>
                            <td style="text-align:center; white-space:nowrap;">
                                <div class="btn-group" role="group">


                                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modalVerCliente{{ $cliente->id }}" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>

                        <!-- Modal Ver Cliente: fuera del <tr>, pero dentro del foreach -->
                        <div class="modal fade" id="modalVerCliente{{ $cliente->id }}" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header bg-info text-white">
                                <h5 class="modal-title">
                                  <i class="fas fa-user"></i> Detalle del Cliente
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <table class="table table-bordered">
                                  <tr><th>CI</th><td>{{ $cliente->ci }}</td></tr>
                                  <tr><th>Nombre</th><td>{{ $cliente->nombre }}</td></tr>
                                  <tr><th>Apellido</th><td>{{ $cliente->apellido }}</td></tr>
                                  <tr><th>Teléfono</th><td>{{ $cliente->telefono }}</td></tr>
                                  <tr><th>Email</th><td>{{ $cliente->email }}</td></tr>
                                  <tr><th>Dirección</th><td>{{ $cliente->direccion }}</td></tr>
                                  <tr>
                                    <th>Activo</th>
                                    <td>
                                      @if ($cliente->activo)
                                        <span class="badge bg-success">Sí</span>
                                      @else
                                        <span class="badge bg-danger">No</span>
                                      @endif
                                    </td>
                                  </tr>
                                </table>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                  <i class="fas fa-times"></i> Cerrar
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>

                                    
                              <a href="#" class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#modalEditarCliente{{ $cliente->id }}"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                              </a>

                        <!-- Modal Editar Cliente -->
                        <div class="modal fade" id="modalEditarCliente{{ $cliente->id }}" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                              <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">
                                  <i class="fas fa-user-edit"></i> Editar Cliente
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <form action="{{ url('/admin/clientes/' . $cliente->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-6 mb-3">
                                      <label for="ci{{ $cliente->id }}">CI</label>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input type="text" name="ci" id="ci{{ $cliente->id }}" class="form-control"
                                              value="{{ $cliente->ci }}" required>
                                      </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                      <label for="telefono{{ $cliente->id }}">Teléfono</label>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" name="telefono" id="telefono{{ $cliente->id }}" class="form-control"
                                              value="{{ $cliente->telefono }}">
                                      </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                      <label for="nombre{{ $cliente->id }}">Nombre</label>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" name="nombre" id="nombre{{ $cliente->id }}" class="form-control"
                                              value="{{ $cliente->nombre }}" required>
                                      </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                      <label for="apellido{{ $cliente->id }}">Apellido</label>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        </div>
                                        <input type="text" name="apellido" id="apellido{{ $cliente->id }}" class="form-control"
                                              value="{{ $cliente->apellido }}" required>
                                      </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                      <label for="email{{ $cliente->id }}">Email</label>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" name="email" id="email{{ $cliente->id }}" class="form-control"
                                              value="{{ $cliente->email }}">
                                      </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                      <label for="direccion{{ $cliente->id }}">Dirección</label>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        </div>
                                        <input type="text" name="direccion" id="direccion{{ $cliente->id }}" class="form-control"
                                              value="{{ $cliente->direccion }}">
                                      </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                      <label for="activo{{ $cliente->id }}">Activo</label>
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                                        </div>
                                        <select name="activo" id="activo{{ $cliente->id }}" class="form-control">
                                          <option value="1" {{ $cliente->activo ? 'selected' : '' }}>Sí</option>
                                          <option value="0" {{ !$cliente->activo ? 'selected' : '' }}>No</option>
                                        </select>
                                      </div>
                                    </div>

                                  </div>
                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-times"></i> Cancelar
                                  </button>
                                  <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar cambios
                                  </button>
                                </div>
                              </form>

                            </div>
                          </div>
                        </div>



                                    <form action="{{ url('/admin/clientes/' . $cliente->id) }}" id="formEliminar{{ $cliente->id }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="confirmarEliminacion{{ $cliente->id }}(event)" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                                <!-- SweetAlert -->
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script>
                                function confirmarEliminacion{{ $cliente->id }}(event) {
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
                                            document.getElementById('formEliminar{{ $cliente->id }}').submit();
                                        }
                                    });
                                }
                                </script>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if(method_exists($clientes, 'links'))
                <div class="mt-2">
                    {{ $clientes->links() }}
                </div>
            @endif
          </div>
        </div>
    </div>
</div>


<!-- Modal Crear Cliente -->
<div class="modal fade" id="modalCrearCliente" tabindex="-1" aria-labelledby="modalCrearClienteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalCrearClienteLabel"><i class="fas fa-user-plus"></i> Registrar Cliente</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ url('/admin/clientes/create') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="ci">CI</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                </div>
                <input type="text" name="ci" id="ci" class="form-control" required>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="telefono">Teléfono</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                </div>
                <input type="text" name="telefono" id="telefono" class="form-control">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="nombre">Nombre</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="apellido">Apellido</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                </div>
                <input type="text" name="apellido" id="apellido" class="form-control" required>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="email">Email</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="email" name="email" id="email" class="form-control">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="direccion">Dirección</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                </div>
                <input type="text" name="direccion" id="direccion" class="form-control">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="activo">Activo</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                </div>
                <select name="activo" id="activo" class="form-control">
                  <option value="1" selected>Sí</option>
                  <option value="0">No</option>
                </select>
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Guardar
          </button>
        </div>
      </form>

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
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Clientes",
            "infoEmpty": "Mostrando 0 a 0 de 0 Clientes",
            "infoFiltered": "(Filtrado de _MAX_ total Clientes)",
            "lengthMenu": "Mostrar _MENU_ Clientes",
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
            { "orderable": false, "targets": [7, 8] } // desactivar orden en columnas Activo y Acciones
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


