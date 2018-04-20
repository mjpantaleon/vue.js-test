<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $table = 'bloodtest';
    public $incrementing = false;
    public $timestamps = false;

    function details(){
        return $this->hasMany('App\TestResultDetail','bloodtest_no','bloodtest_no');
    }

}
