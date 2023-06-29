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
            'password' => bcrypt('12345'),
            'admin' => false,
        ]);
        User::create([
            'name' =>'Administrador',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('AdminUpds'),
            'admin' => true,
        ]);
        User::create([
            'name' =>'Upds',
            'email' => 'Upds@gmail.com',
            'password' => bcrypt('12345'),
            'admin' => false,
        ]);
    }
}

//usuario normal: quitar d

//Usuario: Upds@gmail.com
//Contraseña: 12345
