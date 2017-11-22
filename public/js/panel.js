$(document).ready(function(){

	integrateDatePicker();

	$('.setCurrentTime').click(function(){
		var tickerMessage =  $('#pcTickerMessage').val();
        setCurrentTime();
        $('#messageInput').val(tickerMessage);
   });
	

	$("#editPcName").on("click",function(){
		var pcName = $('#pcName').val();
		var livestreamUrl =  $('#pcUrl').val();
		var tickerMessage =  $('#pcTickerMessage').val();
		var pcMacAddress =  $('#pcMacAddress').val();
		$('#pcNameInput').val(pcName);
		$('#livestreamUrlInput').val(livestreamUrl);
		$('#tickerMessageInput').val(tickerMessage);
		$('#macAddressInput').val(pcMacAddress);
	});

	$('#editPcNameForm').submit(function(e){
		 e.preventDefault();
        var token = $("input[name=_token]").val();
        var pcNameInput = $("#pcNameInput").val();
        var macAddressInput = $('#macAddressInput').val();
        var livestreamUrlInput = $('#livestreamUrlInput').val();
        var tickerMessageInput = $('#tickerMessageInput').val();
        $.ajax({
            url: macAddressInput,
            type: 'POST',
            data: {
                "_token": token,
                "name": pcNameInput,
                "livestream_url": livestreamUrlInput,
                "ticker_message": tickerMessageInput,
                "_method": "PATCH"
            },
            success: function(result) {
                if (result == 1) {
                	var pcName = $('#pcName').val();
					var livestreamUrl =  $('#pcUrl').val();
					var tickerMessage =  $('#pcTickerMessage').val();
                	$('#editPcNameModal').modal('toggle');
                	$('#name').text(pcNameInput);
                	$('#url').text(livestreamUrlInput);
                	$('#tickerMessage').text(tickerMessageInput);
                	$('#pcName').val(pcNameInput);
                	$('#pcUrl').val(livestreamUrlInput);
					$('#pcTickerMessage').val(tickerMessageInput);
                    
                }else{
                    console.log("error");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
	});

	$('#add_time_sequence_form').submit(function(e){
        e.preventDefault();
        var token = $("input[name=_token]").val();
        var startTime = $("#startTimeInput").val();
        var endTime = $("#endTimeInput").val();
        var pcMacAddress =  $('#pcMacAddress').val();
        $.ajax({
            url: '../add-time-in-control-panel',
            type: 'POST',
            data: {
                "_token": token,
                "start_time":startTime,
                "end_time": endTime,
                "mac_address":pcMacAddress
            },
            success: function(result) {
                $('#addTimeSequenceModal').modal('toggle');
                $('#panelTableBody').append('<tr>'+
                							'<td align = "center">'+ startTime +'</td>'+
                							'<td align = "center">'+ endTime +'</td>'+
                							'</tr>');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
    });

    $('#add_ticker_form').submit(function(e){
        e.preventDefault();
        var token = $("input[name=_token]").val();
        var message = $("#messageInput").val();
        var startTime = $("#startTimeTickerInput").val();
        var endTime = $("#endTimeTickerInput").val();
        var pcMacAddress =  $('#pcMacAddress').val();
        $.ajax({
            url: '../add-ticker-in-control-panel',
            type: 'POST',
            data: {
                "_token": token,
                "message": message,
                "start_time":startTime,
                "end_time": endTime,
                "mac_address": pcMacAddress
            },
            success: function(result) {
                if (result == 1) {
                    $('#addTickerSequenceModal').modal('toggle');
                     $('#panelTableBody').append('<tr>'+
                							'<td align = "center">'+ startTime +'</td>'+
                							'<td align = "center">'+ endTime +'</td>'+
                							'<td align = "center">'+ message +'</td>'+
                							'</tr>');
                }else{
                    console.log("error");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
    });

    $('#fbLiveSwitcher').click(function(){
        var url = $('label#url').text();
        var socketId = $('#socketId').val();
        sendMessage(socketId + '%{"live_url": "'+ url +'" }');
        sendMessage(socketId + '%FBLIVE');
    });

    $('#dmsSwitcher').click(function(){
        var socketId = $('#socketId').val();
        sendMessage(socketId + "%DMS");
    });

    $('#startTicker').click(function(){
        var socketId = $('#socketId').val();
        var message = $('label#tickerMessage').text();
        var jsonMessage = '{"start_ticker":' + '"' + message + '"' + '}';
        sendMessage(socketId + '%' + jsonMessage)
        console.log(jsonMessage);
   });

   $('#endTicker').click(function(){
        var socketId = $('#socketId').val();
        sendMessage(socketId + "%END_TICKER");
   });
});