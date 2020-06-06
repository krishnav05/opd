@extends('layouts.master')

@section('content')
	
<div class="container">
  
  <div class="row">
    <div class="col text-center">
      <img src="{{asset('assets/img/hero-mobile-otp.svg')}}" class="img-fluid mt-3 ">
    </div>
  </div>

  <div class="row">
    <div class="col otp-card">
    	@if (\Session::has('success'))
    <div class="alert alert-error">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
      <h1>Doctor Sign-In</h1>
      <form action="doc-login" method="POST">
      	@csrf
        <div class="form-group mt-4">
          <input type="text" name="username" class="form-control form-control-lg" placeholder="Username">
          <input type="password"  name="password"  class="form-control form-control-lg mt-3" placeholder="******">
          <p class="text-left mt-3"> <a href="" onclick="return false;">Forgot Password?</a> </p>
          <input type="submit" name="" value="Sign-In" class="btn btn-primary form-control form-control-lg mt-1">
        </div>  
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col text-center">
      <p>  <a href="" onclick="return false;">Register or Need Help?</a> </p>
    </div>
  </div>
  
</div>

@endsection

@section('footer')

<footer class="text-center p-2">
      <div class="container"> <a href="" onclick="return false;"> Terms </a> | <a href="" onclick="return false;"> Privacy </a> | &nbsp; 2020 &copy; Copyrights onlyOPD </div>
    </footer>
@endsection