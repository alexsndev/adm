<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DebtPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'debt_id',
        'user_id',
        'account_id',
        'amount',
        'payment_date',
        'payment_type',
        'notes',
        'balance_before',
        'balance_after',
        'interest_paid',
        'principal_paid',
        'is_scheduled',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'interest_paid' => 'decimal:2',
        'principal_paid' => 'decimal:2',
        'is_scheduled' => 'boolean',
    ];

    // Relações
    public function debt(): BelongsTo
    {
        return $this->belongsTo(Debt::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('payment_type', $type);
    }

    public function scopeScheduled($query)
    {
        return $query->where('is_scheduled', true);
    }

    // Métodos úteis
    public function getPaymentTypeLabelAttribute()
    {
        $types = [
            'regular' => 'Pagamento Regular',
            'extra' => 'Pagamento Extra',
            'settlement' => 'Acordo',
            'refinance' => 'Refinanciamento',
        ];
        
        return $types[$this->payment_type] ?? 'Pagamento';
    }

    public function getPaymentTypeColorAttribute()
    {
        $colors = [
            'regular' => 'blue',
            'extra' => 'green',
            'settlement' => 'orange',
            'refinance' => 'purple',
        ];
        
        return $colors[$this->payment_type] ?? 'blue';
    }
}
