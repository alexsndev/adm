<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'file',
        'type',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
