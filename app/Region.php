<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'rregion';
    
    function provinces(){
        return $this->hasMany('App\Province','regcode','regcode');
    }

    function _provinces(){
        return $this->hashMany('App\Province','regcode','regcode')
                ->select('regcode','provcode','provname');
    }
}
