@extends('layouts.master')

@section('content')

<div class="container">
  <p style="font-size: 12px;text-align: center;" class="mt-5 center">We may reach out to another top doctor with similar qualification if your doctor is busy</p>
  <div class="row">
    <div class="col text-center">
      <img src="{{asset('assets/img/hero-find-doc.svg')}}" class="img-fluid mt-3 ">
    </div>
  </div>

  <div id="app" class="col">
    
  </div><p style="text-align: center;" class="mt-2"><a id="endnow" style="display: none;text-align: center" class="mt-2 mb-2">Stop Finding Doctor</a></p>
  
  <div id="card" class="col otp-card" style="text-align: center;margin-left: 0;margin-right: 0;">
      <h6>You have <strong style="color: black;">{{$credit}} credit.</strong></h6>
      <input id="findnow" type="button" value="Connect Doctor" class="btn btn-primary form-control form-control-lg mt-3">
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
    { $('#findnow').hide(); 
    $('#findnow').next('div').show();

      // alert(localStorage.getItem('a'));
      previousresend();

    }
  var continuous = setInterval(function(){ 
    // alert("Hello"); 
    localStorage.setItem('a',document.getElementById("base-timer-label").innerText);
  }, 1000);
  </script>
@endsection