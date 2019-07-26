<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{

    protected $guarded = ['id'];

    public function friend(){
        $this->hasOne('App\User', 'friend_id', 'id');
    }

    public function user(){
        $this->belongsTo('App\User');
    }
}
