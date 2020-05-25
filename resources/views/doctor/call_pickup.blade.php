@extends('layouts.master')

@section('content')
	
<div class="container">
  
  <div class="row">
    <div class="col text-center">
      <img src="{{asset('assets/img/hero-mobile-otp.svg')}}" class="img-fluid mt-3 ">
    </div>
  </div>

 <input id="available" type="button" value="Available To Take Calls" class="btn btn-primary form-control form-control-lg mt-3">
  
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
            </div>
          </div>
       </div>
       <input id="pick" type="button" formaction="" name="" value="Pickup" class="btn btn-primary form-control form-control-lg mt-3">
      
      </div>
    
    </div>
  </div>
</div>

<div class="modal fade animate m-4" id="find-doc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content animate-bottom">
      
      <div class="modal-body pick-call-body">
       <h1 class="text-center mb-3"> Are you available to <br> take calls? </h1>
       <div class="m-auto text-center">
          <div class="button b2" id="button-10">
                <input type="checkbox" class="checkbox">
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
	var patientid;
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
      $('#pickup-call').modal();
      localStorage.setItem("id",data.id);
      window.patientid = data.id;
    });
  </script>
  <script type="text/javascript">
  	$('#available').on('click',function(){
  		$('#find-doc').modal();
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
                       
                    }
                });
  	});
  	$(function(){
    $('#pickup-call').on('show.bs.modal', function(){
        var myModal = $(this);
        clearTimeout(myModal.data('hideInterval'));
        myModal.data('hideInterval', setTimeout(function(){
            myModal.modal('hide');
        }, 60000));
    });
});
  </script>

@endsection