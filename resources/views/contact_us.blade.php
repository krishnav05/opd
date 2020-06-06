@extends('layouts.master')

@section('content')

<div class="container">

  <div class="row">
    <div class="col otp-card">
      @if (\Session::has('success'))
    <div class="alert alert-success">
      {!! \Session::get('success') !!}
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
            <option value="I did not receive my credit">I did not receive my credit</option>
            <option value="Issue with my consultation">Issue with my consultation</option>
            <option value="Register as doctor">Register as doctor</option>
            <option value="Others">Others</option>
          </select>
          
         
          <input type="submit" name="" value="contact us" class="btn btn-primary form-control form-control-lg mt-4">

          <p class="mt-4"> Someone will reach out to you<br>as soon as possible </p>
        </div>  
      </form>
    </div>
  </div>


  
</div>

<button id="as" class="please"> asdasd</button>
@endsection
@section('footer')
<script type="text/javascript">
  $('.please').on('click',function(){
    $('.please').addClass('active');
    alert('added');
  }); 
  $('.please.active').on('click',function(){
    $('.please.active').removeClass('active');
    alert('removed');
  });
</script>
@endsection