<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'ale@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin'), // senha: admin
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );
    }
} 