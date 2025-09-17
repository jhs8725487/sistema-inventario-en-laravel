<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    /** @use HasFactory<\Database\Factories\SucursalFactory> */
    use HasFactory;

     // Nombre de la tabla en la base de datos
    protected $table = 'sucursals';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'activa',
    ];

    
}
