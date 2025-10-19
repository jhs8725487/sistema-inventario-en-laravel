<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; //

class Compra extends Model
{
     use HasFactory;

    // Nombre de la tabla (opcional, Laravel lo infiere en plural)
    protected $table = 'compras';

    // Campos que se pueden asignar de manera masiva
    protected $fillable = [
        'cliente_id',
        'fecha',
        'total',
        'estado',
        'observaciones',
    ];

       // Relación: una compra tiene muchos detalles
   /* public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class);
    }*/

    public function detalles()
{
    return $this->hasMany(DetalleCompra::class, 'compra_id');
}

public function cliente()
{
    return $this->belongsTo(Cliente::class);
}


    // Si no quieres que use los timestamps automáticos
    // protected $timestamps = false;
}
