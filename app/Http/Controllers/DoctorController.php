<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;


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
    			return view('find_doc');
    		}
    		else
    			return redirect()->back()->with('success','Wrong Credentials');
    	}
    	else
    		return redirect()->back()->with('success','Wrong Credentials');
    }
}
