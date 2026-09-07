<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Administrador (Contraloría / Dirección)
        User::updateOrCreate(
            ['email' => 'admin@smdifsai.gob.mx'],
            [
                'name' => 'Administrador del Sistema',
                'password' => Hash::make('AdminDIF2026!'),
                'rol' => 'admin',
            ]
        );

        // 2. Auxiliar (Almacén e Inventario Físico)
        User::updateOrCreate(
            ['email' => 'almacen@smdifsai.gob.mx'],
            [
                'name' => 'Auxiliar de Patrimonio',
                'password' => Hash::make('Almacen2026!'),
                'rol' => 'auxiliar',
            ]
        );
    }
}