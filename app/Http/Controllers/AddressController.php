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
        return Region::pluck('regname','regcode');
    }

    function provinces(Request $request,$regcode){
        return Province::whereRegcode($regcode)->pluck('provname','provcode');
    }

    function cities(Request $request,$provcode){
        return City::whereProvcode($provcode)->pluck('cityname','citycode');
    }

    function barangays(Request $request,$citycode){
        return Barangay::whereCitycode($citycode)->pluck('bgyname','bgycode');
    }
}
