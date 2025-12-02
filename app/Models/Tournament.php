<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $table = 'tournaments';
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => Status::class,
        ];
    }
}
