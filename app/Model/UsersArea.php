<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersArea extends Model
{
    //

    public function user(){
        return $this->belongsTo('App\Model\User');
    }

    public function area(){
        return $this->belongsTo('App\Model\Area');
    }
}
