<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'amount',
        'type',
        'date',
        'category_id',
        'account_id',
        'transfer_account_id',
        'notes',
        'reference',
        'is_recurring',
        'recurring_frequency',
        'recurring_end_date',
        'user_id',
        'debt_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
        'is_recurring' => 'boolean',
        'recurring_end_date' => 'date',
    ];

    // Relações
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function transferAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'transfer_account_id');
    }

    public function debt(): BelongsTo
    {
        return $this->belongsTo(Debt::class);
    }

    // Scopes
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeTransfer($query)
    {
        return $query->where('type', 'transfer');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('date', $year)->whereMonth('date', $month);
    }

    public function scopeRecurring($query)
    {
        return $query->where('is_recurring', true);
    }

    // Métodos úteis
    public function getFormattedAmountAttribute()
    {
        $prefix = $this->type === 'expense' ? '-' : '+';
        return $prefix . 'R$ ' . number_format($this->amount, 2, ',', '.');
    }

    public function getIsTransferAttribute()
    {
        return $this->type === 'transfer';
    }

    // Eventos do modelo
    protected static function booted()
    {
        static::created(function ($transaction) {
            // Atualizar saldo da conta quando uma transação é criada
            $transaction->account->updateBalance();
            
            if ($transaction->transfer_account_id) {
                $transaction->transferAccount->updateBalance();
            }
        });

        static::updated(function ($transaction) {
            // Atualizar saldo da conta quando uma transação é atualizada
            $transaction->account->updateBalance();
            
            if ($transaction->transfer_account_id) {
                $transaction->transferAccount->updateBalance();
            }
        });

        static::deleted(function ($transaction) {
            // Atualizar saldo da conta quando uma transação é deletada
            $transaction->account->updateBalance();
            
            if ($transaction->transfer_account_id) {
                $transaction->transferAccount->updateBalance();
            }
        });
    }
}
