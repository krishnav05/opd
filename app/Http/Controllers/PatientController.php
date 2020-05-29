<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;

class PatientController extends Controller
{
    //
    public function connectVideo(Request $request)
    {
    	$api = '46765912';
    	$secret = 'd3de7b6811f3603e5c78208af0906c58a0658f53';
    	$opentok = new OpenTok($api, $secret);

    	$sessionOptions = array(
		    'archiveMode' => ArchiveMode::ALWAYS,
		    'mediaMode' => MediaMode::ROUTED
		);
		$session = $opentok->createSession($sessionOptions);

		$sessionId = $session->getSessionId();

		$token = $opentok->generateToken($sessionId);

		return view('patient_video_call',['session_id'=>$sessionId,'session_token'=>$session,'opentok_token'=>$token]);
    }
}
