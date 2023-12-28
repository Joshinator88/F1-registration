<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;


    public function user() {
        return $this->hasOne(User::class);
    }

   public function race_result() {
    return $this->hasMany(Race_result::class);
   }
    

}
