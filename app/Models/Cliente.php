<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
     use HasFactory;

    // Tabla asociada (opcional, Laravel lo infiere automáticamente)
    protected $table = 'clientes';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'apellido',
        'ci',
        'telefono',
        'email',
        'direccion',
        'activo',
    ];

    // Casts: para convertir tipos automáticamente
    protected $casts = [
        'activo' => 'boolean',
    ];

    // Opcional: concatenar nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    // 🔹 Un cliente puede tener muchos préstamos
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}
