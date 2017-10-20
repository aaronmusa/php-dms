//START WEBSOCKET
//The homestead or local host server (don't forget the ws prefix)
var host =  $("#websocketUrl").val();
var socket = null;
var logs = $('#timeLogs').val();
var connected = false;

function runWebsocket() {

    try {
        socket = new WebSocket(host);
        
        //Manages the open event within your client code
        socket.onopen = function () {
            console.log('Connection Opened');  
            sendMessage(logs);  
            connected = true;
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
            connected = false;
            return;
        };
    } catch (e) {
        console.log(e);
    }
}

        runWebsocket();

function sendMessage(id) {
    socket.send(id);
}
//END WEBSOCKET