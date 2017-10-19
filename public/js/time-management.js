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

$(function() {

	setCurrentTime();

	integrateDatePicker();
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

    $('#updateUrl').click(function(){
    	var urlInput = $("#urlInput").val();
    	var videoStreamingUrl = '{"live_url": "'+ urlInput +'" }';
    	console.log(videoStreamingUrl);
    	sendMessage(videoStreamingUrl);
    });

    $(".deleteBtn").on('click',function(){
		var deleteBtn = $(this);
    	var deleteBtnData = $(this).data('id');
    	var token = $("input[name=_token]").val();
    	swal({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then(function () {
			$.ajax({
                url: 'time-scheduler/' + deleteBtnData,
                type: 'POST',
                data: {
                	"_token": token,
                	"_method": "DELETE"
                },
                success: function(result) {
            	if (result == 1) {
						swal(
						    'Deleted!',
						    'Your file has been deleted.',
						    'success'
					  	)
	    				deleteBtn.parents('tr')[0].remove();
            		} 
            		else{
            			swal(
						  'Oops...',
						  'Something went wrong!',
						  'error'
						)
            		}
                },
                error: function(xhr, ajaxOptions, thrownError) {

                }
            });
		}).catch(swal.noop)	
    });
    
});
