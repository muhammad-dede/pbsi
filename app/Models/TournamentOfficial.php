<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentOfficial extends Model
{
    protected $table = 'tournament_officials';

    protected $guarded = [];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id', 'id');
    }

    public function official()
    {
        return $this->belongsTo(OfficialRole::class, 'official_role_code', 'code');
    }
}
