<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseholdTaskPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_task_id',
        'photo',
    ];

    public function task()
    {
        return $this->belongsTo(HouseholdTask::class, 'household_task_id');
    }
} 