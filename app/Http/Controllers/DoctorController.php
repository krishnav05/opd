<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Events\NotifyPatient;
use App\Consultations;
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;


class DoctorController extends Controller
{
    //
    public function loginPage()
    {
    	return view('doctor.login');
    }

    public function login(Request $request)
    {
    	$user = User::where('email',$request->username)->first();

    	if($user)
    	{
    		if(Hash::check($request->password, $user->password))
    		{
    			Auth::login($user);
    			return redirect()->route('pickup');
    		}
    		else
    			return redirect()->back()->with('success','Wrong Credentials');
    	}
    	else
    		return redirect()->back()->with('success','Wrong Credentials');
    }

    public function callPickup()
    {
        return view('doctor.call_pickup');
    }

    public function alertPatient(Request $request)
    {
        $id = Auth::user()->id;
        // $text = request()->text;
        $check = Consultations::where('patientId',$request->patientid)->where('doctorId',null)->where('completed',null)->first();
        if($check)
        {
            Consultations::where('patientId',$request->patientid)->update(['doctorId'=>$id]);
            event(new NotifyPatient($id,$request->patientid));

                $response = array(
                    'status' => 'success',
                );

                return response()->json($response);
        }
        else
        {
            $response = array(
                    'status' => 'fail',
                );

                return response()->json($response);
        }
        


          
    }

    public function getDetails(Request $request)
    {
        $name = User::where('id',$request->doctorid)->value('name');
        $avatar = User::where('id',$request->doctorid)->value('avatar');

        $response = array(
                    'image' => $avatar,
                    'name' => $name,
                );

        return response()->json($response);

    }

    public function connectVideo(Request $request)
    {
        $api = '46765912';
        $secret = 'd3de7b6811f3603e5c78208af0906c58a0658f53';
        $opentok = new OpenTok($api, $secret);

        $consultation = Consultations::where('doctorId',Auth::user()->id)->where('completed',null)->where('session_id',null)->first();

        if($consultation)
        {
            $sessionOptions = array(
            'archiveMode' => ArchiveMode::ALWAYS,
            'mediaMode' => MediaMode::ROUTED
            );
            $session = $opentok->createSession($sessionOptions);

            $sessionId = $session->getSessionId();

            Consultations::where('doctorId',Auth::user()->id)->where('session_id',null)->where('completed',null)->update(['session_id'=>$session_id]);
        }
        else
        {
            $sessionId = Consultations::where('doctorId',Auth::user()->id)->where('completed',null)->value('session_id');
        }

        $token = $opentok->generateToken($sessionId);

        return view('doctor_video_call',['session_id'=>$sessionId,'opentok_token'=>$token]);
    }
}
