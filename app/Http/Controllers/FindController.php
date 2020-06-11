<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Events\NotifyDoctor;
use App\Events\ClientStream;
use App\Consultations;
use GeoIP;

class FindController extends Controller
{
    public function index(Request $request)
    {   $credit = Auth::user()->credits;
        $timer = 0;
        $check = Consultations::where('patientId',Auth::user()->id)->where('completed',null)->first();

        if($check)
        {
            $timer = 1;
        }
        if($credit == 0)
        {
            return redirect()->route('credits');
        }
    	return view('find_doc',['credit' => $credit,'timer'=>$timer]);
    }

    public function addCredits()
    {   
        $credit = Auth::user()->credits;
    	return view('select_payment',['credit' => $credit]);
    }

    public function alertDoctor(Request $request)
    {	
    	$id = Auth::user()->id;
    	// $text = request()->text;
        $location = geoip($ip = $request->ip());

        $check = Consultations::where('patientId',$id)->where('completed',null)->first();
        if($check)
        {

        }
        else{
            $new = new Consultations;
        $new->patientId = $id;
        $new->patient_location = $location->city;
        $new->save();
        }
        

		event(new NotifyDoctor($id,'alert'));

                $response = array(
                    'id' => $id,
                );

                return response()->json($response);        

    }

    public function endAlert(Request $request)
    {
        $id = Auth::user()->id;

        Consultations::where('patientId',$id)->where('completed',null)->delete();

        event(new NotifyDoctor($id,'end'));

        $response = array(
                    'success' => 'success',
                );

                return response()->json($response);
    }

}
