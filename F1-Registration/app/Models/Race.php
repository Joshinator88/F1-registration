<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;

// this is to define what we want to store in the resul column
    protected $casts = [
        'result' => 'time: i-s.u'
    ];

    public function User() {
        return $this->hasOne(User::class);
    }

    public function Circuit() {
        return $this->hasOne(Circuit::class);
    }
    

}
