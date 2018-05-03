<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donation;

class DiscardController extends Controller
{
    function lists(Request $request){
        $sched = $request->get('sched');
        $sched_id = $sched['sched_id'];
        $donation_id = $request->get('donation_id');
        $component_cd = $request->get('component_cd');
        $facility_cd = $request->get('facility_cd');
        $donations = [];

        if($sched_id){
            if($sched_id == 'Walk-in'){
                $from = $sched['from'];
                $to = $sched['to'];
                $donations = Donation::with('type','test','mbd','units')->whereNotNull('donation_id')->whereFacilityCd($facility_cd)->whereSchedId($sched_id)->whereBetween('created_dt',[$from,$to]);
            }else{
                $donations = Donation::with('type','test','mbd','units')->whereNotNull('donation_id')->whereFacilityCd($facility_cd)->whereSchedId($sched_id);
            }

            if($donation_id){
                $donations->whereDonationId($donation_id);
            }
        }else{
            if($donation_id){
                $donations = Donation::with('type','test','mbd','units')->whereFacilityCd($facility_cd)->whereDonationId($donation_id)->get();
            }
        }

        
        $donations = $donations->get();
        
        $response = [];
        foreach($donations as $donation){
            if(!count($donation->units)){

            }else if(!$donation->blood_bag){
                
            }else if($donation->test){
                if($donation->test->result != "R"){
                    if(!$component_cd){
                        $response[] = $donation;
                    }else{
                        if($donation->units){
                            $hasUnit = $donation->units->first(function($unit) use ($component_cd){
                                return $unit->component_cd == $component_cd;
                            });
                            if($hasUnit){
                                $response[] = $donation;
                            }
                        }
                    }
                }
            }else{
                if(!$component_cd){
                    $response[] = $donation;
                }else{
                    if($donation->units){
                        $hasUnit = $donation->units->first(function($unit) use ($component_cd){
                            return $unit->component_cd == $component_cd;
                        });
                        if($hasUnit){
                            $response[] = $donation;
                        }
                    }
                }
            }
        }
        return $response;
    }

    function save(Request $request){
        $units = $request->get('units');
        $reason = $request->get('reason');
        $remarks = $request->get('remarks');
        $verifier = $request->get('verifier');
    }
}
