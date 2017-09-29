	<script type="text/javascript">
		$(function() {

			var addButtonCounter = 0;
			var counter = 0;


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
		    	var startTime = '<div class = "col-lg-9">'+
		    					'<div id="startTime' + addButtonCounter + '" class="form-group col-sm-4">'+
		    					'<h4 id = "newEntryHeader'+ addButtonCounter +'" >New Entry # '+ addButtonCounter +'</h4>'+
								'<input value = "'+ time +'" type="text" name="times[][start_time]" class = "startTime form-control" />'+
								'</div>'+
								'<div id="endTime' + addButtonCounter + '" class = "form-group col-sm-4">'+
								'<h4 style = "visibility:hidden;" id = "newEntryHeader'+ addButtonCounter +'" >New Entry # '+ addButtonCounter +'</h4>'+
								'<input value = "'+ time +'" type="text"  name="times['+ counter +'][end_time]" class = "endTime form-control" />'+
								'</div>'+
								'<div id = "xBtn'+ addButtonCounter +'" class="form-group col-sm-4">'+
								'<h4 style = "visibility:hidden;" id = "newEntryHeader'+ addButtonCounter +'" >New Entry # '+ addButtonCounter +'</h4>'+
								'<button  style = "visibility:hidden;" value = "'+ addButtonCounter +'" class = "btn btn-danger">X</button>'+
								'</div>'+
								'</div>';

		    	$("#timePickerContainer").append(startTime);
		    	//$("#timePickerContainer").append(endTime);

		    	integrateDatePicker();
		    	
		    	counter++;
		    });

		    $('.removeBtn').on('click',function(){
		    	counter--;
		    	$('#startTime'+ addButtonCounter).remove();
		    	$('#endTime'+ addButtonCounter).remove();
		    	$('#xBtn'+ addButtonCounter).remove();
		    	$('#newEntryHeader'+ addButtonCounter).remove();
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
		    	var start_time = $("#startTime"+updateBtnData).val();
		    	var end_time = $("#endTime"+updateBtnData).val();

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