<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "rcitymun";

    function barangays(){
        return $this->hasMany('App\Barangay','citycode','citycode');
    }

    function _barangays(){
        return $this->hasMany('App\Barangay','citycode','citycode')
                ->select('citycode','bgycode','bgyname');
    }
}
