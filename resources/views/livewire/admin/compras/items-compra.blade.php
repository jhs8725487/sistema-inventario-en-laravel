<div>
    {{-- ============================
         FORMULARIO Y TABLA EN DOS COLUMNAS
    ============================ --}}
    <div class="row">
        {{-- ============================
             IZQUIERDA - FORMULARIO
        ============================ --}}
        <div class="col-md-5">
            <div class="row">
                {{-- Producto --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="productoId">Producto <b class="text-danger">*</b></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                            </div>
                            <select id="productoId" wire:model.live="productoId" class="form-control">
                                <option value="">Seleccione un producto...</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}">
                                        {{ $producto->codigo . ' - ' . $producto->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('productoId') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- Cantidad --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cantidad">Cantidad <b class="text-danger">*</b></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
                            </div>
                            <input type="number" id="cantidad" wire:model="cantidad" class="form-control" min="1">
                        </div>
                        @error('cantidad') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- Lote --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="codigoLote">Lote <b class="text-danger">*</b></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            </div>
                            <input type="text" id="codigoLote" wire:model="codigoLote" class="form-control" placeholder="Ingrese el lote">
                        </div>
                        @error('codigoLote') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- Precio Unitario --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="precioUnitario">Precio Unitario <b class="text-danger">*</b></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                            <input type="number" id="precioUnitario" wire:model="precioUnitario" class="form-control" min="0" step="0.01" placeholder="0.00">
                        </div>
                        @error('precioUnitario') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- Precio Venta --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="precioVenta">Precio Venta <b class="text-danger">*</b></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tags"></i></span>
                            </div>
                            <input type="number" id="precioVenta" wire:model="precioVenta" class="form-control" min="0" step="0.01" placeholder="0.00">
                        </div>
                        @error('precioVenta') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- Fecha de Vencimiento --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="fechaVencimiento">Fecha de Vencimiento <b class="text-danger">*</b></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" id="fechaVencimiento" wire:model="fechaVencimiento" class="form-control">
                        </div>
                        @error('fechaVencimiento') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- Botón agregar --}}
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="button" wire:click="agregarItems" class="btn btn-success btn-block">
                        <i class="fas fa-plus-circle"></i> Agregar
                    </button>
                </div>
            </div>
        </div>

        {{-- ============================
             DERECHA - TABLA
        ============================ --}}
        <div class="col-md-7">
            <h3>Productos de la compra</h3>
            <table class="table table-striped table-bordered table-hover table-sm">
                <thead class="thead-light">
                    <tr>
                        <th style="text-align:center;">Nro</th>
                        <th>Producto</th>
                        <th>Lote</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Precio Venta</th>
                        <th>SubTotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($compra->detalles as $detalle)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $detalle->producto->nombre }}</td>
                            <td>{{ $detalle->lote->codigo }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>{{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td>{{ number_format($detalle->precio_venta, 2) }}</td>
                            <td>{{ number_format($detalle->subtotal, 2) }}</td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm" wire:click="borrarItem({{ $detalle->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No hay productos agregados a la compra.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-2">
                <strong>Total de la compra</strong><br>
                <span class="text-success"><b>{{ number_format($totalCompra, 2) }}</b></span>
            </div>
        </div>
    </div>

    {{-- ============================
         ALERTAS CON SWEETALERT
    ============================ --}}
    <div x-data x-on:mostrar-alerta.window="
        Swal.fire({
            icon: $event.detail.icono,
            title: $event.detail.mensaje,
            showConfirmButton: false,
            timer: 2000
        })
    "></div>
</div>
