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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socio_id')->constrained('socios')->onDelete('cascade');
            $table->foreignId('actividad_id')->constrained('actividades')->onDelete('cascade');
            $table->boolean('asistio')->default(0); // 0=no asistió, 1=asistió
            $table->boolean('multa_aplicada')->default(0); // 0=multa no aplicada, 1=multa aplicada
            $table->timestamps();

            $table->unique(['socio_id', 'actividad_id']); // Para evitar duplicados
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
