<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Evelyn Admin',
            'email' => 'admin@condominio.com',
            'password' => bcrypt('password123'), // bcrypt encripta la contraseña por seguridad
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Residente Dos',
            'email' => 'dos@condominio.com',
            'password' => bcrypt('password123'),
            'role' => 'residente'
        ]);

        User::create([
            'name' => 'Residente Tres',
            'email' => 'tres@condominio.com',
            'password' => bcrypt('password123'),
            'role' => 'residente'
        ]);
    }
}