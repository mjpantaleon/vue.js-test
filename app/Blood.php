<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blood extends Model
{
    protected $table = 'component';
    public $timestamps = false;
    public $incrementing = false;
    public $primaryKey = 'donation_id';

    function test(){
        return $this->belongsTo('App\TestResult','donation_id','donation_id');
    }
    
    function discard(){
        return $this->belongsTo('App\Discard','donation_id','donation_id')->whereComponentCd($this->component_cd);
    }
}
