<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tipo::create(['nombre' =>'Muebles y Enseres']);
        Tipo::create(['nombre' =>'Equipo de computación']);
        Tipo::create(['nombre' =>'Terreno']);
        Tipo::create(['nombre' =>'Edificio']);
        Tipo::create(['nombre' =>'Muebles y Enseres para educación']);
        Tipo::create(['nombre' =>'Herramientas']);
        Tipo::create(['nombre' =>'Equipo de seguridad y vigilancia']);
        Tipo::create(['nombre' =>'Equipo de instalaciones']);
        Tipo::create(['nombre' =>'Equipos academicos']);
    }
}
