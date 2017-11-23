$(document).ready(function(){

reloadConnectionsTable();
	
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

$(document).on("click", ".editConnectionBtn",function(){
	var macAddress = $(this).data("value");
	location.href = "connections/"+macAddress;
});


		// $.each($('.pcName'),function(){
		// 	var pcName = $(this).text();
		// 	console.log(pcName);
		// 	$('#pcNameInput').val(pcName.replace('mode_edit',''));
		// });
		

});