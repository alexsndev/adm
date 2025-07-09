<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'recurrence_type',
        'start_date',
        'end_date',
        'time',
        'location',
        'is_active',
        'reminder_days',
        'color',
        'image', // Permite salvar o caminho da imagem
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function occurrences(): HasMany
    {
        return $this->hasMany(EventOccurrence::class);
    }

    /**
     * Gera as ocorrências para um período específico
     */
    public function generateOccurrences($startDate = null, $endDate = null): void
    {
        if (!$this->is_active) {
            return;
        }

        $startDate = $startDate ? Carbon::parse($startDate) : Carbon::now();
        $endDate = $endDate ? Carbon::parse($endDate) : Carbon::now()->addYears(3);

        $currentDate = Carbon::parse($this->start_date);
        
        // Se o evento é único (não recorrente)
        if ($this->recurrence_type === 'once') {
            if ($currentDate->between($startDate, $endDate)) {
                $this->createOccurrence($currentDate);
            }
            return;
        }

        // Para eventos recorrentes
        while ($currentDate <= $endDate) {
            if ($currentDate >= $startDate) {
                $this->createOccurrence($currentDate);
            }

            // Avança para a próxima ocorrência
            switch ($this->recurrence_type) {
                case 'yearly':
                    $currentDate->addYear();
                    break;
                case 'monthly':
                    $currentDate->addMonth();
                    break;
                case 'weekly':
                    $currentDate->addWeek();
                    break;
                case 'daily':
                    $currentDate->addDay();
                    break;
            }
        }
    }

    /**
     * Cria uma ocorrência específica se não existir
     */
    private function createOccurrence(Carbon $date): void
    {
        $existingOccurrence = $this->occurrences()
            ->where('occurrence_date', $date->format('Y-m-d'))
            ->first();

        if (!$existingOccurrence) {
            $this->occurrences()->create([
                'occurrence_date' => $date->format('Y-m-d'),
                'occurrence_time' => $this->time,
                'status' => 'pending',
            ]);
        }
    }

    /**
     * Obtém as próximas ocorrências
     */
    public function getUpcomingOccurrences($limit = 10)
    {
        return $this->occurrences()
            ->where('occurrence_date', '>=', Carbon::now()->format('Y-m-d'))
            ->where('status', 'pending')
            ->orderBy('occurrence_date')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtém as ocorrências de um mês específico
     */
    public function getOccurrencesForMonth($year, $month)
    {
        return $this->occurrences()
            ->whereYear('occurrence_date', $year)
            ->whereMonth('occurrence_date', $month)
            ->orderBy('occurrence_date')
            ->get();
    }

    /**
     * Obtém as ocorrências de hoje
     */
    public function getTodayOccurrences()
    {
        return $this->occurrences()
            ->where('occurrence_date', Carbon::now()->format('Y-m-d'))
            ->where('status', 'pending')
            ->get();
    }

    /**
     * Obtém as ocorrências que precisam de lembrete
     */
    public function getReminderOccurrences()
    {
        $reminderDate = Carbon::now()->addDays($this->reminder_days)->format('Y-m-d');
        
        return $this->occurrences()
            ->where('occurrence_date', $reminderDate)
            ->where('status', 'pending')
            ->where('reminder_sent', false)
            ->get();
    }

    public function predictabilityPeople()
    {
        return $this->belongsToMany(PredictabilityPerson::class, 'event_predictability_person', 'event_id', 'predictability_person_id');
    }
} 