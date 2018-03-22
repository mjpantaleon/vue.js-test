<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'rprov';

    function cities(){
        return $this->hasMany('App\City','provcode','provcode');
    }

    function _cities(){
        return $this->hasMany('App\City','provcode','provcode')
            ->select('provcode','citycode','cityname');
    }
}
