<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
    	$validatedData = $request->validate([
    		'phone' => 'required|numeric|digits:10',
    	]);

    	$check = User::where('phone',$validatedData['phone'])->first();

    	if($check)
    	{
    		$otp = rand(1000,9999);
            User::where('phone',$validatedData['phone'])->update(['otp'=>$otp]);
            //send message with otp here

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "http://2factor.in/API/V1/30a20943-9375-11ea-9fa5-0200cd936042/SMS/".$validatedData['phone']."/".$otp,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_POSTFIELDS => "",
              CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              // echo $response;
                return view('enter_otp',['number'=>$validatedData['phone']]);
            }

            
    	}
    	else
    	{
    		$patient = new User;
    		$patient->phone = $validatedData['phone'];
    		$patient->password = bcrypt('Default');
    		$patient->save();

    		$otp = rand(1000,9999);
            User::where('phone',$request->phone)->update(['otp'=>$otp]);
            //send message with otp here

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "http://2factor.in/API/V1/30a20943-9375-11ea-9fa5-0200cd936042/SMS/".$validatedData['phone']."/".$otp,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_POSTFIELDS => "",
              CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              // echo $response;
                return view('enter_otp',['number'=>$validatedData['phone']]);
            }
    		return view('enter_otp',['number'=>$validatedData['phone']]);
    	}

    }

    public function verifyOtp(Request $request)
    {
    	$pin = $request->pin1.$request->pin2.$request->pin3.$request->pin4;
        $user = User::where('phone',$request->number)->where('otp',$pin)->first();

        if($user)
        {
        	Auth::login($user);
            $check_if_verified = User::where('phone',$request->phone)->where('phone_verified',1)->first();
            if($check_if_verified){
            	User::where('phone',$request->phone)->update(['otp'=>null,'phone_verified'=>1]);	
            }
            else{
            	User::where('phone',$request->phone)->update(['otp'=>null]);
            }

            return view('select_payment');
        }
        else
        {
        	return view('enter_otp',['number'=>$request->number]);
        }
    }
}
