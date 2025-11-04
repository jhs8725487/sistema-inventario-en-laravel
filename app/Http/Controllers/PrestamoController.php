<?php

namespace App\Http\Controllers;
use App\Models\Prestamo;
use Carbon\Carbon;
use App\Models\Pago;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Producto; // <- importante

class PrestamoController extends Controller
{
       // Mostrar todos los préstamos
    public function index()
    {
        // Obtenemos todos los préstamos con el cliente relacionado
        $prestamos = Prestamo::with('cliente')->get();
        $clientes = Cliente::all(); // para usar en el modal de crear préstamo

       

        // Retornamos la vista con los datos
        return view('admin.prestamos.index', compact('prestamos', 'clientes'));
    }

    public function create()
    {
        // Trae los clientes (ordenados por nombre)
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::orderBy('id', 'desc')->take(20)->get();
        

        // Pasa la variable a la vista
        //return view('admin.prestamos.create', compact('clientes'));
        return view('admin.prestamos.create', compact('clientes', 'productos'));
    }
    public function obtenerCliente($id)
    {
        $cliente = \App\Models\Cliente::find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente);
    }

 public function store(Request $request)
{
    // 1️⃣ Validar los datos del formulario
        $request->validate([
        'cliente_id'       => 'required|exists:clientes,id',
        'total_prestamo'   => 'required|numeric|min:0',
        'modalidad'        => 'required|string',
        'numero_cuotas'    => 'required|integer|min:1',
        'fecha_prestamo'   => 'required|date',
    ]);

    // 2️⃣ Crear el préstamo
    $prestamo = new Prestamo();
    $prestamo->cliente_id   = $request->cliente_id;
    $prestamo->monto_prestado = $request->total_prestamo; 
    $prestamo->monto_total  = $request->total_prestamo;
    $prestamo->modalidad    = $request->modalidad;
    $prestamo->nro_cuotas   = $request->numero_cuotas;
    $prestamo->fecha_inicio = $request->fecha_prestamo;
    $prestamo->estado       = 'pendiente';
    $prestamo->save();

    // 3️⃣ Generar pagos programados
    $fechaInicio = Carbon::parse($request->fecha_prestamo);
    $montoPorPago = round($prestamo->monto_total / $prestamo->nro_cuotas, 2);

    for ($i = 1; $i <= $prestamo->nro_cuotas; $i++) {
        $pago = new Pago();
        $pago->prestamo_id     = $prestamo->id;
        $pago->monto_pagado    = 0; // aún no se paga
        $pago->estado          = 'pendiente';
        $pago->metodo_pago     = 'pendiente';
        $pago->referencia_pago = 'Pago N° ' . $i;

        // 4️⃣ Calcular fecha de vencimiento según modalidad
        switch ($request->modalidad) {
            case 'Diario':
                $fechaPago = $fechaInicio->copy()->addDays($i);
                break;
            case 'Semanal':
                $fechaPago = $fechaInicio->copy()->addWeeks($i);
                break;
            case 'Quincenal':
                $fechaPago = $fechaInicio->copy()->addDays($i * 15);
                break;
            case 'Mensual':
                $fechaPago = $fechaInicio->copy()->addMonths($i);
                break;
            case 'Anual':
                $fechaPago = $fechaInicio->copy()->addYears($i);
                break;
            default:
                $fechaPago = $fechaInicio->copy()->addMonths($i);
                break;
        }

        $pago->fecha_pago = $fechaPago;
        $pago->save();
    }

    // 5️⃣ Redirigir con mensaje de éxito
    return redirect()
        ->route('prestamos.index')
        ->with('mensaje', '✅ Se registró el préstamo y los pagos correctamente.')
        ->with('icono', 'success');
}

public function show($id)
{
    $prestamo = Prestamo::with(['cliente', 'pagos'])->findOrFail($id);
    return view('admin.prestamos.show', compact('prestamo'));
}

}
