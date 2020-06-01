<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Transactions;

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
        if($check['enable'] == 0)
      {
        return redirect()->back();
      }
    		$otp = rand(1000,9999);
            User::where('phone',$validatedData['phone'])->update(['otp'=>$otp]);
            //send message with otp here

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://2factor.in/API/V1/30a20943-9375-11ea-9fa5-0200cd936042/SMS/".$validatedData['phone']."/".$otp,
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
              CURLOPT_URL => "https://2factor.in/API/V1/30a20943-9375-11ea-9fa5-0200cd936042/SMS/".$validatedData['phone']."/".$otp,
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

    public function resendOtp(Request $request)
    {
      $otp = rand(1000,9999);
            User::where('phone',$request->phone)->update(['otp'=>$otp]);
            //send message with otp here

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://2factor.in/API/V1/30a20943-9375-11ea-9fa5-0200cd936042/SMS/".$request->phone."/".$otp,
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
                $response = array(
                    'status' => 'success',
                );

                return response()->json($response);
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
            	User::where('phone',$request->number)->update(['otp'=>null,'phone_verified'=>1]);	
            }
            else{
            	User::where('phone',$request->number)->update(['otp'=>null]);
            }
            $credit = User::where('phone',$request->number)->value('credits');
            if(User::where('phone',$request->number)->value('credits') == 0)
            { 
              
              return redirect()->route('credits')->with(['credit' => $credit]);
            }
            else
            {
              return redirect()->route('find.doctor')->with(['credit' => $credit]);
            }
            
        }
        else
        {
        	return view('enter_otp',['number'=>$request->number]);
        }
    }

    public function add(Request $request)
    { 

      $new = new Transactions;
      $new->userid = Auth::user()->id;
      $new->amount = $request->amount;
      $new->save();
      
      if($request->amount == 450)
      {
        Auth::user()->increment('credits',5);
      }
      else if($request->amount == 175)
      {
        Auth::user()->increment('credits',2);
      }
      else if($request->amount == 99)
      {
        Auth::user()->increment('credits',1);
      }
    }


    public function index()
    { 
      if(Auth::user())
      {
        if(Auth::user()->role_id == 2)
        {
          return redirect()->route('find.doctor');
        }
        else
        {
          return redirect()->route('pickup');
        }
      }
      else
        return view('otp_login_page');
    }
}
