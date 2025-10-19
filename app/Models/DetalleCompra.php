<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'detalle_compras';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'compra_id',
        'producto_id',
        'lote_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    /* ==========================
       Relaciones con otros modelos
       ========================== */

    // Una línea de detalle pertenece a una compra
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    // Un detalle pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Un detalle pertenece a un lote
    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }
}
