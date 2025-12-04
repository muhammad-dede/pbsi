<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrizeDistribution extends Model
{
    protected $table = 'prize_distributions';

    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
