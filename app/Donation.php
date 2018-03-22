<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'donation';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'seqno';

    function donor(){
        return $this->belongsTo('App\Donor','donor_sn','seqno');
    }

    function processing(){
        return $this->belongsTo('App\Processing','donation_id','donation_id');
    }

    function facility(){
        return $this->belongsTo('App\Facility','facility_cd','facility_cd');
    }
}
