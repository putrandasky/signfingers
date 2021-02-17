<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SignStatus extends Model
{
    public $timestamps = false;
    public function signers()
    {
        return $this->hasMany('App\Signer');
    }
}
