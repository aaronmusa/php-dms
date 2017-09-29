	<script type="text/javascript">
		$(function() {

			var addButtonCounter = 0;
			var counter = 0;

			//START WEBSOCKET
			//The homestead or local host server (don't forget the ws prefix)
			var host = 'ws://www.htechcorp.net:8080';
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

		window.setInterval(function(){ // Set interval for checking
			@foreach ($logs as $log)
				var startTime{{$log->id}} = "{{ $log->start_time }}";
				var timeString{{$log->id}} = startTime{{$log->id}}.split(":");
				var hour{{$log->id}} = timeString{{$log->id}}[0];
				var minutes{{$log->id}} = timeString{{$log->id}}[1];
				var seconds{{$log->id}} = timeString{{$log->id}}[2];
				var date{{$log->id}} = new Date(); // Create a Date object to find out what time it is
			    if(date{{$log->id}}.getHours() == hour{{$log->id}} && date{{$log->id}}.getMinutes() == minutes{{$log->id}} && date{{$log->id}}.getSeconds() == seconds{{$log->id}}){ // Check the time
			        sendMessage("FBLIVE");
			    }

			    var endTime{{$log->id}} = "{{ $log->end_time }}";
				var timeStringEnd{{$log->id}} = endTime{{$log->id}}.split(":");
				var endHour{{$log->id}} = timeStringEnd{{$log->id}}[0];
				var endMinutes{{$log->id}} = timeStringEnd{{$log->id}}[1];
				var endSeconds{{$log->id}} = timeStringEnd{{$log->id}}[2];
				var endDate{{$log->id}} = new Date(); // Create a Date object to find out what time it is
			    if(endDate{{$log->id}}.getHours() == endHour{{$log->id}} && endDate{{$log->id}}.getMinutes() == endMinutes{{$log->id}} && endDate{{$log->id}}.getSeconds() == endSeconds{{$log->id}}){ // Check the time
			        sendMessage("DMS");
			    }
			@endforeach
		}, 1000);

			function sendMessage(message) {
				socket.send(message);
			}
			//END WEBSOCKET
			

			


			function integrateDatePicker() {

			    $('.startTime').datetimepicker({

			        format: 'HH:mm:ss'

			    }); 
			    $('.endTime').datetimepicker({

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
		    					'<div id="startTime' + addButtonCounter + '" class="form-group col-sm-4">'+
		    					'<h4 class = "newEntryHeader'+ addButtonCounter +'" >New Entry # '+ addButtonCounter +'</h4>'+
								'<input value = "'+ time +'" type="text" name="times[][start_time]" class = "startTime form-control" />'+
								'</div>'+
								'<div id="endTime' + addButtonCounter + '" class = "form-group col-sm-4">'+
								'<h4 style = "visibility:hidden;" class = "newEntryHeader'+ addButtonCounter +'" >New Entry # '+ addButtonCounter +'</h4>'+
								'<input value = "'+ time +'" type="text"  name="times['+ counter +'][end_time]" class = "endTime form-control" />'+
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



		    integrateDatePicker();
		});
		</script>