<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoInicialSeeder extends Seeder
{
    public function run(): void
    {
        // Cuentas de Activo No Circulante (CONAC / Edomex)
        DB::table('cuentas_contables')->insertOrIgnore([
            ['codigo' => '1241', 'nombre' => 'Mobiliario y Equipo de Administración', 'descripcion' => 'Muebles de oficina y enseres', 'created_at' => now()],
            ['codigo' => '1241-4', 'nombre' => 'Equipo de Cómputo y Accesorios', 'descripcion' => 'Computadoras, impresoras y servidores', 'created_at' => now()],
            ['codigo' => '1242', 'nombre' => 'Mobiliario y Equipo Educacional y Recreativo', 'descripcion' => 'Equipamiento escolar y lúdico', 'created_at' => now()],
            ['codigo' => '1243', 'nombre' => 'Equipo e Instrumental Médico y de Laboratorio', 'descripcion' => 'Aparatos de rehabilitación y clínica', 'created_at' => now()],
            ['codigo' => '1244', 'nombre' => 'Equipo de Transporte', 'descripcion' => 'Vehículos oficiales y ambulancias', 'created_at' => now()],
            ['codigo' => '1246', 'nombre' => 'Maquinaria, Otros Equipos y Herramientas', 'descripcion' => 'Herramientas de mantenimiento', 'created_at' => now()],
        ]);

        // Áreas operativas base del SMDIF
        DB::table('unidades_administrativas')->insertOrIgnore([
            ['clave' => 'DIF-DIR', 'nombre' => 'Dirección General', 'titular_area' => 'Dirección', 'created_at' => now()],
            ['clave' => 'DIF-PROCURA', 'nombre' => 'Procuraduría Municipal de Protección', 'titular_area' => 'Procurador(a)', 'created_at' => now()],
            ['clave' => 'DIF-URIS', 'nombre' => 'Unidad de Rehabilitación e Integración Social (URIS)', 'titular_area' => 'Coordinación URIS', 'created_at' => now()],
            ['clave' => 'DIF-CLIN', 'nombre' => 'Servicios Médicos y Odontológicos', 'titular_area' => 'Coordinación Médica', 'created_at' => now()],
            ['clave' => 'DIF-TS', 'nombre' => 'Trabajo Social y Programas Asistenciales', 'titular_area' => 'Coordinación Trabajo Social', 'created_at' => now()],
            ['clave' => 'DIF-ADMON', 'nombre' => 'Coordinación Administrativa y Contabilidad', 'titular_area' => 'Administrador(a)', 'created_at' => now()],
        ]);
    }
}