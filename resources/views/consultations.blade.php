@extends('layouts.master')

@section('content')

<h5 style="text-align: center;">Consultation History</h5>
<center>
<ul class="patient-history">
  @if(Auth::user()->role_id == 2)
  @foreach($consultations as $consult)
  @foreach($doctors as $doctor)
  @if($consult['doctorId'] == $doctor['id']) 
  <li>
    <a href="/history/{{$consult['id']}}" class="d-block">Checkup with {{$doctor['name']}}, {{$consult['created_at']->diffForHumans()}}  <i class="fa fa-chevron-right"></i></a>
    <!-- <i class="fa fa-arrow-right"></i> -->
    <button type="button" id="{{$doctor['id']}}" class="reconsult btn btn-outline-primary">Consult Again</button>
  </li>
  @endif
  @endforeach
  @endforeach
  @else
  @foreach($consults as $consult)
  @foreach($patients as $patient)
  @if($consult['patientId'] == $patient['id']) 
  <li>
    <a href="/history/{{$consult['id']}}" class="d-block">Checkup with {{$patient['phone']}}, {{$consult['created_at']->diffForHumans()}}  <i class="fa fa-chevron-right"></i></a>
    <!-- <i class="fa fa-arrow-right"></i> -->
  </li>
  @endif
  @endforeach
  @endforeach
  @endif
</ul>
</center>
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

@section('css')
<style type="text/css">
	.patient-history{
	                 margin: 20px;
	                 padding: 0px;
	                 list-style:none;
                   text-align: left;
                }
.patient-history li{
	                   margin-bottom: 10px;
	                   background: #fff;
	                   padding: 10px;
	                   border-radius: 6px;
	                   border:1px solid #255985;
                   }
.patient-history li .fa{float: right; margin-top:5px; }
</style>
@endsection

@section('footer')
<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
<script type="text/javascript">
  var userid;
  var startTime = performance.now();

  $('.reconsult').on('click',function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
                    /* the route pointing to the post function */
                    url: "reconsult-doc",
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN,doctorId:this.id},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                      if(data.status == 'addcredits')
                      {
                        window.location = '/credits';
                      }
                       window.userid = data.id;
                       // alert(window.userid);
                    }
                });
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
