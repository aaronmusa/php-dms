$(document).ready(function(){
	$("#connectionTable").on("click","td",function(){
		var pcName = $(this).text();
		var macAddress = $(this).closest("tr").find('td:eq(1)').text();
		$('#pcNameInput').val(pcName.replace('mode_edit',''));
		$('#macAddressInput').val(macAddress);
	});
$(document).on("click", ".stopBtn",function(){
	var socketId = $(this).data("value");
	sendMessage(socketId + '%STOP');
});

$(document).on("click", ".startBtn",function(){
	var socketId = $(this).data("value");
	sendMessage(socketId + '%START');
});

$(document).on("click", ".startFbliveBtn",function(){
	var socketId = $(this).data("value");
	sendMessage(socketId + '%FBLIVE');
});

$(document).on("click", ".startDmsBtn",function(){
	var socketId = $(this).data("value");
	sendMessage(socketId + '%DMS');
});


		// $.each($('.pcName'),function(){
		// 	var pcName = $(this).text();
		// 	console.log(pcName);
		// 	$('#pcNameInput').val(pcName.replace('mode_edit',''));
		// });
		

	$('#editPcNameForm').submit(function(e){
		 e.preventDefault();
	        var token = $("input[name=_token]").val();
	        var pcNameInput = $("#pcNameInput").val();
	        var macAddressInput = $('#macAddressInput').val();
	        $.ajax({
	            url: 'connections/'+ macAddressInput,
	            type: 'POST',
	            data: {
	                "_token": token,
	                "name": pcNameInput,
	                "_method": "PATCH"
	            },
	            success: function(result) {
	                if (result == 1) {
	                	$('#editPcNameModal').modal('toggle');
	                    reloadConnectionsTable();
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