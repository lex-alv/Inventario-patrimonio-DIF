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
        Schema::create('bajas_bienes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bien_id')->constrained('bienes');
            $table->enum('tipo_baja', ['Desuso / Inservible', 'Robo / Siniestro', 'Donación', 'Dación en Pago', 'Venta']);
            $table->string('folio_acta', 100);
            $table->date('fecha_baja');
            $table->text('dictamen_tecnico');
            $table->string('documento_soporte_url', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baja_biens');
    }
};
