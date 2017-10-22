function sendDMSSwitcher(element, message) {
	var startTime = element;
		startTime = startTime.replace(/\"/g, "");
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

function retrieveLogsOnDelete(){
	var token = $("input[name=_token]").val();
	$.ajax({
        url: 'retrieve-logs',
        type: 'GET',
        data: {
        	"_token": token,
        },
        success: function(result) {
    		sendMessage(result);
        },
        error: function(xhr, ajaxOptions, thrownError) {
        	console.log(thrownError);
        }
    });
}
function retrieveTickersOnDelete(){
	var token = $("input[name=_token]").val();
	$.ajax({
        url: 'retrieve-tickers',
        type: 'GET',
        data: {
        	"_token": token,
        },
        success: function(result) {
    		sendMessage(result);
        },
        error: function(xhr, ajaxOptions, thrownError) {
        	console.log(thrownError);
        }
    });
}
function fetchTimeLogs(logs){
	var token = $("input[name=_token]").val();
	$.ajax({
        url: '/retrieve-logs',
        type: 'GET',
        data: {
        	"_token": token,
        },
        success: function(result) {
    		logs($.parseJSON(result));
    	},
        error: function(xhr, ajaxOptions, thrownError) {
        	console.log(thrownError);
        	logs(thrownError);
        }
    });
}

fetchTimeLogs(function(result){
	window.setInterval(function(){
		$.each(result.time_management, function(index,element){
			var startTime = JSON.stringify(element.start_time);
			sendDMSSwitcher(startTime, "FBLIVE");
		});

		$.each(result.time_management, function(index,element){
			var endTime = JSON.stringify(element.end_time);
			sendDMSSwitcher(endTime, "DMS");
		});
		$("label[for='time']").html(showTime())

		if (this.connected == false) {
			runWebsocket();
		}
	}, 1000);
});

function fetchTickers(tickers){
	var token = $("input[name=_token]").val();
	$.ajax({
        url: '/retrieve-tickers',
        type: 'GET',
        data: {
        	"_token": token,
        },
        success: function(result) {
    		tickers($.parseJSON(result));
    	},
        error: function(xhr, ajaxOptions, thrownError) {
        	console.log(thrownError);
        	tickers(thrownError);
        }
    });
}

fetchTickers(function(result){
	window.setInterval(function(){
		$.each(result.tickers, function(index,element){
			var startTime = JSON.stringify(element.start_time);
			var message = JSON.stringify(element.message);
			var startTickerJson = '{"start_ticker":' + message + '}';
			sendDMSSwitcher(startTime, startTickerJson);
		});

		$.each(result.tickers, function(index,element){
			var endTime = JSON.stringify(element.end_time);
			sendDMSSwitcher(endTime, "END_TICKER");
		});
	}, 1000);
});


