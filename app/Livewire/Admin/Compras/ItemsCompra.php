<?php

namespace App\Livewire\Admin\Compras;

use Livewire\Component;
use App\Models\Compra;
use Illuminate\Support\Facades\DB;
use App\Models\Lote;
use App\Models\Producto;

class ItemsCompra extends Component
{
    public $compra;
    public $productoId;
    public $cantidad = 1;
    public $precioUnitario;
    public $precioCompra;
    public $precioVenta;
    public $fechaVencimiento;
    public $productos;
    public $codigoLote;
    public $totalCompra;



    // este método se ejecuta cuando el componente se carga inicialmente
    public function mount(Compra $compra)
    {
        $this->compra = $compra;
        $this->productos = Producto::all();
        $this->cargarDatos();
    }

    public function cargarDatos()
    {
        $this->compra->load('detalles.producto', 'detalles.lote');
        $this->totalCompra = $this->compra->detalles->sum('subtotal');

        // reiniciar los campos del formulario
        $this->reset(['productoId', 'cantidad','precioUnitario', 'precioCompra', 'precioVenta', 'fechaVencimiento', 'codigoLote']);
        //$this->cantidad = 1;
    }

       // 🔹 Detecta cuando cambia el producto seleccionado
    public function updatedProductoId($value)
    {
        if ($value) {
            $producto = Producto::find($value);
            if ($producto) {
                $this->precioUnitario = $producto->precio_compra; // o el campo que tengas en tu BD
                $this->precioVenta = $producto->precio_venta;
            }
        } else {
            // Si se deselecciona el producto, limpia los campos
            $this->precioUnitario = null;
            $this->precioVenta = null;
        }
    }


    protected $rules = [
    'productoId' => 'required|exists:productos,id',
    'cantidad' => 'required|numeric|min:1',
    'codigoLote' => 'required|string|max:50',
    'precioUnitario' => 'required|numeric|min:0',
    'fechaVencimiento' => 'required|date|after:today',
    ];

    public function agregarItems()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $producto = Producto::find($this->productoId);
            $loteId = null;

            /// creación del lote
            $lote = Lote::create([
                'producto_id'      => $producto->id,
                'cliente_id'     => $this->compra->cliente->id,
                'codigo'      => $this->codigoLote,
                'fecha_entrada'    => now()->toDateString(),
                'fecha_vencimiento'=> $this->fechaVencimiento,
                'cantidad_inicial' => $this->cantidad,
                'cantidad_actual'  => $this->cantidad,
                'precio_compra'    => $this->precioUnitario,
                'precio_venta'     => $this->precioVenta,
                'estado'           => true,
            ]);

            $loteId = $lote->id;

            /// creación del detalle de compra
            $this->compra->detalles()->create([
                'producto_id'     => $producto->id,
                'lote_id'         => $loteId,
                'cantidad'        => $this->cantidad,
                'precio_unitario' => $this->precioUnitario,
                'subtotal'        => $this->cantidad * $this->precioUnitario,
            ]);

            // recalcular el total de la compra y lo guardamos
            $this->compra->total = $this->compra->detalles->sum('subtotal');
            $this->compra->save();

            DB::commit();

            // recargar datos en el componente
            $this->cargarDatos();

              // Disparador (evento) para mostrar la alerta
            $this->dispatch('mostrar-alerta', 
                    icono: 'success', 
                    mensaje: 'Producto agregado exitosamente.'
                );

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    

   
    public function render()
    {
        return view('livewire.admin.compras.items-compra');
    }

    public function borrarItem($detalleId)
    {
        DB::beginTransaction();
        try {
            // Buscar el detalle
            $detalle = $this->compra->detalles()->find($detalleId);

            if (!$detalle) {
                $this->dispatch('mostrar-alerta', 
                    icono: 'error', 
                    mensaje: 'No se encontró el producto.'
                );
                return;
            }

            // Eliminar el lote asociado (opcional)
            if ($detalle->lote) {
                $detalle->lote->delete();
            }

            // Eliminar el detalle
            $detalle->delete();

            // Recalcular el total de la compra
            $this->compra->load('detalles'); // recarga los detalles actualizados
            $this->compra->total = $this->compra->detalles->sum('subtotal');
            $this->compra->save();

            DB::commit();

            // Refrescar los datos en el componente
            $this->cargarDatos();

            // Mostrar alerta de éxito
            $this->dispatch('mostrar-alerta', 
                icono: 'success', 
                mensaje: 'Producto eliminado correctamente.'
            );

        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('mostrar-alerta', 
                icono: 'error', 
                mensaje: 'Ocurrió un error al eliminar el producto.'
            );

            throw $e;
        }
    }


     public function prueba()
    {
        // Disparador (evento) para mostrar la alerta
        $this->dispatch('mostrar-alerta', 
                icono: 'success', 
                mensaje: 'Operación realizada correctamente.'
            );
        $this->cantidad = $this->cantidad;
        

        
    }


    
}


