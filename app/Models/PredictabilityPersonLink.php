<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PredictabilityPersonLink extends Model
{
    protected $table = 'predictability_people_links';
    protected $fillable = [
        'pessoa_id',
        'relacionada_id',
        'tipo_relacao',
    ];

    public function person()
    {
        return $this->belongsTo(PredictabilityPerson::class, 'pessoa_id');
    }

    public function related()
    {
        return $this->belongsTo(PredictabilityPerson::class, 'relacionada_id');
    }
}
