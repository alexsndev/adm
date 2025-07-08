<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;

class ProjectDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            return;
        }

        // Criar clientes de exemplo
        $clients = [
            [
                'name' => 'Tech Solutions Ltda',
                'email' => 'contato@techsolutions.com',
                'phone' => '(11) 99999-9999',
                'company' => 'Tech Solutions Ltda',
                'address' => 'Rua das Tecnologias, 123 - São Paulo/SP',
                'tax_id' => '12.345.678/0001-90',
                'hourly_rate' => 150.00,
                'notes' => 'Cliente de tecnologia, projetos web e mobile.',
            ],
            [
                'name' => 'Maria Silva',
                'email' => 'maria.silva@email.com',
                'phone' => '(21) 88888-8888',
                'company' => 'Consultoria Silva',
                'address' => 'Av. das Consultorias, 456 - Rio de Janeiro/RJ',
                'tax_id' => '123.456.789-00',
                'hourly_rate' => 120.00,
                'notes' => 'Consultora independente, projetos de marketing digital.',
            ],
            [
                'name' => 'Startup Inovação',
                'email' => 'ola@startupinovacao.com',
                'phone' => '(31) 77777-7777',
                'company' => 'Startup Inovação',
                'address' => 'Rua da Inovação, 789 - Belo Horizonte/MG',
                'tax_id' => '98.765.432/0001-10',
                'hourly_rate' => 200.00,
                'notes' => 'Startup focada em inovação, projetos desafiadores.',
            ],
        ];

        foreach ($clients as $clientData) {
            $client = Client::create(array_merge($clientData, ['user_id' => $user->id]));
            
            // Criar projetos para cada cliente
            $projects = [
                [
                    'name' => 'Website Corporativo',
                    'description' => 'Desenvolvimento de website moderno e responsivo para a empresa.',
                    'status' => 'in_progress',
                    'priority' => 'high',
                    'start_date' => now()->subDays(30),
                    'due_date' => now()->addDays(15),
                    'budget' => 15000.00,
                    'hourly_rate' => 150.00,
                    'estimated_hours' => 100,
                    'notes' => 'Projeto em andamento, design já aprovado.',
                ],
                [
                    'name' => 'App Mobile',
                    'description' => 'Aplicativo mobile para iOS e Android com funcionalidades avançadas.',
                    'status' => 'planning',
                    'priority' => 'medium',
                    'start_date' => now()->addDays(7),
                    'due_date' => now()->addDays(60),
                    'budget' => 25000.00,
                    'hourly_rate' => 150.00,
                    'estimated_hours' => 160,
                    'notes' => 'Projeto em fase de planejamento, aguardando aprovação do design.',
                ],
                [
                    'name' => 'Sistema de Gestão',
                    'description' => 'Sistema completo de gestão empresarial com módulos integrados.',
                    'status' => 'completed',
                    'priority' => 'urgent',
                    'start_date' => now()->subDays(90),
                    'due_date' => now()->subDays(10),
                    'completed_date' => now()->subDays(10),
                    'budget' => 35000.00,
                    'hourly_rate' => 150.00,
                    'estimated_hours' => 200,
                    'notes' => 'Projeto concluído com sucesso, cliente satisfeito.',
                ],
            ];

            foreach ($projects as $projectData) {
                Project::create(array_merge($projectData, [
                    'user_id' => $user->id,
                    'client_id' => $client->id,
                ]));
            }
        }
    }
}
