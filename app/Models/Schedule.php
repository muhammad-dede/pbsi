<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    protected $guarded = [];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id', 'id');
    }

    public function sessionType()
    {
        return $this->belongsTo(SessionType::class, 'session_type_code', 'code');
    }
}
