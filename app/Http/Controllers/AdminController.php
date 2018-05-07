<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facility;

class AdminController extends Controller
{
    function facilitylistsimple(){
        return Facility::whereDisableFlg('N')->select('facility_cd','facility_name')->get();
    }
}
