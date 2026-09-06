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
        Schema::create('bienes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_inventario', 50)->unique();
            $table->foreignId('cuenta_contable_id')->constrained('cuentas_contables');
            $table->foreignId('unidad_administrativa_id')->constrained('unidades_administrativas');
            $table->text('descripcion');
            $table->string('marca', 100)->nullable();
            $table->string('modelo', 100)->nullable();
            $table->string('numero_serie', 100)->nullable();
            $table->string('factura_numero', 100)->nullable();
            $table->date('fecha_adquisicion')->nullable();
            $table->decimal('costo_adquisicion', 12, 2)->default(0.00);
            $table->enum('tipo_adquisicion', ['Compra', 'Donación', 'Transferencia', 'Inventario Inicial'])->default('Compra');
            $table->enum('estado_conservacion', ['Bueno', 'Regular', 'Malo'])->default('Bueno');
            $table->enum('estatus', ['Activo', 'En Transferencia', 'En Mantenimiento', 'Baja'])->default('Activo');
            $table->text('observaciones')->nullable();
            $table->string('codigo_qr', 255)->nullable();
            $table->timestamps();

            $table->index('estatus');
            $table->index('numero_inventario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
