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

		    	var startTime = '<div class="col-sm-6">'+
								'<input type="text" id="startTime' + counter + '" name="times[][start_time]" class = "startTime form-control" />'+
								'</div>';
				var endTime =   '<div class = "col-sm-6">'+
								'<input type="text" id="endTime' + counter + '" name="times['+ addButtonCounter +'][end_time]" class = "endTime form-control" />'+
								'</div>';

		    	$(".datepickerContainer").append(startTime);
		    	$(".datepickerContainer").append(endTime);

		    	integrateDatePicker();

		    	addButtonCounter++;
		    });

		    integrateDatePicker();
		});
		</script>