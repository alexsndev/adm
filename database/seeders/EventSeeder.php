<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class EventSeeder extends Seeder
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

        // Eventos de exemplo
        $events = [
            [
                'title' => 'Aniversário da Maria',
                'description' => 'Aniversário da minha irmã Maria',
                'type' => 'birthday',
                'recurrence_type' => 'yearly',
                'start_date' => Carbon::now()->subYears(25)->format('Y-m-d'),
                'time' => '19:00',
                'location' => 'Casa da família',
                'reminder_days' => 7,
                'color' => '#EF4444',
            ],
            [
                'title' => 'Aniversário de Casamento',
                'description' => 'Nosso aniversário de casamento',
                'type' => 'anniversary',
                'recurrence_type' => 'yearly',
                'start_date' => Carbon::now()->subYears(5)->format('Y-m-d'),
                'time' => '20:00',
                'location' => 'Restaurante favorito',
                'reminder_days' => 14,
                'color' => '#10B981',
            ],
            [
                'title' => 'Natal',
                'description' => 'Celebração de Natal com a família',
                'type' => 'holiday',
                'recurrence_type' => 'yearly',
                'start_date' => Carbon::now()->year . '-12-25',
                'time' => '18:00',
                'location' => 'Casa dos pais',
                'reminder_days' => 30,
                'color' => '#F59E0B',
            ],
            [
                'title' => 'Ano Novo',
                'description' => 'Celebração de Ano Novo',
                'type' => 'holiday',
                'recurrence_type' => 'yearly',
                'start_date' => Carbon::now()->year . '-12-31',
                'time' => '22:00',
                'location' => 'Casa',
                'reminder_days' => 7,
                'color' => '#8B5CF6',
            ],
            [
                'title' => 'Reunião Mensal da Empresa',
                'description' => 'Reunião mensal para alinhamento de projetos',
                'type' => 'custom',
                'recurrence_type' => 'monthly',
                'start_date' => Carbon::now()->startOfMonth()->addDays(5)->format('Y-m-d'),
                'time' => '14:00',
                'location' => 'Sala de reuniões',
                'reminder_days' => 1,
                'color' => '#3B82F6',
            ],
            [
                'title' => 'Consulta Médica',
                'description' => 'Consulta de rotina com o cardiologista',
                'type' => 'custom',
                'recurrence_type' => 'yearly',
                'start_date' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                'time' => '10:00',
                'location' => 'Clínica CardioVida',
                'reminder_days' => 3,
                'color' => '#06B6D4',
            ],
        ];

        foreach ($events as $eventData) {
            $event = Event::create(array_merge($eventData, ['user_id' => $user->id]));
            
            // Gerar ocorrências para o próximo ano
            $event->generateOccurrences();
        }
    }
} 