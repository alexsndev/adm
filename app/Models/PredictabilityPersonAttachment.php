<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PredictabilityPersonAttachment extends Model
{
    protected $table = 'predictability_people_attachments';
    protected $fillable = [
        'pessoa_id',
        'arquivo',
        'descricao',
    ];

    public function person()
    {
        return $this->belongsTo(PredictabilityPerson::class, 'pessoa_id');
    }
}
