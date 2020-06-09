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
          <input type="text" inputmode="numeric" pattern="[0-9]*" name="pin1" size="1" minlength="1" maxlength="1"  class="col form-control form-control-lg opt-in ">
          <input type="text" inputmode="numeric" pattern="[0-9]*" name="pin2" size="1" minlength="1" maxlength="1"  class="col form-control form-control-lg opt-in ">
          <input type="text" inputmode="numeric" pattern="[0-9]*" name="pin3" size="1" minlength="1" maxlength="1"  class="col form-control form-control-lg opt-in ">
          <input type="text" inputmode="numeric" pattern="[0-9]*" name="pin4" size="1" minlength="1" maxlength="1"  class="col form-control form-control-lg opt-in ">
          <input type="submit" value="get inside" class="btn btn-primary form-control form-control-lg mt-3">
        </div> 
        <div id="opt-timer" class="col-sm-12 text-center mt-3 js-timeout">2:00</div>
            <a id="resend" class="col-sm-12 small mt-3  text-center" style="font-size: 32px;">Resend OTP</a>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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
<script type="text/javascript">

$(document).ready(function(){
  var interval;

function countdown() {
  clearInterval(interval);
  interval = setInterval( function() {
      var timer = $('.js-timeout').html();
      timer = timer.split(':');
      var minutes = timer[0];
      var seconds = timer[1];
      seconds -= 1;
      if (minutes < 0) return;
      else if (seconds < 0 && minutes != 0) {
          minutes -= 1;
          seconds = 59;
      }
      else if (seconds < 10 && length.seconds != 2) seconds = '0' + seconds;

      $('.js-timeout').html(minutes + ':' + seconds);

      if (minutes == 0 && seconds == 0) clearInterval(interval);
  }, 1000);
}

$('#js-startTimer').click(function () {
  $('.js-timeout').text("2:00");
  countdown();
});

$('#js-resetTimer').click(function () {
  $('.js-timeout').text("2:00");
  clearInterval(interval);
});
  countdown();

  // var timeLeft = 60;
  //     var elem = document.getElementById('opt-timer');
  //     var timerId = setInterval(countdown, 1000);

  //     function countdown() {
  //         if (timeLeft == -1) {
  //             clearTimeout(timerId);
  //             doSomething();
  //         } else {
  //             elem.innerHTML = timeLeft + ' seconds remaining';
  //             timeLeft--;
  //         }
  //     }
  
  
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
            // clearTimeout(timerId);
            // timeLeft = 60;
            // elem = document.getElementById('opt-timer');
            
            // timerId = setInterval(countdown, 1000);
            $('.js-timeout').text("2:00");
  clearInterval(interval);
  countdown();
          }
        });
});
      });

</script>


@endsection