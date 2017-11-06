//START WEBSOCKET
//The homestead or local host server (don't forget the ws prefix)
var host =  $("#websocketUrl").val();
var socket = null;
var currentRouteName = $('#routeName').val();
var connected = false;
var intervalId = 0;

function runWebsocket() {
    try {
        socket = new WebSocket(host);
        
        //Manages the open event within your client code
        socket.onopen = function () {
            console.log('Connection Opened');  
            connected = true;
            sendMessage("Connected");
            fetchTickers();
            fetchTimeLogs();
            return;
        };
        //Manages the message event within your client code
        socket.onmessage = function (msg) {
            if (msg.data == "Connected" || "Connection Opened"){
                reloadControlPanelView();
            }
            
            //if(msg.data == "update_connections") {
                reloadConnectionsTable();
            //}
            console.log(msg.data);
            fetchTickers();
            fetchTimeLogs(); 
            
        };
        //Manages the close event within your client code
        socket.onclose = function () {
            console.log('Connection Closed');
            closeAllConnections();
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

//Check if web socket is up. Run if not.
window.setInterval(function(){
    if (this.connected == false) {
        runWebsocket();
    } else {
        socket.send("check ids");
    }
}, 5000);