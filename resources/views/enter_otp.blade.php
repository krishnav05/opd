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
      <h1>Enter OTP <a onclick="history.back()" class="edit-num">(Edit Number)</a> </h1>
      <form action="otp-verify" method="POST">
        <div class="form-group mt-4">
          @csrf
          <input id="phone" type="hidden" name="number" value="{{$number}}">
          <input type="text"  pattern="\d*" name="pin1" size="1" minlength="1" maxlength="1"  class="col form-control form-control-lg opt-in ">
          <input type="text"  pattern="\d*" name="pin2" size="1" minlength="1" maxlength="1"  class="col form-control form-control-lg opt-in ">
          <input type="text"  pattern="\d*" name="pin3" size="1" minlength="1" maxlength="1"  class="col form-control form-control-lg opt-in ">
          <input type="text"  pattern="\d*" name="pin4" size="1" minlength="1" maxlength="1"  class="col form-control form-control-lg opt-in ">
          <input type="submit" value="get inside" class="btn btn-primary form-control form-control-lg mt-3">
        </div> 
        <div id="opt-timer" class="col-sm-12 text-center mt-3"></div>
            <a id="resend" class="col-sm-12 small mt-3  text-center">Resend OTP</a>
        </div> 
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col text-center">
      <p> Are you a doctor? <br> <a href="contact-us">Contact Us</a> </p>
    </div>
  </div>
  
</div>

@endsection

@section('footer')

<script type="text/javascript">

$(document).ready(function(){
  var timeLeft = 60;
      var elem = document.getElementById('opt-timer');
      var timerId = setInterval(countdown, 1000);

      function countdown() {
          if (timeLeft == -1) {
              clearTimeout(timerId);
              doSomething();
          } else {
              elem.innerHTML = timeLeft + ' seconds remaining';
              timeLeft--;
          }
      }
  
  
        $('input').keyup(function(event){
          if($(this).val().length==$(this).attr("maxlength") && event.keyCode !== 8){
            $(this).next().focus();
          }
        });
      $('input').keydown(function(event){
        if(event.keyCode == 8){
          event.preventDefault();
          if($(this).val().length==1){
            $(this).val('');
          }
          else{
            $(this).prev().focus().val('');
          }
        }
      });
     $('#resend').on('click',function(){
  var phone = $('#phone').val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
          /* the route pointing to the post function */
          url: '/resend-otp',
          type: 'POST',
          /* send the csrf-token and the input to the controller */
          data: {_token: CSRF_TOKEN,phone:phone},
          dataType: 'JSON',
          /* remind that 'data' is the response of the AjaxController */
          success: function (data) {
            clearTimeout(timerId);
            timeLeft = 60;
            elem = document.getElementById('opt-timer');
            
            timerId = setInterval(countdown, 1000);
          }
        });
});
      });

</script>


@endsection