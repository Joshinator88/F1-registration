<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    use HasFactory;

    protected $table = "circuits";
    protected $casts = ['started_at' => 'datetime', 'stopped_at' => 'datetime',];
    protected $fillable = ['name', 'grand_prix', 'started_at', 'stopped_at'];
}
