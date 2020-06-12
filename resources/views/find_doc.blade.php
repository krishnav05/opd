@extends('layouts.master')

@section('content')

<div class="container">
  
  <div class="row">
    <div class="col text-center">
      <img src="{{asset('assets/img/hero-find-doc.svg')}}" class="img-fluid mt-3 ">
    </div>
  </div>

  <div id="app" class="col">
    
  </div><p style="text-align: center;" class="mt-2"><a id="endnow" style="display: none;text-align: center" class="mt-2 mb-2">Stop Finding Doctor</a></p>
  
  <div id="card" class="col otp-card" style="text-align: center;margin-left: 0;margin-right: 0;">
      <h6>You have <strong style="color: black;">{{$credit}} credit.</strong></h6>
      <input id="findnow" type="button" value="Consult Doctor Now" class="btn btn-primary form-control form-control-lg mt-3">
  <div id="divs" style="display: none;"><h1 class="text-center mb-4">hang on! <br> finding a doctor for you</h1 class="text-center"></div>
    <!-- <input id="endnow" type="button" value="Stop Findind Doctor" class="btn btn-primary form-control form-control-lg mt-3" style="display: none;"> -->
    </div>
  

    
  </div>


  <div class="modal fade animate m-4" id="find-doc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content animate-bottom">
        
        <div class="modal-body">
         <h1 class="text-center mb-3"> Doctor is available!<br> you Chat now. </h1>
         <div class="doc-found m-auto text-center">
           <img id="doc-image" src="" class="doc-pic">
           <a href="#" class="doc-tap"><i class="fa fa-mobile fa-2x"></i></a>
           <h4>Available</h4>
           <h5 id="doc-name"></h5>
         </div>
         <input id="start-chat" type="submit" formaction="" name="" value="start chatting" class="btn btn-primary form-control form-control-lg mt-3">
         
       </div>
       
     </div>
   </div>
 </div>


 @endsection

 @section('footer')
<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
 <script type="text/javascript">

var startTime = performance.now();

  var userid;


    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('5cee25784dec312477c7', {
      authEndpoint: '/broadcasting/auth',
      encrypted: true,
      cluster: 'ap2',
      auth: {
 
        headers: {
 
            'X-CSRF-Token': '{{ csrf_token() }}'
 
        }
 
    }
    });

    var channel = pusher.subscribe('private-patient-channel');
    channel.bind('notify-patient', function(data) {
      // alert(JSON.stringify(data));
      
      if(data.patientid == window.userid)
      {
        localStorage.setItem("id", data.doctorid);
      console.log(data.id);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var endTime = performance.now();
  var timeDiff = endTime - window.startTime; //in ms 
  // strip the ms 
  timeDiff /= 1000; 
  
  // get seconds 
  var seconds = Math.round(timeDiff);
    $.ajax({
                    /* the route pointing to the post function */
                    url: "doc-details",
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN ,doctorid:data.doctorid,wait_time:seconds},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                       // window.userid = data.id;
                       // alert(window.userid);
                       $('#doc-name').append(data.name);
                       $('#doc-image').attr('src','/storage/users-avatar/'+data.image).width('120px').height('100px');
                       $('#find-doc').modal({
            backdrop: 'static',
            keyboard: false
        });
                    }
                });
      // window.location = '/chatify';
      }
      
    });

    $('#start-chat').on('click',function(){
      window.location = '/chatify';
    });

    if({{$timer}})
    {	$('#findnow').hide();	
		$('#findnow').next('div').show();
    	previousresend();
      // alert(localStorage.getItem('a'));

    }
     $(window).bind('beforeunload',function(){
//do something
localStorage.setItem('a',document.getElementById("base-timer-label").innerText);
});
    function convert(input) {
    var parts = input.split(':'),
        minutes = +parts[0],
        seconds = +parts[1];
    return (minutes * 60 + seconds);
}
    function previousresend()
  {
  // $('#endnow').hide();
    const FULL_DASH_ARRAY = 283;
const WARNING_THRESHOLD = 10;
const ALERT_THRESHOLD = 5;

const COLOR_CODES = {
  info: {
    color: "green"
  },
  warning: {
    color: "green",
    threshold: WARNING_THRESHOLD
  },
  alert: {
    color: "green",
    threshold: ALERT_THRESHOLD
  }
};

const TIME_LIMIT = convert(localStorage.getItem('a'));
let timePassed = 0;
let timeLeft = TIME_LIMIT;
let timerInterval = null;
let remainingPathColor = COLOR_CODES.info.color;

function onTimesUp() {
  clearInterval(timerInterval);
  $('#endnow').show();
  document.getElementById("app").innerHTML = `<div style="text-align: center;">It's taking more time than usual,<br>
  <strong>Doctors</strong> are busy with <strong>other patients.</strong><br>Please give us few more minutes.</div>`;
  setTimeout(function(){ resend();
       window.my = setInterval(resend, 190000); }, 10000);

    
}

function startTimer() {
  timerInterval = setInterval(() => {
    timePassed = timePassed += 1;
    timeLeft = TIME_LIMIT - timePassed;
    document.getElementById("base-timer-label").innerHTML = formatTime(
      timeLeft
    );
    setCircleDasharray();
    setRemainingPathColor(timeLeft);

    if (timeLeft === 0) {
      onTimesUp();
    }
  }, 1000);
}

function formatTime(time) {
  const minutes = Math.floor(time / 60);
  let seconds = time % 60;

  if (seconds < 10) {
    seconds = `0${seconds}`;
  }

  return `${minutes}:${seconds}`;
}

function setRemainingPathColor(timeLeft) {
  const { alert, warning, info } = COLOR_CODES;
  if (timeLeft <= alert.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(warning.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(alert.color);
  } else if (timeLeft <= warning.threshold) {
    document
      .getElementById("base-timer-path-remaining")
      .classList.remove(info.color);
    document
      .getElementById("base-timer-path-remaining")
      .classList.add(warning.color);
  }
}

function calculateTimeFraction() {
  const rawTimeFraction = timeLeft / TIME_LIMIT;
  return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
}

function setCircleDasharray() {
  const circleDasharray = `${(
    calculateTimeFraction() * FULL_DASH_ARRAY
  ).toFixed(0)} 283`;
  document
    .getElementById("base-timer-path-remaining")
    .setAttribute("stroke-dasharray", circleDasharray);
}




    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
                    /* the route pointing to the post function */
                    url: "find-doc",
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                       window.userid = data.id;
                       // alert(window.userid);
                    }
                });

    document.getElementById("app").innerHTML = `
    <div class="base-timer">
    <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <g class="base-timer__circle">
    <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
    <path
    id="base-timer-path-remaining"
    stroke-dasharray="283"
    class="base-timer__path-remaining ${remainingPathColor}"
    d="
    M 50, 50
    m -45, 0
    a 45,45 0 1,0 90,0
    a 45,45 0 1,0 -90,0
    "
    ></path>
    </g>
    </svg>
    <span id="base-timer-label" class="base-timer__label">${formatTime(
      timeLeft
      )}</span>
    </div>
    `;
    startTimer();
    $('#endnow').on('click',function(){
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
                    /* the route pointing to the post function */
                    url: "alert-end",
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                       // window.userid = data.id;
                       // alert(window.userid);
                    }
                });
    $(this).hide();
    $('#findnow').show();
    $('#findnow').next('div').hide();
    document.getElementById("app").innerHTML = ``;
    clearInterval(timerInterval);
    clearInterval(window.my);
  });
  }

  </script>
@endsection