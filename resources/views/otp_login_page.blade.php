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
          <input id="generate-otp-button" type="submit" name="" value="generate otp" class="btn btn-primary form-control form-control-lg mt-3" onclick="this.prop('disabled',true);">
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

<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="privacy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
@endsection

@section('footer')
<footer class="text-center p-2">
      <div class="container"> <a onclick="$('#terms').modal({
            backdrop: 'static',
            keyboard: false
        });"> Terms </a> | <a onclick="$('#privacy').modal({
            backdrop: 'static',
            keyboard: false
        });"> Privacy </a> | &nbsp; 2020 &copy; Copyrights onlyOPD </div>
    </footer>
@endsection