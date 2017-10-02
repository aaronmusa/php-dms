//START WEBSOCKET
//The homestead or local host server (don't forget the ws prefix)
var host = 'ws://127.0.0.1:80';
var socket = null;
try {
    socket = new WebSocket(host);
    
    //Manages the open event within your client code
    socket.onopen = function () {
        console.log('Connection Opened');
        return;
    };
    //Manages the message event within your client code
    socket.onmessage = function (msg) {
      console.log(msg.data);
      return;
    };
    //Manages the close event within your client code
    socket.onclose = function () {
        console.log('Connection Closed');
        return;
    };
} catch (e) {
    console.log(e);
}

function sendMessage(message) {
	socket.send(message);
}
//END WEBSOCKET