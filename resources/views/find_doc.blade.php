@extends('layouts.master')

@section('content')

<div class="container">
  
  <div class="row">
    <div class="col text-center">
      <img src="{{asset('assets/img/hero-find-doc.svg')}}" class="img-fluid mt-3 ">
    </div>
  </div>

  <div id="app" class="col">
    
  </div>
  <input id="findnow" type="button" value="Consult Doctor Now" class="btn btn-primary form-control form-control-lg mt-3">
  <div id="divs" style="display: none;"><h1 class="text-center mb-4">hang on! <br> finding a doctor for you</h1 class="text-center"></div>

    
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
  $('#findnow').on('click',function(){
    $(this).hide();
    $(this).next('div').show();

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
    const TIME_LIMIT = 20;
    startTimer();
    // setTimeout(function() {
    //   $('#find-doc').modal();
    // }, 20000);
  });

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
  </script>
@endsection