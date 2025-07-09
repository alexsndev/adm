<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar o primeiro usuário ou criar um
        $user = User::first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'Usuário Demo',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Criar usuários de exemplo com aniversários próximos
        $users = [
            [
                'name' => 'Ana Souza',
                'email' => 'ana@example.com',
                'password' => bcrypt('password'),
                'photo' => 'https://randomuser.me/api/portraits/women/1.jpg',
                'birthdate' => now()->addDays(2)->format('Y-m-d'),
            ],
            [
                'name' => 'Bruno Lima',
                'email' => 'bruno@example.com',
                'password' => bcrypt('password'),
                'photo' => 'https://randomuser.me/api/portraits/men/2.jpg',
                'birthdate' => now()->addDays(5)->format('Y-m-d'),
            ],
            [
                'name' => 'Carla Dias',
                'email' => 'carla@example.com',
                'password' => bcrypt('password'),
                'photo' => 'https://randomuser.me/api/portraits/women/3.jpg',
                'birthdate' => now()->addDays(7)->format('Y-m-d'),
            ],
            [
                'name' => 'Diego Alves',
                'email' => 'diego@example.com',
                'password' => bcrypt('password'),
                'photo' => 'https://randomuser.me/api/portraits/men/4.jpg',
                'birthdate' => now()->addDays(10)->format('Y-m-d'),
            ],
        ];
        foreach ($users as $u) {
            User::updateOrCreate(['email' => $u['email']], $u);
        }

        // Criar categorias de receitas
        $incomeCategories = [
            ['name' => 'Salário', 'type' => 'income', 'color' => '#10B981', 'icon' => 'fa-money-bill'],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#3B82F6', 'icon' => 'fa-laptop'],
            ['name' => 'Investimentos', 'type' => 'income', 'color' => '#F59E0B', 'icon' => 'fa-chart-line'],
            ['name' => 'Presentes', 'type' => 'income', 'color' => '#EC4899', 'icon' => 'fa-gift'],
            ['name' => 'Outros', 'type' => 'income', 'color' => '#6B7280', 'icon' => 'fa-plus'],
        ];

        // Criar categorias de despesas
        $expenseCategories = [
            ['name' => 'Alimentação', 'type' => 'expense', 'color' => '#EF4444', 'icon' => 'fa-utensils'],
            ['name' => 'Transporte', 'type' => 'expense', 'color' => '#8B5CF6', 'icon' => 'fa-car'],
            ['name' => 'Moradia', 'type' => 'expense', 'color' => '#F97316', 'icon' => 'fa-home'],
            ['name' => 'Saúde', 'type' => 'expense', 'color' => '#06B6D4', 'icon' => 'fa-heartbeat'],
            ['name' => 'Educação', 'type' => 'expense', 'color' => '#84CC16', 'icon' => 'fa-graduation-cap'],
            ['name' => 'Lazer', 'type' => 'expense', 'color' => '#F43F5E', 'icon' => 'fa-gamepad'],
            ['name' => 'Vestuário', 'type' => 'expense', 'color' => '#A855F7', 'icon' => 'fa-tshirt'],
            ['name' => 'Contas', 'type' => 'expense', 'color' => '#EAB308', 'icon' => 'fa-file-invoice'],
            ['name' => 'Outros', 'type' => 'expense', 'color' => '#6B7280', 'icon' => 'fa-minus'],
        ];

        // Criar categorias
        foreach ($incomeCategories as $category) {
            Category::create(array_merge($category, ['user_id' => $user->id]));
        }

        foreach ($expenseCategories as $category) {
            Category::create(array_merge($category, ['user_id' => $user->id]));
        }

        // Criar contas padrão
        $accounts = [
            [
                'name' => 'Conta Corrente',
                'type' => 'checking',
                'initial_balance' => 5000.00,
                'current_balance' => 5000.00,
                'currency' => 'BRL',
                'description' => 'Conta principal do banco',
            ],
            [
                'name' => 'Conta Poupança',
                'type' => 'savings',
                'initial_balance' => 10000.00,
                'current_balance' => 10000.00,
                'currency' => 'BRL',
                'description' => 'Poupança para emergências',
            ],
            [
                'name' => 'Carteira',
                'type' => 'cash',
                'initial_balance' => 500.00,
                'current_balance' => 500.00,
                'currency' => 'BRL',
                'description' => 'Dinheiro em espécie',
            ],
        ];

        foreach ($accounts as $account) {
            Account::create(array_merge($account, ['user_id' => $user->id]));
        }

        $this->command->info('Dados financeiros iniciais criados com sucesso!');
        $this->command->info('Usuário: ' . $user->email);
        $this->command->info('Senha: password');
    }
}
