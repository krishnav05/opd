<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Basic Video Chat</title>
    <style type="text/css">
      html {
  box-sizing: border-box;
  height: 100%;
}
 
*,
*::before,
*::after {
  box-sizing: inherit;
  margin: 0;
  padding: 0;
}
 
body {
  height: 100%;
  display: flex;
  flex-direction: column;
}
 
header {
  text-align: center;
  padding: 0.5em;
}
 
main {
  flex: 1;
  display: flex;
  position: relative;
}
 
input,
button {
  font-size: inherit;
  padding: 0.5em;
}
 
.registration {
  display: flex;
  flex-direction: column;
  margin: auto;
}
 
.registration input[type="text"] {
  display: block;
  margin-bottom: 1em;
}
 
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
    <meta name="description" content="A basic audio-video chat application" />
    <link
      id="favicon"
      rel="icon"
      href="https://tokbox.com/developer/favicon.ico"
      type="image/x-icon"
    />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
 
    <!-- <link rel="stylesheet" href="/style.css" /> -->
  </head>
 
  <body>
    <header>
      <h1>The most basic video chat</h1>
    </header>
 
    <main>
      <div id="subscriber" class="subscriber"></div>
      <div id="publisher" class="publisher"></div>
    </main>
 

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