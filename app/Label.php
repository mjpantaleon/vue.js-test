<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = 'blood_label';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'label_no';

    function unit(){
        return $this->hasOne('App\Blood','donation_id','donation_id')->whereComponentCd($component_cd);
    }

    function donation(){
        return $this->belongsTo('App\Donation','donation_id','donation_id');
    }
}
