<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'target_amount',
        'current_amount',
        'target_date',
        'status',
        'color',
        'icon',
        'user_id',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'target_date' => 'date',
    ];

    // Relações
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Métodos úteis
    public function getRemainingAmountAttribute()
    {
        return $this->target_amount - $this->current_amount;
    }

    public function getPercentageCompletedAttribute()
    {
        if ($this->target_amount == 0) return 0;
        return ($this->current_amount / $this->target_amount) * 100;
    }

    public function getDaysRemainingAttribute()
    {
        return now()->diffInDays($this->target_date, false);
    }

    public function getIsOverdueAttribute()
    {
        return $this->target_date < now() && $this->status === 'active';
    }

    public function getProgressStatusAttribute()
    {
        if ($this->percentage_completed >= 100) return 'completed';
        if ($this->is_overdue) return 'overdue';
        if ($this->days_remaining <= 30) return 'urgent';
        return 'on_track';
    }

    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->current_amount = $this->target_amount;
        $this->save();
    }

    public function addAmount($amount)
    {
        $this->current_amount += $amount;
        
        if ($this->current_amount >= $this->target_amount) {
            $this->markAsCompleted();
        } else {
            $this->save();
        }
    }
}
