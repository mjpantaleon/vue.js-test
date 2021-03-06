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

    static function generateNo($facility_cd,$i = 1,$max = null){
        if(!$max){
            $max = TestResult::select('bloodtest_no')
                    ->whereFacilityCd($facility_cd)
                    ->where('bloodtest_no','like',$facility_cd.'%')
                    ->orderBy('bloodtest_no','desc')->first()->bloodtest_no;
            if(!$max){
                return $facility_cd.date('Y').str_pad('1',7,'0',STR_PAD_LEFT);
            }
        }

        $num = substr($max,9,strlen($max));
        $num = abs($num);
        $num = $num+$i;
        $new = $facility_cd.date('Y').str_pad($num,7,'0',STR_PAD_LEFT);
        $isExists = TestResult::whereBloodtestNo($new)->first();
        if($isExists){
            $i++;
            return self::generateNo($facility_cd,$i,$max);
        }

        return $new;
    }

}
