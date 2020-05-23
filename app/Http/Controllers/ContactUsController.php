<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactUs;

class ContactUsController extends Controller
{
    //
    public function index()
    {
    	return view('contact_us');
    }

    public function update(Request $request)
    {	
    	$validatedData = $request->validate([
    		'phone' => 'required|numeric|digits:10',
    		'email' => 'email:rfc,dns',
    	]);

    	$new = new ContactUs;
    	$new->name = $request->fullname;
    	$new->phone = $validatedData['phone'];
    	$new->email = $validatedData['email'];
    	$new->reason = $request->option;
    	$new->save();

    	return redirect()->back()->with('success', 'Thank You For Contacting Us. We will contact you soon.');
    }
}
