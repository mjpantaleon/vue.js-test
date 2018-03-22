<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $table = 'r_donor_agency';
    public $timestamps = false;
    protected $primaryKey = 'agency_cd';

    function region(){
        return $this->belongsTo('App\Region','adg_region','regcode');
    }

    function province(){
        return $this->belongsTo('App\Province','adg_prov','provcode');
    }

    function city(){
        return $this->belongsTo('App\City','adg_city','citycode');
    }

    function barangay(){
        return $this->belongsTo('App\Barangay','adg_bgy','bgycode');
    }
}
