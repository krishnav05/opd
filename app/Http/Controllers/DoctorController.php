<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Events\NotifyPatient;
use App\Consultations;


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


}
