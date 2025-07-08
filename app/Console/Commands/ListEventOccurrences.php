<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EventOccurrence;

class ListEventOccurrences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:list-occurrences {year} {month}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lista todas as ocorrências de eventos para um mês e ano informados.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $year = $this->argument('year');
        $month = $this->argument('month');
        $occurrences = EventOccurrence::whereYear('occurrence_date', $year)
            ->whereMonth('occurrence_date', $month)
            ->with('event')
            ->orderBy('occurrence_date')
            ->get();
        if ($occurrences->isEmpty()) {
            $this->info('Nenhuma ocorrência encontrada para ' . $month . '/' . $year);
            return;
        }
        foreach ($occurrences as $occ) {
            $this->line($occ->occurrence_date . ' | Evento: ' . ($occ->event->title ?? 'N/A'));
        }
        $this->info('Total: ' . $occurrences->count() . ' ocorrências.');
    }
} 