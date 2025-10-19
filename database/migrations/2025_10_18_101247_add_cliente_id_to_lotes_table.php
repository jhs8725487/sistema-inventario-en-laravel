<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->foreignId('cliente_id')
                  ->nullable() // si quieres permitir que haya lotes sin cliente
                  ->after('producto_id')
                  ->constrained('clientes')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('lotes', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']);
            $table->dropColumn('cliente_id');
        });
    }
};

