<?php

use Illuminate\Support\Facades\Route;
use App\Events\NotifyDoctor;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('otp_login_page');
});

Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]);

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

//custom routes made by developer
Route::post('otp-send','OtpController@sendOtp');

Route::post('otp-verify','OtpController@verifyOtp');

Route::post('dopayment', 'Patient\RazorpayController@dopayment')->name('dopayment')->middleware('auth.custom');

Route::post('addcredits','OtpController@add')->middleware('auth.custom');

Route::post('find-doc','FindController@alertDoctor')->middleware('auth.custom');

Route::get('find-doc','FindController@index')->middleware('auth.custom')->name('find.doctor');

Route::get('contact-us','ContactUsController@index');

Route::post('contact-details','ContactUsController@update');

Route::get('credits','FindController@addCredits')->middleware('auth.custom')->name('credits');

//doctor login

Route::get('doctorlogin','DoctorController@loginPage');

Route::post('doc-login','DoctorController@login');

Route::get('call-pickup','DoctorController@callPickup')->name('pickup');

Route::post('call-pickup','DoctorController@alertPatient');

Route::post('doc-details','DoctorController@getDetails');


//video test routes
Route::get('patient-video-call','PatientController@connectVideo');

Route::get('video-call',function(){
	return view('video_call');
});

Route::get('doctor-video-call','DoctorController@connectVideo');