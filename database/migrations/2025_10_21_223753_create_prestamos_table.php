<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->decimal('monto_prestado', 10, 2);
            $table->decimal('tasa_interes', 5, 2)->nullable();
            $table->string('modalidad')->nullable();
            $table->integer('nro_cuotas')->nullable();
            $table->decimal('monto_total', 10, 2);
            $table->date('fecha_inicio');
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
