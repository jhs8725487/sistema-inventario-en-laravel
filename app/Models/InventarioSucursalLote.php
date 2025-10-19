<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioSucursalLote extends Model
{
    use HasFactory;

    protected $table = 'inventario_sucursal_lote'; // Nombre exacto de la tabla

    protected $fillable = [
        'producto_id',
        'sucursal_id',
        'lote_id',
        'cantidad_en_sucursal',
    ];

    // Relaciones opcionales
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }
}
