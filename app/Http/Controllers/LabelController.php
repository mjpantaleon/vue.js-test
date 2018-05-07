<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donation;
use App\Label;

class LabelController extends Controller
{
    function lists(Request $request){
        $sched = $request->get('sched');
        $sched_id = $sched['sched_id'];
        $facility_cd = $request->get('facility_cd');
        $component_cd = $request->get('component_cd');

        $donations = [];
        if($sched_id == 'Walk-in'){
            $from = $sched['from'];
            $to = $sched['to'];
            $donations = Donation::with('type','labels','processing','test','units')->whereNotNull('donation_id')->whereFacilityCd($facility_cd)->whereSchedId($sched_id)->whereBetween('created_dt',[$from,$to])->get();
        }else{
            $donations = Donation::with('type','labels','processing','test','units')->whereNotNull('donation_id')->whereFacilityCd($facility_cd)->whereSchedId($sched_id)->get()->take(3);
        }

        $response = [];
        foreach($donations as $donation){
            if(!$donation->donation_id){

            }else if(!$donation->test){
                $response[] = $donation;
            }else if($donation->test->result != 'R'){
                $response[] = $donation;
            }
        }
        return $response;
    }
}
