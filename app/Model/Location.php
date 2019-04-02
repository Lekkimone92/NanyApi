<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //,

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'longitude','latitude',
    ];


    public function area(){
        return $this->hasOne('App\Model\Area');
    }
}
