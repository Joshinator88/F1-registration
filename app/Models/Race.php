<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function race_result()
    {
        return $this->hasMany(RaceResult::class);
    }

    public function isActive()
    {
        return Carbon::now()->isBetween($this->start, $this->end);
    }
}
