<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    use HasFactory;

    // Nombre exacto de la tabla
    protected $table = 'movimientos_inventario';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'producto_id',
        'lote_id',
        'sucursal_id',
        'tipo_movimiento',   // ej. 'entrada', 'salida'
        'cantidad',
        'fecha',
        'descripcion',
    ];

    // Relaciones (opcional, pero recomendado)
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
