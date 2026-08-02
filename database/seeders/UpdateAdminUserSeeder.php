<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UpdateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@camionesventa.com')->first();
        
        if ($user) {
            $user->update(['is_admin' => true]);
            $this->command->info('✅ Usuario admin actualizado');
        } else {
            $this->command->error('❌ Usuario no encontrado');
        }
    }
}