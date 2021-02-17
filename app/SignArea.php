<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SignArea extends Model
{

    protected $fillable = [
        'width',
        'height',
        'element_top',
        'element_left',
        'top',
        'left',
        'parent_width',
        'parent_height',
        'target_page',
        'signer_id',
    ];
    // public function getCreatedAtAttribute($date)
    // {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-M-y');
    // }

    // public function getUpdatedAtAttribute($date)
    // {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-M-y');
    // }
    public function signer()
    {
        return $this->belongsTo('App\Signer');
    }
}
