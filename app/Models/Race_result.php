<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race_result extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'race_id',
        'seconds',
        'points',
        'is_valid',
        'profile_picture'
    ];

    // this is to define what we want to store in the resul column
    protected $casts = [
        'result' => 'time: i-s.u'
    ];

    public function race() {
        return $this->hasOne(Race::class);
    }

    public function user() {
        return $this->hasOne(User::class);
    }

}
