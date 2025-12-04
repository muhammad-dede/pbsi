<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $guarded = [];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id', 'id');
    }

    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_code', 'code');
    }

    public function prizeDistributions()
    {
        return $this->hasMany(PrizeDistribution::class, 'event_id', 'id');
    }
}
