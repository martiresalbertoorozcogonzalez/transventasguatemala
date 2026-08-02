<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@camionesventa.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        // Usuario normal de prueba
        User::create([
            'name' => 'Usuario Test',
            'email' => 'usuario@test.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}