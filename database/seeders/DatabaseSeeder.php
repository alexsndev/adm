<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::updateOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo',
                'password' => Hash::make('password'), // senha: password
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'ale@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin'), // senha: admin
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );

        // Executar seeders específicos
        $this->call([
            \Database\Seeders\HouseholdTaskSeeder::class,
            \Database\Seeders\EventSeeder::class,
        ]);
    }
}
