$(function() {


	setCurrentTime();

	integrateDatePicker();
	var logs = $('#timeLogs').val();

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
	    				retrieveLogs();
	    				retrieveTickers();            		} 
            		else{
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
    $('#startBtn').click(function(){
    	sendMessage("START");
    });
    $('#stopBtn').click(function(){
    	sendMessage("STOP");
    });
    // $('#restartBtn').click(function(){
    // 	sendMessage("RESTART");
    // });

    
});