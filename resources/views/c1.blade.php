<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
c1
<script src="https://unpkg.com/peerjs@1.2.0/dist/peerjs.min.js"></script>
<script type="text/javascript">
	
	var peer = new Peer();
	peer.on('open', function(id) {
		console.log('My peer ID is: ' + id);
	});
</script>

</body>
</html>