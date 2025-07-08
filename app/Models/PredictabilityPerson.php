<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PredictabilityPerson extends Model
{
    protected $fillable = [
        'name',
        'photo',
        'category',
        'birthdate',
        'phone',
        'email',
        'details',
        'notes',
    ];

    // Anexos
    public function attachments(): HasMany
    {
        return $this->hasMany(PredictabilityPersonAttachment::class, 'pessoa_id');
    }

    // Links para outras pessoas
    public function links(): HasMany
    {
        return $this->hasMany(PredictabilityPersonLink::class, 'pessoa_id');
    }

    // Pessoas relacionadas (através dos links)
    public function relatedPeople(): BelongsToMany
    {
        return $this->belongsToMany(
            PredictabilityPerson::class,
            'predictability_people_links',
            'pessoa_id',
            'relacionada_id'
        );
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_predictability_person', 'predictability_person_id', 'event_id');
    }
}
