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
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            $table->string('red', 40);
            $table->string('codigo', 20)->nullable()->unique(); // Hacer el campo código opcional
            $table->string('ubicacion', 40);
            $table->date('fecha_ingreso');
            $table->tinyInteger('estado')->default(1);
            $table->string('identificador_socio')->unique(); // Nuevo campo identificador de socio
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};
