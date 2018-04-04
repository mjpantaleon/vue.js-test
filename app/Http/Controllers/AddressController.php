<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Region;
use App\Province;
use App\City;
use App\Barangay;

class AddressController extends Controller
{
    function regions(){
        return $this->replaceNye(Region::pluck('regname','regcode'));
    }

    function provinces(Request $request,$regcode){
        return $this->replaceNye(Province::whereRegcode($regcode)->pluck('provname','provcode'));
    }

    function cities(Request $request,$provcode){
        return $this->replaceNye(City::whereProvcode($provcode)->pluck('cityname','citycode'));
    }

    function barangays(Request $request,$citycode){
        return $this->replaceNye(Barangay::whereCitycode($citycode)->pluck('bgyname','bgycode'));
    }

    function replaceNye($collection){
        foreach($collection as $i => $item){
            $collection[$i] = str_replace("??","Ñ",$item);
            $collection[$i] = str_replace("Â","Ñ",$collection[$i]);
        }
        return $collection;
    }
}
