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
        Schema::create('consumos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('socio_id')->constrained('socios')->onDelete('cascade');
                $table->integer('mes'); // Mes del consumo
                $table->integer('anio'); // Año del consumo
                $table->decimal('consumo', 8, 2); // Cantidad de agua consumida en metros cúbicos
                $table->decimal('monto_cobrar', 10, 2)->default(0); // Monto total a cobrar
                $table->decimal('total_pagado', 10, 2)->default(0); // Total pagado
                $table->decimal('deuda', 10, 2)->default(0); // Deuda pendiente
                $table->boolean('estado_pago')->default(0); // 0=pendiente, 1=pagado
                $table->decimal('lectura_anterior', 8, 2);
                $table->decimal('lectura_actual', 8, 2);
                $table->timestamps();
    
                $table->unique(['socio_id', 'mes', 'anio']); // Para evitar duplicados
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumos');
    }
};
