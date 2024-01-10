<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trophy extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'race_id',
        'trophy'
    ];

    public function race(){
        return $this->belongsTo(Race::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
