<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permiso::create([
            'user_id' => 1,
            'dar_baja_item' => true,
            'crear_user' => true,
            'exportar' => true,
            'editar_area' => true,
            'borrar_area' => true,
        ]);
        Permiso::create([
            'user_id' => 2,
            'dar_baja_item' => true,
            'crear_user' => false,
            'exportar' => true,
            'editar_area' => true,
            'borrar_area' => true,
        ]);
        Permiso::create([
            'user_id' => 3,
            'dar_baja_item' => false,
            'crear_user' => false,
            'exportar' => false,
            'editar_area' => true,
            'borrar_area' => true,
        ]);
    }
}
