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
    	
    	$opentok = new OpenTok(env('OPENTOK_API_KEY'), env('OPENTOK_API_SECRET'));

    	$sessionOptions = array(
		    'archiveMode' => ArchiveMode::ALWAYS,
		    'mediaMode' => MediaMode::ROUTED
		);
		$session = $opentok->createSession($sessionOptions);

		$sessionId = $session->getSessionId();

		$token = $opentok->generateToken($sessionId);

		return view('patient_video_call',['session_token'=>$session,'opentok_token'=>$token]);
    }
}
