$(document).ready(function(){
	$("#connectionTable").on("click","td",function(){
		var pcName = $(this).text();
		$('#pcNameInput').val(pcName.replace('mode_edit',''));
	});

		// $.each($('.pcName'),function(){
		// 	var pcName = $(this).text();
		// 	console.log(pcName);
		// 	$('#pcNameInput').val(pcName.replace('mode_edit',''));
		// });
		

	$('#editPcName').click(function(e){
		 e.preventDefault();
	        var token = $("input[name=_token]").val();
	        var pcNameInput = $("#pcNameInput").val();
	        $.ajax({
	            url: 'connecti',
	            type: 'POST',
	            data: {
	                "_token": token,
	                "message": message,
	                "start_time":startTime,
	                "end_time": endTime
	            },
	            success: function(result) {
	                if (result == 1) {
	                    $('#addTickerSequenceModal').modal('toggle');
	                    reloadControlPanelView();
	                    fetchTickers();
	                    fetchTimeLogs();
	                }else{
	                    console.log("error");
	                }
	            },
	            error: function(xhr, ajaxOptions, thrownError) {
	                console.log(thrownError);
	            }
	        });
	});
});