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

Route::get('/','OtpController@index')->name('home');

Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]);

// Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('doctor','ManageAdminController@fetch')->middleware('admin.user');

    Route::post('doctor','ManageAdminController@addDoctor')->middleware('admin.user');

    Route::get('doctors','ManageAdminController@getDoctors')->middleware('admin.user');

    Route::get('patients','ManageAdminController@getPatients')->middleware('admin.user');

    Route::get('patients/{number}','ManageAdminController@viewPatient')->middleware('admin.user');

    Route::post('addCredits','ManageAdminController@updateCredits')->middleware('admin.user');

    Route::get('enable/{number}','ManageAdminController@enableAccount')->middleware('admin.user');

    Route::get('disable/{number}','ManageAdminController@disableAccount')->middleware('admin.user');
});

//custom routes made by developer
Route::post('otp-send','OtpController@sendOtp');

Route::post('resend-otp','OtpController@resendOtp');

Route::post('otp-verify','OtpController@verifyOtp');

Route::post('dopayment', 'Patient\RazorpayController@dopayment')->name('dopayment')->middleware('auth.custom','patient');

Route::post('addcredits','OtpController@add')->middleware('auth.custom','patient');

Route::post('find-doc','FindController@alertDoctor')->middleware('auth.custom','patient');

Route::post('alert-end','FindController@endAlert')->middleware('auth.custom','patient');

Route::get('find-doc','FindController@index')->middleware('auth.custom','patient')->name('find.doctor');

Route::get('contact-us','ContactUsController@index');

Route::post('contact-details','ContactUsController@update');

Route::get('credits','FindController@addCredits')->middleware('auth.custom','patient')->name('credits');

//doctor login

Route::get('doctorlogin','DoctorController@loginPage')->name('doctorlogin');

Route::post('doc-login','DoctorController@login');

Route::get('call-pickup','DoctorController@callPickup')->name('pickup')->middleware('auth.custom','doctor');

Route::post('call-pickup','DoctorController@alertPatient')->middleware('auth.custom');

Route::post('doc-details','DoctorController@getDetails')->middleware('auth.custom');

Route::get('profile','DoctorController@profile')->middleware('auth.custom','doctor');

Route::post('profile','DoctorController@updateProfile')->middleware('auth.custom','doctor');

Route::get('doctor-logout','DoctorController@logout');

//video test routes
Route::get('patient-video-call','PatientController@connectVideo')->middleware('auth.custom','patient');

Route::get('doctor-video-call','DoctorController@connectVideo')->middleware('auth.custom','doctor');

Route::post('video-call-alert','DoctorController@videoCallAlert')->middleware('auth.custom','doctor');

Route::post('end','DoctorController@end')->middleware('auth.custom','doctor');

Route::post('endvideo','DoctorController@endvideo')->middleware('auth.custom','doctor');
// history

Route::get('history/{id}','HistoryController@getHistory')->middleware('auth.custom');

Route::get('history','HistoryController@getConsultations')->middleware('auth.custom');

Route::post('autocheck','DoctorController@autocheck')->middleware('auth.custom','doctor');
//error routes

Route::get('404',['as'=>'404','uses'=>'ErrorHandlerController@errorCode404']);

Route::get('405',['as'=>'405','uses'=>'ErrorHandlerController@errorCode405']);

//landing pages

Route::get('chat-with-a-doctor-online',function(){
  return view('chat-with-a-doc');
});

Route::get('consult-with-a-doctor-now',function(){
  return view('consult-with-a-doctor-now');
});

Route::get('take-online-doctor-consultation',function(){
  return view('take-online-doctor-consultation');
});

Route::get('your-family-is-too-precious-to-take-risk',function(){
  return view('your-family-is-too-precious-to-take-risk');
});