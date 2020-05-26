<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
c1
<script src="{{asset('assets/js/peer.js')}}"></script>
<script type="text/javascript">
	
	var peer = new Peer();
	peer.on('open', function(id) {
		console.log('My peer ID is: ' + id);
	});
</script>

</body>
</html>