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

    	return view('find_doc',['credit' => $credit]);
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
        

		event(new NotifyDoctor($id));

                $response = array(
                    'id' => $id,
                );

                return response()->json($response);        

    }

}
