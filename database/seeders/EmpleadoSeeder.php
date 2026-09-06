<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpleadoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('empleados')->insertOrIgnore([
            [
                'numero_empleado' => 'EMP-DIF-001',
                'nombre' => 'María Elena',
                'primer_apellido' => 'González',
                'segundo_apellido' => 'Pérez',
                'cargo' => 'Directora General del SMDIF',
                'unidad_administrativa_id' => 1, // Dirección General
                'correo_institucional' => 'direccion@difsanantoniolaisla.gob.mx',
                'estatus' => 'Activo',
                'created_at' => now(),
            ],
            [
                'numero_empleado' => 'EMP-DIF-002',
                'nombre' => 'Carlos',
                'primer_apellido' => 'Ramírez',
                'segundo_apellido' => 'Sánchez',
                'cargo' => 'Coordinador de Terapia Física',
                'unidad_administrativa_id' => 3, // URIS
                'correo_institucional' => 'uris.terapia@difsanantoniolaisla.gob.mx',
                'estatus' => 'Activo',
                'created_at' => now(),
            ],
            [
                'numero_empleado' => 'EMP-DIF-003',
                'nombre' => 'Laura',
                'primer_apellido' => 'Martínez',
                'segundo_apellido' => 'López',
                'cargo' => 'Contadora General',
                'unidad_administrativa_id' => 6, // Coordinación Administrativa
                'correo_institucional' => 'contabilidad@difsanantoniolaisla.gob.mx',
                'estatus' => 'Activo',
                'created_at' => now(),
            ],
        ]);
    }
}