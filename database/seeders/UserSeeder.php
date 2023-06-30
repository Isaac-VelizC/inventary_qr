<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' =>'SuperMan',
            'email' => 'Super.User@gmail.com',
            'password' => bcrypt('SuperUser.'),
            'admin' => true,
            'tipo_user' => '1',
        ]);
        User::create([
            'name' =>'Administrador',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('AdminUpds.'),
            'admin' => true,
            'tipo_user' => '2',
        ]);
        User::create([
            'name' =>'Usuario1 UPDS',
            'email' => 'usuario1.upds@gmail.com',
            'password' => bcrypt('UsuarioUpds1'),
            'admin' => false,
            'tipo_user' => '0',
        ]);
    }
}

//usuario normal: quitar d

//Usuario: Upds@gmail.com
//Contraseña: 12345
