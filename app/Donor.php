<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    protected $table = 'donor';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'seqno';

    protected $columns = [
        'donor_photo','seqno','donor_id','name_suffix','lname','mname','fname','bdate','gender',
        'civil_stat','tel_no','mobile_no','email','nationality','occupation',
        'home_no_st_blk','home_brgy','home_citymun','home_prov','home_region','home_zip',
        'office_no_st_blk','office_brgy','office_citymun','office_prov','office_region','office_zip',
        'donation_stat','donor_stat','deferral_basis','facility_cd',
        'created_by','created_dt','updated_by','updated_dt'
    ];

    function scopeExclude($query,$value = array()){
        return $query->select( array_diff( $this->columns,(array) $value) );
    }

    static function replaceNye($val){
        $val = str_replace('??','',$val);
        $val = str_replace('Â','',$val);
        return $val;
    }
    
    function region(){
        return $this->belongsTo('App\Region','home_region','regcode')->select('regcode','regname');
    }

    function province(){
        return $this->belongsTo('App\Province','home_prov','provcode')->select('provcode','provname');
    }

    function city(){
        return $this->belongsTo('App\City','home_citymun','citycode')->select('citycode','cityname');
    }

    function barangay(){
        return $this->belongsTo('App\Barangay','home_brgy','bgycode')->select('bgycode','bgyname');
    }

    function officeregion(){
        return $this->belongsTo('App\Region','office_region','regcode')->select('regcode','regname');
    }

    function officeprovince(){
        return $this->belongsTo('App\Province','office_prov','provcode')->select('provcode','provname');
    }

    function officecity(){
        return $this->belongsTo('App\City','office_citymun','citycode')->select('citycode','cityname');
    }

    function officebarangay(){
        return $this->belongsTo('App\Barangay','office_brgy','bgycode')->select('bgycode','bgyname');
    }

    function donations(){
        return $this->hasMany('App\Donation','donor_sn','seqno');
    }

    function nation(){
        return $this->belongsTo('App\Nation','countrycode','nationality');
    }
}