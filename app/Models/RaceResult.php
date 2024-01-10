<?php

namespace App\Models;

use App\Http\Controllers\RaceController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class RaceResult extends Model
{
    use HasFactory;

    protected $table = 'race_results';
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
        'result' => 'time: i-s.u',
        'is_valid' => 'boolean',
    ];

    public function race()
    {
        return $this->belongsTo(Race::class, 'race_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

