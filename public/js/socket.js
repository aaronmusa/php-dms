//START WEBSOCKET
//The homestead or local host server (don't forget the ws prefix)
var host =  $("#websocketUrl").val();
var socket = null;
var currentRouteName = $('#routeName').val();
var connected = false;



function runWebsocket() {
    try {
        socket = new WebSocket(host);
        
        //Manages the open event within your client code
        socket.onopen = function () {
            console.log('Connection Opened');  
            connected = true;
            fetchControlPanelView(function(result){
                sendMessage(result);
            });
            return;
        };
        //Manages the message event within your client code
        socket.onmessage = function (msg) {
            fetchControlPanelView(function(result){
                $('#tableBody').empty();
                 $.each(result, function(index,element){
                    var time = JSON.stringify(element.time);
                    time = time.replace(/\"/g, "");
                    var message = JSON.stringify(element.returnMessage);
                    message = message.replace(/\"/g, "");
                            $('#tableBody').append('<tr><td class = "time" align = "center" data-value = "">'+ time +'</td>' +
                                             '<td align = "center">'+ message +'</td><tr>');
                 });
            });
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