<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
c1
<video></video>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simple-peer/9.7.2/simplepeer.min.js"></script>
<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
<script type="text/javascript">

      var peer2 = new SimplePeer()
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

    var channel = pusher.subscribe('private-stream-channel');
    channel.bind('notify-patient', function(data) {
      peer2.signal(data.data)
      
    });
peer2.on('stream', stream => {
    // got remote video stream, now let's show it in a video tag
    var video = document.querySelector('video')

    if ('srcObject' in video) {
      video.srcObject = stream
    } else {
      // video.src = window.URL.createObjectURL(stream) // for older browsers
    }
    console.log(video);
    video.play()
  })
</script>

</body>
</html>