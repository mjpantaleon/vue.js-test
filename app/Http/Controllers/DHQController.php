<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DHQ;

class DHQController extends Controller
{
    function questions(){
        $headers = DHQ::select('question_no','header_no','question_txt')->whereHeaderNo(0)->pluck('question_txt','question_no');

        foreach($headers as $no => $txt){
            $questions = DHQ::select('question_no','header_no','question_txt')->whereHeaderNo($no)->pluck('question_txt','question_no');
            $headers[$no] = [
                'no' => $no,
                'txt' => $txt,
                'questions' => $questions
            ];
        }

        return $headers;
    }
}
