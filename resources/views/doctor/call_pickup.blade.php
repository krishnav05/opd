@extends('layouts.master')

@section('content')
	
<div class="container">
  
  <div class="row">
    <div class="col text-center">
      <img src="{{asset('assets/img/hero-mobile-otp.svg')}}" class="img-fluid mt-3 ">
    </div>
  </div>
  <div class="mt-4 mb-4 text-center"><h5>You are <strong id="text_avail" style="color: black;">Available</strong> to take calls.</h5></div>
 <input id="available" type="button" value="CHANGE STATUS" class="btn btn-primary form-control form-control-lg mt-3">
 <p id="inside" style="text-align: center;" class="mt-2"></p>
  
</div>

<div class="modal fade animate m-4" id="pickup-call" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content animate-bottom">
      
      <div class="modal-body">
       <h1 class="text-center mb-3"> Tap to Answer </h1>
       <div class="m-auto text-center">
          <div class="sonar-wrapper">
            <div class="sonar-emitter"><a href="#" class="fa fa-phone fa-2x"></a>
              <div class="sonar-wave"></div>
              <audio id="audio" loop="loop" class="">
                <source src="/assets/img/doctor-doctor.mp3" type="audio/mp3">
              </audio>
            </div>
          </div>
       </div>
       <input id="pick" type="button" formaction="" name="" value="Pickup" class="btn btn-primary form-control form-control-lg mt-3">
        <br><br>
        <p style="text-align: center;"><a id="endcall">Cancel</a></p>

      </div>
    
    </div>
  </div>
</div>

<div class="modal fade animate m-4" id="find-doc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content animate-bottom">
      
      <div class="modal-body pick-call-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
       <h1 class="text-center mb-3"> Are you available to <br> take calls? </h1>
       <div class="m-auto text-center">
          <div class="button b2" id="button-10">
                <input id="check" type="checkbox" class="checkbox">
                <div class="knobs">
                  <span>YES</span>
                </div>
                <div class="layer"></div>
              </div>
       </div>
       <p class="text-center mt-3"> No calls will come to you if <br>this option is set to no </p>
      
      </div>
    
    </div>
  </div>
</div>

@endsection

@section('footer')

<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
<script>
  if (localStorage.getItem("status") === 'yes') {
  //...
  $('#check').prop('checked',false);
}
else if(localStorage.getItem("status") === 'no')
{
  $('#check').prop('checked',true);
  $('#text_avail').html('').html('Not Available').css("color","red");
      $('#inside').html('You are not receiving any calls from patients').css("color","red");
}
  $('#button-10').on('click',function(){
    // alert($('#check').is(":checked"));
    if($('#check').is(":checked") == true)
    { localStorage.setItem('status','no');
      $('#text_avail').html('').html('Not Available').css("color","red");
      $('#inside').html('You are not receiving any calls from patients').css("color","red");
    }
    else
    { localStorage.setItem('status','yes');
      $('#inside').html('');
      $('#text_avail').html('').html('Available').css("color","black");
    }

  });
	var patientid;
  var doctorId = {!! Auth::user()->id !!};
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

    var channel = pusher.subscribe('private-my-channel');
    channel.bind('notify-doctor', function(data) {
      // alert(JSON.stringify(data));
      if(data.status == 'alert')
      {
        if($('#check').is(":checked") == false)
      {
        $('#pickup-call').modal({
            backdrop: 'static',
            keyboard: false
        });
      $('#audio')[0].play();
      localStorage.setItem("id",data.id);
      window.patientid = data.id;
      } 
      }
      if(data.status == 'reconsult' && data.doctorId == window.doctorId)
      {
        if($('#check').is(":checked") == false)
      {
        $('#pickup-call').modal({
            backdrop: 'static',
            keyboard: false
        });
      $('#audio')[0].play();
      localStorage.setItem("id",data.id);
      window.patientid = data.id;
      } 
      }
      if(data.status == 'end')
      {
        if(localStorage.getItem("id") == data.id )
        {
          $('#pickup-call').modal('hide');
          $('#audio')[0].pause();
        }
      }
      
      
    });
  	$('#available').on('click',function(){
  		$('#find-doc').modal({
            backdrop: 'static',
            keyboard: false
        });
  	});
  	$('#pick').on('click',function(){
  		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
                    /* the route pointing to the post function */
                    url: "call-pickup",
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN,patientid:patientid},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                    	if(data.status == 'success')
                    	{
                    		window.location = '/chatify';
                    	}
                      if(data.status == 'fail')
                      {
                        
                        $('#pickup-call').modal('hide');
                        $('#audio')[0].pause();
                        alert('This patient is consulting with another doctor');
                    }
                      }
                });
  	});
//   	$(function(){
//     $('#pickup-call').on('show.bs.modal', function(){
//         var myModal = $(this);
//         clearTimeout(myModal.data('hideInterval'));
//         myModal.data('hideInterval', setTimeout(function(){
//             myModal.modal('hide');
//         }, 60000));
//     });
// });
$('#endcall').on('click',function(){
  $('#pickup-call').modal('hide');
      $('#audio')[0].pause();
});
var temp = setTimeout(function(){
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
                    /* the route pointing to the post function */
                    url: "autocheck",
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                      if(data.success == 'success')
                      {
                       if($('#check').is(":checked") == false)
      {
        $('#pickup-call').modal({
            backdrop: 'static',
            keyboard: false
        });
      $('#audio')[0].play();
      localStorage.setItem("id",data.id);
      window.patientid = data.id;
      }  
                      }
                      }
                });
 }, 2000);

  </script>

@endsection