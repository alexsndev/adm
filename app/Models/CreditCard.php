<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'name',
        'brand',
        'last_four_digits',
        'credit_limit',
        'current_balance',
        'due_day',
        'logo',
        'color',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'due_day' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relações
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class);
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
    public function getAvailableCreditAttribute()
    {
        if (!$this->credit_limit) return 0;
        return $this->credit_limit - $this->current_balance;
    }

    public function getUsagePercentageAttribute()
    {
        if (!$this->credit_limit || $this->credit_limit <= 0) return 0;
        return min(100, ($this->current_balance / $this->credit_limit) * 100);
    }

    public function getBrandLabelAttribute()
    {
        $brands = [
            'visa' => 'Visa',
            'mastercard' => 'Mastercard',
            'elo' => 'Elo',
            'amex' => 'American Express',
            'hipercard' => 'Hipercard',
            'discover' => 'Discover',
            'jcb' => 'JCB',
            'other' => 'Outro',
        ];
        
        return $brands[$this->brand] ?? $this->brand;
    }

    public function getDisplayNameAttribute()
    {
        $name = $this->name;
        if ($this->last_four_digits) {
            $name .= ' ****' . $this->last_four_digits;
        }
        return $name;
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        
        // Logo padrão baseado na bandeira
        $defaultLogos = [
            'visa' => 'images/cards/visa.png',
            'mastercard' => 'images/cards/mastercard.png',
            'elo' => 'images/cards/elo.png',
            'amex' => 'images/cards/amex.png',
            'hipercard' => 'images/cards/hipercard.png',
            'discover' => 'images/cards/discover.png',
            'jcb' => 'images/cards/jcb.png',
        ];
        
        return asset($defaultLogos[$this->brand] ?? 'images/cards/default.png');
    }

    public function getColorClassAttribute()
    {
        if ($this->color) {
            return $this->color;
        }
        
        // Cores padrão baseadas na bandeira
        $defaultColors = [
            'visa' => 'bg-blue-600',
            'mastercard' => 'bg-red-600',
            'elo' => 'bg-green-600',
            'amex' => 'bg-blue-800',
            'hipercard' => 'bg-purple-600',
            'discover' => 'bg-orange-600',
            'jcb' => 'bg-red-800',
        ];
        
        return $defaultColors[$this->brand] ?? 'bg-gray-600';
    }
}
