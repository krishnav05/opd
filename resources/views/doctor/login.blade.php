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
          <!-- <p class="text-left mt-3"> <a href="" onclick="return false;">Forgot Password?</a> </p> -->
          <input type="submit" name="" value="Sign-In" class="btn btn-primary form-control form-control-lg mt-4">
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