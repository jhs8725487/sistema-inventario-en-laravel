@extends('adminlte::page')

@section('content_header')
<nav aria-label="breadcrumb" style="font-size:18pt">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="{{ url('/admin') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item">
      <a href="{{ url('/admin/prestamos') }}">Préstamos</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Registro de un nuevo préstamo</li>
  </ol>
</nav>
<hr>
@stop

@section('content')
<form action="{{ route('prestamos.store') }}" method="POST">
  @csrf

  {{-- ===============================
        DATOS DEL CLIENTE
  =============================== --}}
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title"><b>Datos del cliente</b></h3>
        </div>

        <div class="card-body">
          {{-- Selección de cliente --}}
          <div class="form-group mb-4">
            <label for="cliente_id" class="form-label">Búsqueda del cliente <b>(*)</b></label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
              <select name="cliente_id" id="cliente_id" class="form-control" required>
                <option value="">Seleccione un cliente...</option>
                @foreach ($clientes as $cliente)
                  <option value="{{ $cliente->id }}">
                    {{ $cliente->ci }} - {{ $cliente->nombre }} {{ $cliente->apellido }}
                  </option>
                @endforeach
              </select>
            </div>
            @error('cliente_id')
              <small class="text-danger fst-italic">{{ $message }}</small>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-3">
              <label for="documento">Documento</label>
              <input type="text" name="documento" id="documento" class="form-control" readonly>
            </div>
            <div class="col-md-3">
              <label for="nombre">Nombre</label>
              <input type="text" name="nombre" id="nombre" class="form-control" readonly>
            </div>
            <div class="col-md-3">
              <label for="apellido">Apellido</label>
              <input type="text" name="apellido" id="apellido" class="form-control" readonly>
            </div>
            <div class="col-md-3">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" class="form-control" readonly>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ===============================
        PRODUCTOS SOLICITADOS
  =============================== --}}
  <div class="card card-warning mt-4">
    <div class="card-header">
      <h3 class="card-title"><b>Productos solicitados</b></h3>
    </div>

    <div class="card-body">
      <table class="table table-bordered table-striped table-sm" id="tabla-productos">
        <thead class="bg-light">
          <tr>
            <th>Producto</th>
            <th width="100">Cantidad</th>
            <th width="150">Precio unitario (Bs)</th>
            <th width="150">Subtotal (Bs)</th>
            <th width="100">Acciones</th>
          </tr>
        </thead>
        <tbody>
          {{-- Filas dinámicas agregadas con JS --}}
        </tbody>
      </table>

      <div class="text-end mt-3">
        <button type="button" class="btn btn-success" id="btnAgregarProducto">
          <i class="fas fa-plus"></i> Agregar producto
        </button>
      </div>

      <div class="mt-4 text-end">
        <h4><b>Total del préstamo: Bs <span id="total_prestamo">0.00</span></b></h4>
        <input type="hidden" name="total_prestamo" id="input_total_prestamo" value="0">
      </div>
    </div>
  </div>

  {{-- ===============================
        DATOS DEL PRÉSTAMO
  =============================== --}}
  <div class="card card-info mt-4">
    <div class="card-header">
      <h3 class="card-title"><b>Datos del préstamo</b></h3>
    </div>

    <div class="card-body">
      <div class="row">
        {{-- Modalidad --}}
        <div class="col-md-3">
          <label for="modalidad">Modalidad <b>(*)</b></label>
          <select name="modalidad" id="modalidad" class="form-control" required>
            <option value="Diario">Diario</option>
            <option value="Semanal">Semanal</option>
            <option value="Quincenal">Quincenal</option>
            <option value="Mensual">Mensual</option>
            <option value="Anual">Anual</option>
          </select>
        </div>

        {{-- Número de cuotas --}}
        <div class="col-md-3">
          <label for="numero_cuotas">Número de cuotas <b>(*)</b></label>
          <input type="number" name="numero_cuotas" id="numero_cuotas" class="form-control" min="1" required placeholder="Ej: 12">
        </div>

        {{-- Fecha del préstamo --}}
        <div class="col-md-3">
          <label for="fecha_prestamo">Fecha del préstamo <b>(*)</b></label>
          <input type="date" name="fecha_prestamo" id="fecha_prestamo" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        {{-- Monto por cuota --}}
        <div class="col-md-3">
          <label for="monto_cuota">Monto por cuota (Bs)</label>
          <input type="text" name="monto_cuota" id="monto_cuota" class="form-control" readonly>
        </div>
      </div>

      <div class="row mt-4 text-end">
        <div class="col-md-12">
          <button type="button" class="btn btn-info" id="btnCalcularPrestamo">
            <i class="fas fa-calculator"></i> Calcular préstamo
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Registrar préstamo
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
@stop

@section('js')
<script>
$(document).ready(function() {
  // ==== Cargar datos del cliente ====
  $('#cliente_id').on('change', function() {
    let id = $(this).val();
    if (id) {
      $.ajax({
        url: "{{ url('/admin/prestamos/cliente') }}/" + id,
        type: "GET",
        dataType: "json",
        success: function(cliente) {
          $('#documento').val(cliente.ci);
          $('#nombre').val(cliente.nombre);
          $('#apellido').val(cliente.apellido);
          $('#email').val(cliente.email);
        },
        error: function() {
          alert("⚠️ No se pudo obtener la información del cliente.");
        }
      });
    } else {
      $('#documento, #nombre, #apellido, #email').val('');
    }
  });

  // ==== Productos ====
  let contador = 0;
  $('#btnAgregarProducto').click(function() {
    contador++;
    let fila = `
      <tr id="fila${contador}">
        <td>
          <select name="productos[${contador}][producto_id]" class="form-control producto-select" required>
            <option value="">Seleccione...</option>
            @foreach($productos as $producto)
              <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
            @endforeach
          </select>
        </td>
        <td><input type="number" min="1" name="productos[${contador}][cantidad]" class="form-control cantidad" value="1" required></td>
        <td><input type="number" min="0" step="0.01" name="productos[${contador}][precio_unitario]" class="form-control precio" required></td>
        <td><input type="text" class="form-control subtotal" readonly></td>
        <td class="text-center">
          <button type="button" class="btn btn-danger btn-sm btnEliminar" data-id="${contador}">
            <i class="fas fa-trash"></i>
          </button>
        </td>
      </tr>
    `;
    $('#tabla-productos tbody').append(fila);
  });

  // Eliminar fila
  $(document).on('click', '.btnEliminar', function() {
    let id = $(this).data('id');
    $(`#fila${id}`).remove();
    calcularTotal();
  });

  // Calcular subtotal y total
  $(document).on('input', '.cantidad, .precio', function() {
    let fila = $(this).closest('tr');
    let cantidad = parseFloat(fila.find('.cantidad').val()) || 0;
    let precio = parseFloat(fila.find('.precio').val()) || 0;
    let subtotal = cantidad * precio;
    fila.find('.subtotal').val(subtotal.toFixed(2));
    calcularTotal();
  });

  function calcularTotal() {
    let total = 0;
    $('.subtotal').each(function() {
      total += parseFloat($(this).val()) || 0;
    });
    $('#total_prestamo').text(total.toFixed(2));
    $('#input_total_prestamo').val(total.toFixed(2)); // ✅ enviar total oculto
  }

  // ==== Calcular préstamo ====
  $('#btnCalcularPrestamo').click(function() {
    let total = parseFloat($('#total_prestamo').text()) || 0;
    let cuotas = parseInt($('#numero_cuotas').val()) || 0;
    let modalidad = $('#modalidad').val();

    if (total <= 0) return Swal.fire('Atención', 'Debes agregar productos.', 'warning');
    if (cuotas <= 0) return Swal.fire('Atención', 'Debes ingresar número de cuotas.', 'warning');

    let montoPorCuota = total / cuotas;
    $('#monto_cuota').val(montoPorCuota.toFixed(2));

    Swal.fire({
      icon: 'success',
      title: 'Cálculo realizado',
      text: `Pagará Bs ${montoPorCuota.toFixed(2)} por cuota (${modalidad}).`
    });
  });
});
</script>
@stop
