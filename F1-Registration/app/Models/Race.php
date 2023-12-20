<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;


    protected $casts = [
        'result' => 'time:m-s-t'
    ];

    public function User() {
        return $this->hasOne(User::class);
    }

    public function Circuit() {
        return $this->hasOne(Circuit::class);
    }
    

}
