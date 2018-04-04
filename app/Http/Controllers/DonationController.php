<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donation;

class DonationController extends Controller
{
    function newWalkIn(Request $request){
        $donation_id = $request->get('donation_id');
        $exists = Donation::whereDonationId($donation_id)->first();
        if($exists){
            return 'donation_id_error';
        }
        $facility_cd = $request->get('facility_cd');
        $donation = new Donation;
        $donation->seqno = $this->generateSeqno($facility_cd);
        $donation->donation_id = $donation_id;
        $donation->donor_sn = $request->get('donor')['seqno'];
        $donation->sched_id = 'Walk-in';
        $donation->pre_registered = 'N';
        $donation->donation_type = $request->get('donation_type');
        $donation->collection_method = $request->get('collection_method');
        $donation->facility_cd = $facility_cd;
        $donation->mh_pe_stat = $request->get('mh_pe_stat');
        $donation->mh_pe_deferral = $request->get('mh_pe_deferral');
        $donation->mh_pe_question = $request->get('mh_pe_question');
        $donation->mh_pe_remark = $request->get('mh_pe_remark');
        $donation->collection_type = $request->get('collection_type');
        $donation->collection_stat = $request->get('collection_stat');
        $donation->coluns_res = $request->get('coluns_res');
        $donation->created_by = $request->get('user_id');
        $donation->created_dt = date('Y-m-d H:i:s');
        $donation->save();
        return $donation;
    }

    function mbdNewDonor(Request $request){
        $sched_id = $request->get('sched_id');
        $seqno = $request->get('seqno');
        $facility_cd = $request->get('facility_cd');
        $user_id = $request->get('user_id');

        $donation = new Donation;
        $donation->seqno = $this->generateSeqno($facility_cd);
        $donation->donor_sn = $seqno;
        $donation->sched_id = $sched_id;
        $donation->pre_registered = 'N';
        $donation->donation_type = 'V';
        $donation->collection_method = 'WB';
        $donation->facility_cd = $facility_cd;
        $donation->created_by = $user_id;
        $donation->created_dt = date('Y-m-d H:i:s');
        $donation->save();

        return $donation;
    }

    function mbdAssignDonor(Request $request){
        $donation = Donation::whereDonationId($request->get('donation_id'))->firstOrFail();
        $donation->donor_sn = $request->get('seqno');
        $donation->updated_by = $request->get('user_id');
        $donation->updated_dt = date('Y-m-d H:i:s');
        $donation->save();

        return $donation;
    }

    function generateSeqno($facility_cd,$i = 1,$max = null){
        if(!$max){
            $max = Donation::select('seqno')->whereFacilityCd($facility_cd)->orderBy('seqno','desc')->first()->seqno;
            if(!$max){
                return $facility_cd.date('Y').str_pad('1',5,'0',STR_PAD_LEFT);
            }
        }

        $num = substr($max,9,strlen($max));
        $num = abs($num);
        $num = $num+$i;
        $new = $facility_cd.date('Y').str_pad($num,7,'0',STR_PAD_LEFT);
        $isExists = Donation::whereSeqno($new)->first();
        if($isExists){
            $i++;
            return $this->generateSeqno($facility_cd,$i,$max);
        }

        return $new;
    }

    function donationRemove(Request $request){
        $seqno = $request->get('seqno');
        $donation = Donation::whereSeqno($seqno)->first();
        $donation->delete();
        return $seqno;
    }

    function walkin(Request $request){
        $facility_cd = $request->get('facility_cd');
        $date = $request->get('search');
        return Donation::with('donor')
        ->whereFacilityCd($facility_cd)
        ->whereSchedId('Walk-in')
        ->where('created_dt','like',$date.'%')
        ->orderBy('created_dt','desc')->get();
    }
}
