<!DOCTYPE html>
<html>
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
	<title></title>
</head>
<body>
c2
<video></video>
<script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simple-peer/9.7.2/simplepeer.min.js"></script>
<script type="text/javascript">
navigator.mediaDevices.getUserMedia({
  video: true,
  audio: true
}).then(gotMedia).catch(() => {})

function gotMedia (stream) {
  var peer1 = new SimplePeer({ initiator: true, stream: stream })
  var peer2 = new SimplePeer()

  peer1.on('signal', data => {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
                    /* the route pointing to the post function */
                    url: "stream",
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN,data:data},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                       // window.userid = data.id;
                       // alert(window.userid);
                    }
                });
    peer2.signal(data)
  })

  peer2.on('signal', data => {
    peer1.signal(data)
  })

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
}
</script>
</body>
</html>