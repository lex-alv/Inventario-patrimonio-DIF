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
        Schema::create('detalle_resguardos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resguardo_id')->constrained('resguardos')->onDelete('cascade');
            $table->foreignId('bien_id')->constrained('bienes');
            $table->dateTime('fecha_asignacion');
            $table->dateTime('fecha_devolucion')->nullable();
            $table->text('observaciones_entrega')->nullable();
            $table->text('observaciones_devolucion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_resguardos');
    }
};
