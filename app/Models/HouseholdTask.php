<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HouseholdTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_category_id',
        'title',
        'description',
        'status',
        'priority',
        'assigned_to',
        'frequency',
        'due_date',
        'due_time',
        'completed_date',
        'estimated_minutes',
        'actual_minutes',
        'started_at',
        'paused_at',
        'reopen_count',
        'notes',
        'is_recurring',
        'order',
    ];

    protected $casts = [
        'due_date' => 'date',
        'due_time' => 'datetime',
        'completed_date' => 'date',
        'estimated_minutes' => 'integer',
        'actual_minutes' => 'integer',
        'started_at' => 'datetime',
        'paused_at' => 'datetime',
        'reopen_count' => 'integer',
        'is_recurring' => 'boolean',
        'order' => 'integer',
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taskCategory()
    {
        return $this->belongsTo(TaskCategory::class, 'task_category_id');
    }

    public function photos()
    {
        return $this->hasMany(HouseholdTaskPhoto::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'in_progress']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', Carbon::today())
                    ->whereIn('status', ['pending', 'in_progress']);
    }

    public function scopeToday($query)
    {
        return $query->where('due_date', Carbon::today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('due_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    }

    public function scopeAssignedTo($query, $person)
    {
        return $query->whereIn('assigned_to', [$person, 'both']);
    }

    // Métodos
    public function getIsOverdueAttribute()
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'completed';
    }

    public function getDaysRemainingAttribute()
    {
        if (!$this->due_date) return null;
        return Carbon::now()->diffInDays($this->due_date, false);
    }

    public function getEstimatedHoursAttribute()
    {
        return $this->estimated_minutes ? round($this->estimated_minutes / 60, 1) : 0;
    }

    public function getActualHoursAttribute()
    {
        return $this->actual_minutes ? round($this->actual_minutes / 60, 1) : 0;
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'gray',
            'in_progress' => 'blue',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'low' => 'gray',
            'medium' => 'blue',
            'high' => 'orange',
            'urgent' => 'red',
            default => 'blue',
        };
    }

    public function getAssignedToTextAttribute()
    {
        return match($this->assigned_to) {
            'alexandre' => 'Alexandre',
            'liza' => 'Liza',
            'both' => 'Ambos',
            default => 'Não definido',
        };
    }

    public function getFrequencyTextAttribute()
    {
        return match($this->frequency) {
            'once' => 'Uma vez',
            'daily' => 'Diário',
            'weekly' => 'Semanal',
            'monthly' => 'Mensal',
            default => 'Não definido',
        };
    }
}
