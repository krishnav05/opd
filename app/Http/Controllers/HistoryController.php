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
		$id = Auth::user()->id;
		return view('history',['messages'=>$messages,'id'=>$id]);
	}

	public function getConsultations()
	{	
		$id = Auth::user()->id;

		$doctors = User::where('role_id',3)->get();

		$consultations = Consultations::where('patientId',$id)->orderBy('created_at', 'desc')->get();

		return view('consultations',['consultations'=>$consultations,'doctors'=>$doctors]);
	}

}
