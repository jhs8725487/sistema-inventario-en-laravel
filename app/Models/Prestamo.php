<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'monto_prestado',
        'tasa_interes',
        'modalidad',
        'nro_cuotas',
        'monto_total',
        'fecha_inicio',
        'estado',
    ];

    // 🔹 Un préstamo pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // 🔹 Un préstamo tiene muchos pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
