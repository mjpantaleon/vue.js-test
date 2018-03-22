<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donor;

class DonorController extends Controller
{
    function search(Request $request){
        
        $fname = $request->get('fname');
        $mname = $request->get('mname');
        $lname = $request->get('lname');

        $search = Donor::with('region','province','city','barangay')
            ->exclude(['donor_photo'])
            ->where(function($s) use ($fname,$mname,$lname){

                if($fname){
                    $s->where('fname','like','%'.$fname.'%');
                }
    
                if($mname){
                    $s->where('mname','like','%'.$mname.'%');
                }
    
                if($lname){
                    $s->where('lname','like','%'.$lname.'%');
                }
            })->take(20)->get();

            
        return $search;
    }

    function info(Request $request,$seqno){
        return Donor::with('donations','donations.facility')->whereSeqno($seqno)->firstOrFail();
    }
}
