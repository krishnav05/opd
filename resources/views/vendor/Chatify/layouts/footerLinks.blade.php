<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
<script>
  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;
  var pusher = new Pusher("{{ config('chatify.pusher.key') }}", {
    encrypted: true,
    cluster: "{{ config('chatify.pusher.options.cluster') }}",
    authEndpoint: '{{route("pusher.auth")}}',
    auth: {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }
  });
</script>
<script src="{{ asset('js/chatify/code.js') }}"></script>
<script>
  // Messenger global variable - 0 by default
  // messenger = "{{ @$id }}";
    messenger = "user_"+localStorage.getItem('id');
  
//   setTimeout(function() {
    
// }, 2000);
  window.addEventListener("load", function(){
    var id = localStorage.getItem('id');
  IDinfo(id , 'user');
});


@if(auth()->user()->role_id == '2')
  var patientalert = new Pusher('5cee25784dec312477c7', {
      authEndpoint: '/broadcasting/auth',
      encrypted: true,
      cluster: 'ap2',
      auth: {
 
        headers: {
 
            'X-CSRF-Token': '{{ csrf_token() }}'
 
        }
 
    }
    });

    var channel = patientalert.subscribe('private-call-alert');
    channel.bind('call-alert', function(data) {
      // alert(JSON.stringify(data));   
      if(data.alert == 'alert' && data.id == localStorage.getItem('id'))
      {
        $('#pickup-call').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#audio')[0].play();
      } 
      if(data.alert == 'end' && data.id == localStorage.getItem('id'))
      {
        window.location = '/find-doc';
      }  
    });
@endif
$('#end').on('click',function(){
  $('#end-modal').modal();
  
});

$('#button-10').on('click',function(){
  if($('#check').is(":checked") == true)
  {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
                    /* the route pointing to the post function */
                    url: "/end",
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                      console.log('success');
                      window.location = '/call-pickup';
                    }
                });
  }
});

$('#video-call').on('click',function(){
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
                    /* the route pointing to the post function */
                    url: "/video-call-alert",
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                      window.location = '/doctor-video-call';
                    }
                });
});

$('#pick').on('click',function(){
  window.location = '/patient-video-call';
});
</script>