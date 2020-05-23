@extends('layouts.master')

@section('content')

<div class="container">

  <div class="row">
    <div class="col otp-card">
      @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
      <h1>Your Information</h1>
      <form action="contact-details" method="POST">
      	@csrf
        <div class="form-group mt-4">
          <input type="text" name="fullname"  class="form-control form-control-lg" placeholder="Full Name">

          <input type="text" pattern="\d*" name="phone"  class="form-control form-control-lg mt-4" placeholder="Phone Number">

          <input type="email" name="email"  class="form-control form-control-lg mt-4" placeholder="Email Address">

          <select class="form-control form-control-lg mt-4" name="option" required>
            <option value="Apply For Doctor">Apply for Doctor</option>
            <option value="Help Others">Help Others</option>
          </select>
          
         
          <input type="submit" name="" value="contact us" class="btn btn-primary form-control form-control-lg mt-4">

          <p class="mt-4"> Someone will reach out to you<br>as soon as possible </p>
        </div>  
      </form>
    </div>
  </div>


  
</div>


@endsection