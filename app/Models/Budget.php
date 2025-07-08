<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'amount',
        'spent',
        'month',
        'year',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'spent' => 'decimal:2',
        'month' => 'integer',
        'year' => 'integer',
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

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForMonth($query, $year, $month)
    {
        return $query->where('year', $year)->where('month', $month);
    }

    // Métodos úteis
    public function getRemainingAttribute()
    {
        return $this->amount - $this->spent;
    }

    public function getPercentageUsedAttribute()
    {
        if ($this->amount == 0) return 0;
        return ($this->spent / $this->amount) * 100;
    }

    public function getStatusAttribute()
    {
        $percentage = $this->percentage_used;
        
        if ($percentage >= 100) return 'exceeded';
        if ($percentage >= 80) return 'warning';
        return 'good';
    }

    public function updateSpentAmount()
    {
        $spent = $this->category->transactions()
            ->where('type', 'expense')
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->sum('amount');

        $this->spent = $spent;
        $this->save();
    }
}
