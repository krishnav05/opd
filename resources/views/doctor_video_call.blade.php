<html>
<head>
    <title> OnlyOPD Video Call </title>
    <style>
.his-video{
position: absolute;
width: 35vw;
height: 12vh;
overflow: hidden;
background: #333;
display: block;
top: 20px;
right: 20px;
border:1px solid #FF9800;
}.my-video{
      position: relative;
      width: 100vw;
      height: 100vh;
      overflow: hidden;
      background: #000;
      display: block;
     }
     .video-call-action{
          position: absolute;
          bottom: 20px;
          width: 100%;
          padding: 14px;
          text-align: center;
          }
.ic-mute-call {
              width: 65px;
              height: 65px;
              background: #ccc;
              color: #999;
              border-radius: 100%;
              text-align: center;
              padding: 12px;
              margin: 0 10px;
              display: inline-block;
              font-size: 3em;
          }
           .ic-mute-call .fa {line-height: 65px;}
.ic-mute-call.active{
            color: #333 !important;
          }
.ic-end-call {
              width: 65px;
              height: 65px;
              background: #D32F2F;
              color: #fff;
              border-radius: 100%;
              text-align: center;
              padding: 12px;
              margin: 0 10px;
              display: inline-block;
              font-size: 3em;
          }
           .ic-end-call .fa {line-height: 65px;}
.ic-off-video-call {
                width: 65px;
                height: 65px;
                background: #ccc;
                color: #999;
                border-radius: 100%;
                text-align: center;
                padding: 12px;
                margin: 0 10px;
                display: inline-block;
                font-size: 3em;
            }
            .ic-off-video-call .fa {line-height: 65px;}
.ic-off-video-call.active{
            color: #333 !important;
          }
    </style>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://static.opentok.com/v2/js/opentok.js"></script>
</head>
<body>
<!-- <main> -->
      <div id="subscriber" class="my-video"></div>
      <div id="publisher" class="his-video"></div>
    <!-- </main> -->
    <div class="video-call-action">
      <a class="ic-mute-call"> <i class="fa fa-microphone-slash"></i> </a>
      <a class="ic-end-call"> <i class="fa fa-phone"></i> </a>
      <a class="ic-off-video-call"> <i class="fa fa-video-camera"></i> </a>

    </div>


    <!-- <script src="https://static.opentok.com/v2/js/opentok.min.js"></script> -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
    <script type="text/javascript">

    var token = '{{ $opentok_token }}';
    var sessionId = '{{ $session_id }}';
    var apiKey = '46765912';
initializeSession();
function handleError(error) {
  if (error) {
    console.error(error);
  }
}

function initializeSession() {
  var session = OT.initSession(apiKey, sessionId);

  // Subscribe to a newly created stream
  session.on('streamCreated', function streamCreated(event) {
    var subscriberOptions = {
      insertMode: 'append',
      width: '100%',
      height: '100%'
    };
    session.subscribe(event.stream, 'subscriber', subscriberOptions, handleError);
  });
  
  session.on('sessionDisconnected', function sessionDisconnected(event) {
    console.log('You were disconnected from the session.', event.reason);
  });

  // initialize the publisher
  var publisherOptions = {
    insertMode: 'append',
    width: '100%',
    height: '100%'
  };
  var publisher = OT.initPublisher('publisher', publisherOptions, handleError);

  $('.ic-mute-call').on('click',function(){
    if($('.ic-mute-call').hasClass('active'))
    {
      $('.ic-mute-call').removeClass('active');
      publisher.publishAudio(true);
    }
    else{
      $('.ic-mute-call').addClass('active');

    publisher.publishAudio(false);
    }
    
  });

  $('.ic-off-video-call').on('click',function(){
    if($('.ic-off-video-call').hasClass('active'))
    {
      $('.ic-off-video-call').removeClass('active');
      publisher.publishVideo(true);
    }
    else{
      $('.ic-off-video-call').addClass('active');

    publisher.publishVideo(false);
    }
  });

  $('.ic-end-call').on('click',function(){
    window.location = '/chatify';
  });

  // Connect to the session
  session.connect(token, function callback(error) {
    if (error) {
      handleError(error);
    } else {
      // If the connection is successful, publish the publisher to the session
      session.publish(publisher, handleError);
    }
  });
}
    </script>
</body>
</html>