<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{

    use HasFactory, SoftDeletes;

    protected  $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service(){
      return $this->belongsTo(Service::class);
    }
}
