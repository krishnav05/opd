<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\HistoryMessages;
use App\Consultations;

class HistoryController extends Controller
{
    //
	public function getHistory(Request $request)
	{	
		$messages = HistoryMessages::where('consultation_id',$request->id)->get();
		foreach ($messages as $key) {
			# code...
			$key['attachment'] = rtrim($key['attachment'],',download.jpeg');
		}

		$id = Auth::user()->id;
		$check = 1;
		return view('history',['messages'=>$messages,'id'=>$id,'check'=>$check]);
	}

	public function getConsultations()
	{	
		$id = Auth::user()->id;

		$doctors = User::where('role_id',3)->get();

		$consultations = Consultations::where('patientId',$id)->where('completed',1)->orderBy('created_at', 'desc')->get();
		$check = 1;

		$consults = Consultations::where('doctorId',$id)->orderBy('created_at','desc')->where('completed',1)->get();
		$patients = User::where('role_id',2)->get();
		return view('consultations',['consultations'=>$consultations,'doctors'=>$doctors,'check'=>$check,'patients'=>$patients,'consults'=>$consults]);
	}

}
