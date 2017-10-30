var tickers = [];
var time_sequence = [];


fetchTickers();
fetchTimeLogs();
reloadControlPanelView();

function reloadControlPanelView(){
    fetchControlPanelView(function(result){
        $('#tableBody').empty();
         $.each(result, function(index,element){
            var time = JSON.stringify(element.time);
            	time = time.replace(/\"/g, "");
            var message = JSON.stringify(element.returnMessage);
            	message = message.replace(/\"/g, "");
            var status = JSON.stringify(element.status);
            	status = status.replace(/\"/g, "");
            var id = JSON.stringify(element.id);
            	id = id.replace(/\"/g, "");
            var type = JSON.stringify(element.type);
            	type = type.replace(/\"/g, "");

            if (time > showTime()){
                    $('#tableBody').append('<tr><td class = "time" align = "center" data-type = "'+ type +'" data-id = "'+ id +'" data-status = "'+status+'" data-value = "'+time+'">'+ time +'</td>' +
                                     '<td align = "center">'+ message +'</td><tr>');
            }
         });
    });
}

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
	var date = new Date;

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

	var time = hour + ":" + minutes + ":" + seconds;
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
function fetchTimeLogs(){
	var token = $("input[name=_token]").val();
	$.ajax({
        url: 'retrieve-logs',
        type: 'GET',
        data: {
        	"_token": token,
        },
        success: function(result) {
    		// logs($.parseJSON(result));
    		time_sequence = $.parseJSON(result).time_management;
    	},
        error: function(xhr, ajaxOptions, thrownError) {
        	console.log(thrownError);
        	logs(thrownError);
        }
    });
}

function fetchTickers(){
	var token = $("input[name=_token]").val();
	$.ajax({
        url: 'retrieve-tickers',
        type: 'GET',
        data: {
        	"_token": token,
        },
        success: function(result) {
        	tickers = $.parseJSON(result).tickers;
    		// tickers($.parseJSON(result));
    	},
        error: function(xhr, ajaxOptions, thrownError) {
        	console.log(thrownError);
        	tickers(thrownError);
        }
    });
}

function fetchControlPanelView(data){
    var token = $("input[name=_token]").val();
    $.ajax({
        url: 'fetch-control-panel-view',
        type: 'GET',
        data: {
            "_token": token,
        },
        success: function(result) {
            data($.parseJSON(result));
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError);
            tickers(thrownError);
        }
    });
}

function deleteTimeSequence(deleteBtn,deleteBtnData,token){
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
                    retrieveLogsOnDelete();
                    retrieveTickersOnDelete();   
                }else{
                    swal(
                      'Oops...',
                      'Something went wrong!',
                      'error'
                    )
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
}
function deleteTicker(deleteBtn,deleteBtnData,token){
	$.ajax({
        url: 'ticker/' + deleteBtnData,
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
				retrieveLogsOnDelete()  
				retrieveTickersOnDelete()          		
			}else{
    			swal(
				  'Oops...',
				  'Something went wrong!',
				  'error'
				)
    		}
        },
        error: function(xhr, ajaxOptions, thrownError) {
        	console.log(thrownError);
        }
    });
}
 







