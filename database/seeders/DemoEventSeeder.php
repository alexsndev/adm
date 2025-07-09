<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class DemoEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (!$user) return;

        $events = [
            [
                'title' => 'Reunião de Projeto',
                'description' => 'Reunião semanal para alinhamento do projeto XPTO',
                'type' => 'custom',
                'recurrence_type' => 'weekly',
                'start_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'time' => '09:00',
                'location' => 'Sala 101',
                'reminder_days' => 1,
                'color' => '#3B82F6',
            ],
            [
                'title' => 'Consulta Odontológica',
                'description' => 'Consulta de rotina no dentista',
                'type' => 'custom',
                'recurrence_type' => 'once',
                'start_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'time' => '15:30',
                'location' => 'Clínica Sorriso',
                'reminder_days' => 2,
                'color' => '#06B6D4',
            ],
            [
                'title' => 'Feriado Municipal',
                'description' => 'Feriado da cidade',
                'type' => 'holiday',
                'recurrence_type' => 'yearly',
                'start_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'time' => '00:00',
                'location' => 'Cidade',
                'reminder_days' => 3,
                'color' => '#F59E0B',
            ],
            [
                'title' => 'Treinamento Online',
                'description' => 'Treinamento sobre novas ferramentas',
                'type' => 'custom',
                'recurrence_type' => 'once',
                'start_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'time' => '18:00',
                'location' => 'Google Meet',
                'reminder_days' => 1,
                'color' => '#8B5CF6',
            ],
        ];

        foreach ($events as $eventData) {
            $event = Event::create(array_merge($eventData, ['user_id' => $user->id]));
            $event->generateOccurrences();
        }
    }
}
