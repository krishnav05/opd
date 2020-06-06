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
      <h1>Enter Your Phone Number</h1>
      <form action="otp-send" method="POST">
      	@csrf
        <div class="form-group mt-4">
          <input type="text" pattern="[0-9]*" inputmode="numeric" name="phone" size="10" minlength="10" maxlength="10"  class="form-control form-control-lg">
          <input type="submit" name="" value="generate otp" class="btn btn-primary form-control form-control-lg mt-3">
        </div>  
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col text-center">
      <p> Are you a doctor? <br> <a href="contact-us" class="mt-2">Contact Us</a> </p>
    </div>
  </div>
  
</div>


@endsection

@section('footer')
<footer class="text-center p-2">
      <div class="container"> <a href="" onclick="return false;"> Terms </a> | <a href="" onclick="return false;"> Privacy </a> | &nbsp; 2020 &copy; Copyrights onlyOPD </div>
    </footer>
@endsection