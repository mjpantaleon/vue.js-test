<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MBD extends Model
{
    protected $table = 'donation_schedules';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'sched_id';

    function donations(){
        return $this->hasMany('App\Donation','sched_id','sched_id');
    }
}
