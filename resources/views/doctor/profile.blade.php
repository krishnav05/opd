@extends('layouts.master')

@section('content')
<div class="container">

  <div class="row">
    <div class="col otp-card">
      <h1>Your Profile</h1>
      <form action="profile" method="POST">
      	@csrf
        <div class="form-group mt-4">
          <input type="text" name="fullname"  class="form-control form-control-lg" placeholder="Full Name" value="{{$name}}">

          <input type="text" name="work"  class="form-control form-control-lg mt-4" placeholder="Where do you work?" value="{{$work}}">

          <input type="text" name="speciality"  class="form-control form-control-lg mt-4" placeholder="Speciality i.e. General Practitioner.." value="{{$speciality}}">
        
          <input type="number" min="1" name="years"  class="form-control form-control-lg mt-4" placeholder="No. of years" value="{{$years}}">
         
          <input type="submit" name="" value="UPDATE" class="btn btn-primary form-control form-control-lg mt-4">
          @if (\Session::has('success'))
          <p class="mt-4"> We would be updating <br>this space soon. </p>
          @endif
        </div>  
      </form>
      <p style="text-align: center;"><a href="doctor-logout">LOGOUT</a></p>
    </div>
  </div>


  
</div>
@endsection