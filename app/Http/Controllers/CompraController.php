<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Sucursal;
use App\Models\InventarioSucursalLote;
use App\Models\MovimientoInventario;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompraProveedorMail;
use Illuminate\Support\Facades\DB;
class CompraController extends Controller
{
    public function index()
        {
            // Obtenemos todas las compras
            $compras = Compra::all();

            // Retornamos la vista con los datos
            return view('admin.compras.index', compact('compras'));
        }

    public function create()
    {
         // Si también necesitas listarlos aparte (ej. para selects)
        $productos = Producto::all();
        $clientes = Cliente::all();
        $sucursales = Sucursal::all();

        return view('admin.compras.create', compact('productos', 'clientes', 'sucursales'));
    }



    public function store(Request $request)
        {
            // Validación
            $request->validate([
                'cliente_id'    => 'required|exists:clientes,id',
                'fecha'         => 'required|date',
                'observaciones' => 'nullable|string|max:255',
            ]);

            // Crear objeto compra
            $compra = new Compra();
            $compra->cliente_id    = $request->cliente_id;
            $compra->fecha         = $request->fecha;
            $compra->observaciones = $request->observaciones;
            $compra->total         = 0;              // Inicializar en 0
            $compra->estado        = 'pendiente';    // Estado inicial
            $compra->save();

            // Redirigir al edit para añadir productos
            return redirect()
                ->route('compras.edit', $compra->id)
                ->with('message', 'Compra creada exitosamente, ahora puede añadir productos')
                ->with('icono', 'success');
        }

    public function edit($id)
    {
        // Buscar la compra
        $compra = Compra::findOrFail($id);

        // Traer todos los clientes
        $clientes = Cliente::all();

        // Traer todos los productos
        $productos = Producto::all();

        // Traer todas las sucursales
        $sucursales = Sucursal::all();

        return view('admin.compras.edit', compact('compra', 'clientes', 'productos', 'sucursales'));
    }

    public function enviarCorreo(Compra $compra)
        {
        // Cargar relaciones necesarias
        $compra->load('detalles.producto', 'cliente');

                // Cambiar el estado de la compra
        $compra->estado = 'Enviado al proveedor';
        $compra->save();

        // Obtener el correo del cliente
        $clienteEmail = $compra->cliente->email;

        // Enviar el correo usando tu Mailable
        Mail::to($clienteEmail)->send(new CompraProveedorMail($compra));



        // Redirigir con mensaje de éxito
        return redirect()
            ->route('compras.edit', $compra->id)
            ->with('message', 'Correo enviado exitosamente al cliente')
            ->with('icono', 'success');
        }

public function finalizarCompra(Request $request, Compra $compra){
    $compra->load('detalles.producto', 'cliente');
    $detalles = $compra->detalles;

    if ($detalles->isEmpty()) {
        return redirect()->back()
            ->with('mensaje', 'No se puede finalizar la compra sin productos')
            ->with('icono', 'error');
    }

    $request->validate([
        'sucursal_id' => 'required',
    ]);

    DB::beginTransaction();
    try{

        foreach($detalles as $detalle){
            $lote = $detalle->lote;
            $producto = $detalle->producto;

            //actualizar la cantidad del lote en la tabla lotes
            $lote->cantidad_actual = $lote->cantidad_actual + $detalle->cantidad;
            $lote->save();

            //actualizar o crear el registro en inventario_sucursal_lote
            $inventariolote = InventarioSucursalLote::firstOrNew([
                'lote_id' => $lote->id,
                'sucursal_id' => $request->sucursal_id,
                'producto_id' => $producto->id,
            ]);

            $inventariolote->cantidad_en_sucursal = $inventariolote->cantidad_en_sucursal + $detalle->cantidad;
            $inventariolote->save();

            //registrar el movimiento en la tabla movimientos_inventario
            $movimiento = MovimientoInventario::create([
                'producto_id' => $producto->id,
                'lote_id' => $lote->id,
                'sucursal_id' => $request->sucursal_id,
                'cantidad' => $detalle->cantidad,
                'fecha' => now(),
            ]);
        }

        //actualizar el estado de la compra
        $compra->estado = 'Recibido';
        $compra->save();

        DB::commit();

        return redirect()->route('compras.index')
            ->with('message', 'La compra se finalizó exitosamente')
            ->with('icono', 'success');

    }catch(\Exception $e){
        DB::rollBack();
        dd('Error al añadir el producto, '.$e->getMessage());
    }
}





}
