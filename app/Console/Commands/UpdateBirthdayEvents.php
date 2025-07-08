<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Carbon\Carbon;

class UpdateBirthdayEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:update-birthdays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza os eventos de aniversário para o próximo aniversário da pessoa vinculada.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = 0;
        $events = Event::where('type', 'birthday')->get();
        foreach ($events as $event) {
            $person = $event->predictabilityPeople()->first();
            if ($person && $person->birthdate) {
                $birthdate = Carbon::parse($person->birthdate);
                $now = Carbon::now();
                $nextBirthday = $birthdate->copy()->year($now->year);
                if ($nextBirthday->isPast()) {
                    $nextBirthday->addYear();
                }
                $event->start_date = $nextBirthday->format('Y-m-d');
                $event->save();
                // Regenerar ocorrências
                $event->occurrences()->delete();
                $event->generateOccurrences();
                $count++;
            }
        }
        $this->info("$count eventos de aniversário atualizados!");
    }
} 