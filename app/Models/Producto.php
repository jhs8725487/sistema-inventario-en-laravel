<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'codigo',
        'nombre',
        'descripcion',
        'imagen',
        'precio_compra',
        'precio_venta',
        'stock_minimo',
        'stock_maximo',
        'unidad_medida',
        'estado',
    ];

     // Relación: un producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

      /**
     * Relación: un producto puede tener muchos lotes
     */
    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class);
    }

}
