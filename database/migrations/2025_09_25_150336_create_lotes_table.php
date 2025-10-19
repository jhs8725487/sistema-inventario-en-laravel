<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')
                  ->constrained('productos')     // clave foránea a productos
                  ->cascadeOnDelete();
            $table->string('codigo', 50)->unique();
            $table->integer('cantidad_inicial');
            $table->integer('cantidad_actual');
            $table->date('fecha_entrada')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->decimal('precio_compra', 10, 2);
            $table->boolean('estado')->default(true);
            $table->timestamps();               // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};
