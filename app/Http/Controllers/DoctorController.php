<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Events\NotifyPatient;
use App\Events\AlertCall;
use App\Consultations;
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use DB;


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

            $location = geoip($ip = $request->ip());
            Consultations::where('patientId',$request->patientid)->where('completed',null)->update(['doctorId'=>$id,'doctor_location'=>$location->city]);
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
        Consultations::where('doctorId',$request->doctorid)->where('completed',null)->update(['wait_time'=>$request->wait_time]);

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

            Consultations::where('doctorId',Auth::user()->id)->where('session_id',null)->where('completed',null)->update(['session_id'=>$sessionId]);
        }
        else
        {
            $sessionId = Consultations::where('doctorId',Auth::user()->id)->where('completed',null)->value('session_id');
        }

        $token = $opentok->generateToken($sessionId);

        return view('doctor_video_call',['session_id'=>$sessionId,'opentok_token'=>$token]);
    }

    public function end(Request $request)
    {   
        $id = Consultations::where('doctorId',Auth::user()->id)->where('completed',null)->value('id');

        $patientid = Consultations::where('doctorId',Auth::user()->id)->where('completed',null)->value('patientId');

        $variable = DB::table('messages')->where('from_id',Auth::user()->id)->orWhere('to_id',Auth::user()->id)->get();
        foreach ($variable as $value) {
            # code...
            $value->consultation_id = $id;
            DB::table('history_messages')->insert(get_object_vars($value));
        }

        DB::table('messages')->where('from_id',Auth::user()->id)->orWhere('to_id',Auth::user()->id)->delete();
        Consultations::where('doctorId',Auth::user()->id)->where('completed',null)->update(['completed'=>'1']);

        User::where('id',$patientid)->decrement('credits');
        $response = array(
                    'success' => 'success',
                );
        $alert = 'end';
        $endid = Auth::user()->id;
        event(new AlertCall($alert,$endid));

        return response()->json($response);           
    }

    public function videoCallAlert(Request $request)
    {   
        $alert = 'alert';
        $id = Auth::user()->id;
        event(new AlertCall($alert,$id));
        $response = array(
                    'success' => 'success',
                );

        return response()->json($response);  
    }
}
