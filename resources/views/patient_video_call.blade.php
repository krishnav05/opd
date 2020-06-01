<html>
<head>
    <title> OnlyOPD Video Call </title>
    <style>
.subscriber {
  width: 100%;
  height: 100%;
  display: flex;
}
 
.publisher {
  position: absolute;
  width: 25vmin;
  height: 25vmin;
  min-width: 8em;
  min-height: 8em;
  align-self: flex-end;
}
    </style>
    <script src="https://static.opentok.com/v2/js/opentok.js"></script>
</head>
<body>
    <!-- <main> -->
      <div id="subscriber" class="subscriber"></div>
      <div id="publisher" class="publisher"></div>
    <!-- </main> -->

    <!-- <script src="https://static.opentok.com/v2/js/opentok.min.js"></script> -->
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