<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileHistory extends Model
{
    //追加(課題17)
    protected $guarded = array('id');

    public static $rules = array(
        'profile_id' => 'required',
        'edited_at' => 'required',
    );
}