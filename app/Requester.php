<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Requester extends Model
{
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d-M-y H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d-M-y H:i:s');
    }
    public function signers()
    {
        return $this->hasMany('App\Signer');
    }
}
