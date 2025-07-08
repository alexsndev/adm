<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class GoalContribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'financial_goal_id',
        'user_id',
        'account_id',
        'amount',
        'contribution_date',
        'description',
        'type',
        'reference',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'contribution_date' => 'date',
    ];

    // Relações
    public function financialGoal(): BelongsTo
    {
        return $this->belongsTo(FinancialGoal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    // Scopes
    public function scopeForGoal($query, $goalId)
    {
        return $query->where('financial_goal_id', $goalId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('contribution_date', [$startDate, $endDate]);
    }

    // Métodos úteis
    public function getTypeLabelAttribute()
    {
        $types = [
            'manual' => 'Manual',
            'automatic' => 'Automático',
            'bonus' => 'Bônus',
        ];
        
        return $types[$this->type] ?? 'Manual';
    }

    public function getFormattedAmountAttribute()
    {
        return 'R$ ' . number_format($this->amount, 2, ',', '.');
    }

    public function getFormattedDateAttribute()
    {
        return $this->contribution_date->format('d/m/Y');
    }
} 