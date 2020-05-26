<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
c2
<div class="video"></div>
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
    peer2.signal(data)
  })

  peer2.on('signal', data => {
    peer1.signal(data)
  })

  peer2.on('stream', stream => {
    // got remote video stream, now let's show it in a video tag
    var video = document.querySelector('.video')

    if ('srcObject' in video) {
      video.srcObject = stream
    } else {
      // video.src = window.URL.createObjectURL(stream) // for older browsers
    }
    console.log(video);
    video.get(0).play()
  })
}
</script>
</body>
</html>