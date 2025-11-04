<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('cuotas');
    }

    public function down(): void
    {
        // En caso de rollback, puedes recrearla si quieres
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_id')->constrained('prestamos')->onDelete('cascade');
            $table->integer('numero_cuota');
            $table->date('fecha_vencimiento');
            $table->decimal('monto_cuota', 10, 2);
            $table->decimal('monto_pagado', 10, 2)->default(0);
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });
    }
};
