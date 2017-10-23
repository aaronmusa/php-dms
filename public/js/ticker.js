$(function() {


	setCurrentTime();

	integrateDatePicker();

	var addButtonCounter = 0;
	var counter = 0;
	var tickerMessageArray = [];

	// $(".ticker_message").each(function() {
	//  		tickerMessageArray.push($(this).val());
	//  });

	// window.setInterval(function(){ 

	// 	$("label[for='time']").html(showTime())

			
	// 	$(".ticker_start_time").each(function(index, element) {
	// 		var message = tickerMessageArray[index];
	// 		var startTickerJson = '{"start_ticker":' + '"'+ message + '"' + '}';
	// 		sendDMSSwitcher(element, startTickerJson);
	// 	});

	// 	$(".ticker_end_time").each(function(index, element) {
	// 		sendDMSSwitcher(element, "END_TICKER");
	// 	});

	// 	if (this.connected == false) {
	// 		runWebsocket();
	// 	}

	// }, 1000);

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
		}).catch(swal.noop)	
    });

   $('#startTicker').click(function(){
   		var message = $('#tickerMessage').val();
   		var jsonMessage = '{"start_ticker":' + '"' + message + '"' + '}';
   		sendMessage(jsonMessage)
   		console.log(jsonMessage);
   });

   $('#endTicker').click(function(){
   		sendMessage("END_TICKER");
   });
    
});