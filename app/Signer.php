<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Signer extends Model
{
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d-M-y H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d-M-y H:i:s');
    }
    public function signAreas()
    {
        return $this->hasMany('App\SignArea');
    }
    public function requester()
    {
        return $this->belongsTo('App\Requester');
    }
    public function signStatus()
    {
        return $this->belongsTo('App\SignStatus');
    }
}
