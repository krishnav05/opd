<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\DoctorDetails;
use App\Transactions;
use App\Consultations;

class ManageAdminController extends Controller
{
    //
    public function fetch()
    {
    	return view('admin');
    }

    public function getDoctors()
    {
    	$doctors = User::where('role_id',3)->get();
    	$doctordetails = DoctorDetails::all();
    	return view('all_doctors',['doctors'=>$doctors,'doctordetails'=>$doctordetails]);
    }

    public function addDoctor(Request $request)
    {
    	$validatedData = $request->validate([
    		'photo' => 'required|image|max:2048',
    		'doctor_name' => 'required',
    		'summary' => 'required',
    		'speciality' => 'required',
    		'email' => 'required|email',
    		'hospital' => 'required',
    		'password' => 'required',
    	]);
    	$photoName = time().'.'.$request->photo->getClientOriginalExtension();
    	$request->photo->move(public_path('/storage/user-avatar/'), $photoName);

    	$new = new User;
    	$new->name = $validatedData['doctor_name'];
    	$new->email = $validatedData['email'];
    	$new->role_id = 3;
    	$new->password = bcrypt($validatedData['password']);
    	$new->avatar = $photoName;
    	$new->save();

    	$id = $new->id;

    	$details = new DoctorDetails;
    	$details->doctor_id = $id;
    	$details->speciality = $validatedData['speciality'];
    	$details->current_hospital = $validatedData['hospital'];
    	$details->summary = $validatedData['summary'];
    	$details->save();

    	return redirect()->back();

    }

    public function getPatients()
    {	
    	$patients = User::where('role_id',2)->simplePaginate(15);

    	return view('admin_patients',['patients'=>$patients]);
    }

    public function viewPatient(Request $request)
    {
    	$id = User::where('phone',$request->number)->value('id');

    	$credits = User::where('id',$id)->value('credits');

    	$transactions = Transactions::where('userid',$id)->get();

    	$consultations = Consultations::where('patientId',$id)->get();

    	$doctors = User::where('role_id',3)->get();

    	return view('view_patient',['transactions'=>$transactions,'consultations'=>$consultations,'doctors'=>$doctors,'id'=>$id,'credits'=>$credits]);
    }

    public function updateCredits(Request $request)
    {
    	if($request->credit < 0)
    	{
    		return redirect()->back();
    	}
    	else
    	{
    		User::where('id',$request->id)->update(['credits'=>$request->credit]);
    		return redirect()->back();
    	}
    }

    public function enableAccount(Request $request)
    {	
    	User::where('phone',$request->number)->update(['enable'=>1]);
    	return redirect()->back();
    }

    public function disableAccount(Request $request)
    {
    	User::where('phone',$request->number)->update(['enable'=>0]);
    	return redirect()->back();
    }
}
