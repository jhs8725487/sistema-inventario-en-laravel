<?php

namespace App\Http\Controllers;
use App\Models\Lote; // 👈 ESTA LÍNEA ES LA QUE FALTABA
use App\Models\Producto; // si también usas producto
use App\Models\Cliente;  // si también usas cliente
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    public function index()
    {
        // Traer todos los lotes con producto y cliente relacionados
        $lotes = Lote::with(['producto', 'cliente'])->get();

        // Verificar si la fecha de vencimiento ya pasó
        $lotes->each(function ($lote) {
            $lote->is_expired = Carbon::parse($lote->fecha_vencimiento)->isPast();
        });

        // Pasar los datos a la vista
        return view('admin.lotes.index', compact('lotes'));
    }
}
