$(function() {
	
	setCurrentTime();

	integrateDatePicker();

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