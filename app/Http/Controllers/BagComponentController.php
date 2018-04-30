<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BagComponent;

class BagComponentController extends Controller
{
    function lists(){
        $bc = BagComponent::select('components','blood_bag')->get();
        $response = [];
        foreach($bc as $b){
            if(!array_key_exists($b->blood_bag,$response)){
                $response[$b->blood_bag] = [];
            }
            $cs = explode(",",$b->components);
            foreach($cs as $i => $c){
                $cs[$i] = abs($c);
            }
            $response[$b->blood_bag][] = $cs;
        }
        return $response;
    }
}
