<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyForecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'amount',
        'date',
        'notes',
        'status', // pendente ou recebido
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 