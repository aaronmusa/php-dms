	<script type="text/javascript">
		$(function() {

			var counter = 0;
			var addButtonCounter = 0;


			function integrateDatePicker() {
				$('.startTime').daterangepicker({
			        singleDatePicker: true,
			        timePicker: true,
			        showDropdowns: true,
			        locale: {
		        		format: 'HH:mm:ss'
		    		}
			    });

			    $('.endTime').daterangepicker({
			        singleDatePicker: true,
			        timePicker: true,
			        showDropdowns: true,
			        locale: {
		        		format: 'HH:mm:ss'
		    		}
			    });
			}

		    $(".addBtn").on('click',function(){
		    	counter++;

		    	var startTime = '<div class="form-group col-sm-4">'+
								'<input type="text" id="startTime' + counter + '" name="times[][start_time]" class = "startTime form-control" />'+
								'</div>';
				var endTime =   '<div class = "form-group col-sm-4">'+
								'<input type="text" id="endTime' + counter + '" name="times['+ addButtonCounter +'][end_time]" class = "endTime form-control" />'+
								'</div>'+
								'<div class="form-group col-sm-4">'+
								'<button value = "'+ addButtonCounter +'" class = "removeBtn btn btn-danger">X</button>'+
								'</div>';

		    	$(".datepickerContainer").append(startTime);
		    	$(".datepickerContainer").append(endTime);

		    	integrateDatePicker();
		    	$("#submitBtn").attr('style','visibility:visible;');
		    	addButtonCounter++;
		    });


		    $(".deleteBtn").on('click',function(){
		    	var deleteBtnData = $(this).data('id');

		    	$.ajax({
	                url: 'socket/' + deleteBtnData,
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
	                url: 'socket/'+ updateBtnData ,
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