<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //

    public function location(){
        return $this->belongsTo('App\Model\Area');
    }

    public function user_areas(){
        return $this->hasMany('App\Model\UsersArea', 'users_areas');
    }
}
