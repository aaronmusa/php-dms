	<script type="text/javascript">

		var host =  $("#websocketUrl").val();
		var socket = null;

		var timeManagementJson = $('#timeLogs').val();
		var timeLogs = JSON.parse(timeManagementJson);
		var connected = false;

		function runWebsocket() {
			try {
			    socket = new WebSocket(host);
			    
			    //Manages the open event within your client code
			    socket.onopen = function () {
			        console.log('Connection Opened');	 
			        sendMessage(timeManagementJson);
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
		// function replacer(key, value) {
		//   return value.replace(/\\/g, '');
		// }

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

		

			//END WEBSOCKET
			

			


			function integrateDatePicker() {

			    $('.datePicker').datetimepicker({

			        format: 'HH:mm:ss'

			    }); 

			}

		    $(".addBtn").on('click',function(){
		    	var dt = new Date;
		    	var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
		    	addButtonCounter++;
		    	if (addButtonCounter > 0) {
		    		$('.removeBtn').attr('style','visibility:visible',);
		    		$("#submitBtn").attr('style','visibility:visible;');
		    	}
		    	else{
		    		$('.removeBtn').attr('visibility','hidden');
		    		$("#submitBtn").attr('style','visibility:hidden;');
		    	}
		    	var startTime = '<div class = "col-sm-12">'+
		    					'<div id="startTime' + addButtonCounter + '" class= "form-group col-sm-4">'+
		    					'<h4 class = "newEntryHeader'+ addButtonCounter +'" >New Entry # '+ addButtonCounter +'</h4>'+
								'<input value = "'+ time +'" type="text" name="times[][start_time]" class = "datePicker form-control" />'+
								'</div>'+
								'<div id="endTime' + addButtonCounter + '" class = "form-group col-sm-4">'+
								'<h4 style = "visibility:hidden;" class = "newEntryHeader'+ addButtonCounter +'" >New Entry # '+ addButtonCounter +'</h4>'+
								'<input value = "'+ time +'" type="text"  name="times['+ counter +'][end_time]" class = "datePicker form-control" />'+
								'</div>'+
								'<div class = "xBtn'+ addButtonCounter +'" class="form-group col-sm-4">'+
								'<h4 style = "visibility:hidden;" class = "newEntryHeader'+ addButtonCounter +'" >New Entry # '+ addButtonCounter +'</h4>'+
								'<button  style = "visibility:hidden;" value = "'+ addButtonCounter +'" class = "btn btn-danger">X</button>'+
								'</div>'+
								'</div>';

		    	$("#timePickerContainer").append(startTime);
		    	//$("#timePickerContainer").append(endTime);

		    	integrateDatePicker();
		    	$(document).scrollTop($(document).height());
		    	counter++;
		    });

		    $('.removeBtn').on('click',function(){
		    	counter--;

		    	$('#startTime'+ addButtonCounter).remove();
		    	$('#endTime'+ addButtonCounter).remove();
		    	$('.xBtn'+ addButtonCounter).remove();
		    	//$('.newEntryHeader'+ addButtonCounter).remove();
		    	addButtonCounter--;
		    	if (addButtonCounter <= 0) {
		    		$('.removeBtn').hide();
		    		$("#submitBtn").hide();
		    	}
		    });


		    $(".deleteBtn").on('click',function(){
		    	var deleteBtnData = $(this).data('id');

		    	$.ajax({
	                url: 'timeScheduler/' + deleteBtnData,
	                type: 'POST',
	                data: {
	                	"_token": "{{ csrf_token() }}",
	                	"_method": "DELETE"
	                },
	                success: function(result) {
	             		location.reload();
	                },
	                error: function(xhr, ajaxOptions, thrownError) {

	                }
	            });
		    });

		    $(".updateBtn").on('click',function(){
		    	var updateBtnData = $(this).data('id');
		    	var start_time = $("#start_time"+updateBtnData).val();
		    	var end_time = $("#end_time"+updateBtnData).val();

		    	var data = {
	                	"_token": "{{ csrf_token() }}",
	                	"_method": "PUT",
	                	"start_time": start_time,
	                	"end_time": end_time
	                };
		    	$.ajax({
	                url: 'timeScheduler/'+ updateBtnData ,
	                type: 'POST',
	                data: data,
	                success: function(result) {
	             		location.reload();
	                },
	                error: function(xhr, ajaxOptions, thrownError) {
	              
	                }
	            });
		    });

		    $('#updateUrl').click(function(){
		    	var urlInput = $("#urlInput").val();
		    	var videoStreamingUrl = '{"live_url": "'+ urlInput +'" }';
		    	console.log(videoStreamingUrl);
		    	sendMessage(videoStreamingUrl);
		    });

		    $('#fbLiveSwitcher').click(function(){
		    	var urlStorage = $('#urlStorage').val();
		    	var videoStreamingUrl = '{"live_url": "'+ urlStorage +'" }';
		    	//sendMessage(videoStreamingUrl);
		    	sendMessage("FBLIVE");

		    });
		    $('#dmsSwitcher').click(function(){
		    	sendMessage("DMS");
		    });



		    integrateDatePicker();
		});
		</script>