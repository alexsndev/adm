<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventOccurrence extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'occurrence_date',
        'occurrence_time',
        'status',
        'notes',
        'reminder_sent',
        'reminder_sent_at',
    ];

    protected $casts = [
        'occurrence_date' => 'date',
        'occurrence_time' => 'datetime:H:i',
        'reminder_sent' => 'boolean',
        'reminder_sent_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function getFormattedDateAttribute()
    {
        return $this->occurrence_date->format('d/m/Y');
    }

    public function getFormattedTimeAttribute()
    {
        return $this->occurrence_time ? $this->occurrence_time->format('H:i') : null;
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }
} 