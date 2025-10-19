<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'producto_id',
        'cliente_id',
        'codigo',
        'cantidad_inicial',
        'cantidad_actual',
        'fecha_entrada',
        'fecha_vencimiento',
        'precio_compra',
        'estado',
    ];

    /**
     * Relación: un lote pertenece a un producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Relación: un lote pertenece a un cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación: un lote puede estar en muchos detalles de compra
     */
    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class);
    }
}
