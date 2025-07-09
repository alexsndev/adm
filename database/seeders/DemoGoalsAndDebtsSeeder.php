<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Goal;
use App\Models\Debt;
use App\Models\User;

class DemoGoalsAndDebtsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) return;

        // Metas de exemplo
        $goals = [
            [
                'name' => 'Viagem dos Sonhos',
                'target_amount' => 10000,
                'current_amount' => 2500,
                'target_date' => now()->addMonths(12)->format('Y-m-d'),
            ],
            [
                'name' => 'Reserva de Emergência',
                'target_amount' => 5000,
                'current_amount' => 3200,
                'target_date' => now()->addMonths(6)->format('Y-m-d'),
            ],
            [
                'name' => 'Comprar um Carro',
                'target_amount' => 40000,
                'current_amount' => 8000,
                'target_date' => now()->addMonths(18)->format('Y-m-d'),
            ],
            [
                'name' => 'Curso de Especialização',
                'target_amount' => 7000,
                'current_amount' => 1000,
                'target_date' => now()->addMonths(8)->format('Y-m-d'),
            ],
        ];
        foreach ($goals as $goal) {
            Goal::create(array_merge($goal, ['user_id' => $user->id]));
        }

        // Dívidas de exemplo
        $debts = [
            [
                'name' => 'Empréstimo Banco',
                'original_amount' => 12000,
                'current_balance' => 12000,
                'status' => 'active',
                'start_date' => now()->subMonths(2)->format('Y-m-d'),
                'debt_type' => 'personal_loan',
            ],
            [
                'name' => 'Cartão de Crédito',
                'original_amount' => 3500,
                'current_balance' => 2000,
                'status' => 'active',
                'start_date' => now()->subMonths(1)->format('Y-m-d'),
                'debt_type' => 'credit_card',
            ],
            [
                'name' => 'Financiamento Carro',
                'original_amount' => 18000,
                'current_balance' => 15000,
                'status' => 'active',
                'start_date' => now()->subMonths(6)->format('Y-m-d'),
                'debt_type' => 'car_loan',
            ],
            [
                'name' => 'Empréstimo Pessoal',
                'original_amount' => 5000,
                'current_balance' => 3000,
                'status' => 'active',
                'start_date' => now()->subMonths(3)->format('Y-m-d'),
                'debt_type' => 'personal_loan',
            ],
        ];
        foreach ($debts as $debt) {
            Debt::create(array_merge($debt, ['user_id' => $user->id]));
        }
    }
}
