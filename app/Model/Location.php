<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //

    public function area(){
        return $this->hasOne('App\Model\Area');
    }
}
