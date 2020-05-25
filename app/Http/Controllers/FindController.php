<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Events\NotifyDoctor;
use App\Consultations;

class FindController extends Controller
{
    public function index()
    {   $credit = Auth::user()->value('credits');

    	return view('find_doc',['credit' => $credit]);
    }

    public function addCredits()
    {   
        $credit = Auth::user()->value('credits');
    	return view('select_payment',['credit' => $credit]);
    }

    public function alertDoctor()
    {	
    	$id = Auth::user()->id;
    	// $text = request()->text;
        $new = new Consultations;
        $new->patientId = $id;
        $new->save();

		event(new NotifyDoctor($id));

                $response = array(
                    'id' => $id,
                );

                return response()->json($response);        

    }
}
