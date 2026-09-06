<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resguardos', function (Blueprint $table) {
            $table->id();
            $table->string('folio_resguardo', 50)->unique();
            $table->foreignId('empleado_id')->constrained('empleados');
            $table->date('fecha_emision');
            $table->date('fecha_cierre')->nullable();
            $table->enum('estatus', ['Vigente', 'Finiquitado', 'Cancelado'])->default('Vigente');
            $table->string('ruta_cedula_pdf', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resguardos');
    }
};
