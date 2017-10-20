function sendDMSSwitcher(element, message) {
	var startTime = element.value;
		var timeString = startTime.split(":");
		var hour = parseInt(timeString[0]);
		var minutes = parseInt(timeString[1]);
		var seconds = parseInt(timeString[2]);
		var date = new Date(); // Create a Date object to find out what time it is
	    if(date.getHours() == hour && date.getMinutes() == minutes && date.getSeconds() == seconds){ // Check the time
	        sendMessage(message);
	    }
}

function showTime(){
	var date = new Date();
	var hour = date.getHours();
	var minutes = date.getMinutes();
	var seconds = date.getSeconds();

	if (seconds < 10){
		seconds = "0" + seconds;
	}
	if (minutes < 10) {
		minutes = "0" + minutes;
	}
	if (hour < 10) {
		hour = "0" + hour;
	}

	var currentTime = (hour +":"+ minutes +":"+ seconds);

	return currentTime;
}

function integrateDatePicker() {

    $('.datePicker').datetimepicker({

        format: 'HH:mm:ss'

    }); 

}

function setCurrentTime(){
	var dt = new Date;
	var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
	$('.currentTime').val(time);
}

function retrieveLogs(){
	var token = $("input[name=_token]").val();
	$.ajax({
        url: 'retrieve-logs/',
        type: 'GET',
        data: {
        	"_token": token,
        },
        success: function(result) {
    		sendMessage(result);
        },
        error: function(xhr, ajaxOptions, thrownError) {
        	console.log("error");
        }
    });
}


