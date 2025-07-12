<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'client_id',
        'name',
        'description',
        'status',
        'priority',
        'start_date',
        'due_date',
        'completed_date',
        'budget',
        'hourly_rate',
        'estimated_hours',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'completed_date' => 'date',
        'budget' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
        'estimated_hours' => 'integer',
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function links()
    {
        return $this->hasMany(ProjectLink::class);
    }

    public function clientChats()
    {
        return $this->hasMany(\App\Models\ClientChat::class, 'project_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['planning', 'in_progress']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Métodos
    public function getTotalHoursAttribute()
    {
        return $this->timeEntries()->sum('duration_minutes') / 60;
    }

    public function getTotalBilledAttribute()
    {
        return $this->timeEntries()->where('is_billable', true)->sum('amount');
    }

    public function getProgressPercentageAttribute()
    {
        $totalTasks = $this->tasks()->count();
        if ($totalTasks === 0) return 0;
        
        $completedTasks = $this->tasks()->where('status', 'completed')->count();
        return round(($completedTasks / $totalTasks) * 100);
    }

    public function getIsOverdueAttribute()
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'completed';
    }

    public function getDaysRemainingAttribute()
    {
        if (!$this->due_date) return null;
        return Carbon::now()->diffInDays($this->due_date, false);
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(80)
            ->height(80)
            ->sharpen(10)
            ->nonQueued();
    }
}
