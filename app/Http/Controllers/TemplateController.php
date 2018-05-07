<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;

class TemplateController extends Controller
{
    function lists(){
        return Template::with('facility')->get();
    }

    function save(Request $request){
        $facility = $request->get('facility');
        $template = $request->get('template');

        $existing = Template::whereFacilityCd($facility['facility_cd'])->first();

        if($existing){
            $existing->facility_cd = $facility['facility_cd'];
            $existing->template = $template;
            $existing->save();
            
        }else{
            $t = new Template();
            $t->facility_cd = $facility['facility_cd'];
            $t->template = $template;
            $t->save();
        }

    }
}
