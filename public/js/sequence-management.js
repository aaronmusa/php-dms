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
			deleteTimeSequence(deleteBtn,deleteBtnData,token);
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