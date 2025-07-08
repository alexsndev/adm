<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Carbon\Carbon;

class GenerateEventOccurrences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:generate-occurrences {--year= : Ano até onde gerar (padrão: +1 ano)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera ocorrências futuras para todos os eventos ativos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $year = $this->option('year') ?? Carbon::now()->addYear()->year;
        $endDate = Carbon::create($year, 12, 31);

        $this->info('Gerando ocorrências até ' . $endDate->format('d/m/Y'));

        $events = Event::where('is_active', true)->get();
        $count = 0;

        foreach ($events as $event) {
            $event->generateOccurrences(null, $endDate);
            $count++;
        }

        $this->info("Ocorrências geradas para {$count} eventos.");
    }
}
