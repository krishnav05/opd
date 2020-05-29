<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use App\Consultations;

class PatientController extends Controller
{
    //
    public function connectVideo(Request $request)
    {
    	$api = '46765912';
    	$secret = 'd3de7b6811f3603e5c78208af0906c58a0658f53';
    	$opentok = new OpenTok($api, $secret);

    	$sessionId = Consultations::where('patientId',Auth::user()->id)->where('completed',null)->value('session_id');

		$token = $opentok->generateToken($sessionId);

		return view('patient_video_call',['session_id'=>$sessionId,'opentok_token'=>$token]);
    }
}
