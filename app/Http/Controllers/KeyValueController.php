<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Component;
use App\BloodType;
use App\CodeValue;
use App\Nation;

class KeyValueController extends Controller
{
    function keyvalues(){
        return [
            'components' => $this->components(),
            'bloodtypes' => $this->bloodtypes(),
            'civilstatus' => $this->civilstatus()
        ];
    }

    function components(){
        return Component::whereDisableFlg('N')->pluck('comp_name','component_cd');
    }

    function bloodtypes(){
        return BloodType::pluck('blood_type');
    }

    function civilstatus(){
        // return CodeValue::whereCode('CIVIL_STAT')->whereDisableFlg('N')->pluck('code_val','codedtl_cd');
        return [
            'S' => 'Single', 'M' => 'Married', 'W' => 'Widowed', 'SP' => 'Separated'
        ];
    }

    function nations(){
        return Nation::select(\DB::raw("CONCAT_WS(', ',country,nationality) as 'nation'"),'countrycode')
        ->get();
    }
}
