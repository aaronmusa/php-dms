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

$(function() {

			// var logs = $('#logs').val();
			// console.log(JSON.stringify("'"+ logs + "'", replacer));
			// 			console.log(logs);

	var addButtonCounter = 0;
	var counter = 0;

	window.setInterval(function(){ // Set interval for checking
	// $(timeLogs.time_management).each(function(index, element) {
	// 	console.log(element.id);
	// });

		$("label[for='time']").html(showTime())
		
			
		$(".startTime").each(function(index, element) {
			sendDMSSwitcher(element, "FBLIVE");
		});

		$(".endTime").each(function(index, element) {
			sendDMSSwitcher(element, "DMS");
		});

		if (this.connected == false) {
			runWebsocket();
		}

	}, 1000);

	$('#fbLiveSwitcher').click(function(){
    	var urlStorage = $('#urlStorage').val();
    	var videoStreamingUrl = '{"live_url": "'+ urlStorage +'" }';
    	//sendMessage(videoStreamingUrl);
    	sendMessage("FBLIVE");

    });

    $('#dmsSwitcher').click(function(){
    	sendMessage("DMS");
    });

    $(".deleteBtn").on('click',function(){
		    	var deleteBtnData = $(this).data('id');
		    	var token = $("input[name=_token]").val();
		    	

		    	$.ajax({
	                url: 'time-scheduler/' + deleteBtnData,
	                type: 'POST',
	                data: {
	                	"_token": token,
	                	"_method": "DELETE"
	                },
	                success: function(result) {
	                	console.log(deleteBtnData);

	             		//location.reload();
	                },
	                error: function(xhr, ajaxOptions, thrownError) {

	                }
	            });
		    });

});