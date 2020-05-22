<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

//custom routes made by developer
Route::post('otp-send','OtpController@sendOtp');

Route::post('otp-verify','OtpController@verifyOtp');

Route::post('dopayment', 'Patient\RazorpayController@dopayment')->name('dopayment')->middleware('auth');

Route::get('find-doc','FindController@index');