<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'initial_balance',
        'current_balance',
        'currency',
        'description',
        'is_active',
        'user_id',
        'logo',
    ];

    protected $casts = [
        'initial_balance' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relações
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function transferTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'transfer_account_id');
    }

    public function creditCards(): HasMany
    {
        return $this->hasMany(CreditCard::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Métodos úteis
    public function updateBalance()
    {
        $totalIncome = $this->transactions()
            ->where('type', 'income')
            ->sum('amount');

        $totalExpenses = $this->transactions()
            ->where('type', 'expense')
            ->sum('amount');

        $totalTransfersOut = $this->transactions()
            ->where('type', 'transfer')
            ->sum('amount');

        $totalTransfersIn = $this->transferTransactions()
            ->where('type', 'transfer')
            ->sum('amount');

        $this->current_balance = $this->initial_balance + $totalIncome - $totalExpenses - $totalTransfersOut + $totalTransfersIn;
        $this->save();
    }

    public function getBalanceAsOfDate($date)
    {
        $balance = $this->initial_balance;

        $income = $this->transactions()
            ->where('type', 'income')
            ->where('date', '<=', $date)
            ->sum('amount');

        $expenses = $this->transactions()
            ->where('type', 'expense')
            ->where('date', '<=', $date)
            ->sum('amount');

        $transfersOut = $this->transactions()
            ->where('type', 'transfer')
            ->where('date', '<=', $date)
            ->sum('amount');

        $transfersIn = $this->transferTransactions()
            ->where('type', 'transfer')
            ->where('date', '<=', $date)
            ->sum('amount');

        return $balance + $income - $expenses - $transfersOut + $transfersIn;
    }
}
