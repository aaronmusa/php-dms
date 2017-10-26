$(function() {

    setCurrentTime();

    integrateDatePicker();

    window.setInterval(function(){
        $(".time").each(function(){
            var scheduledTime = $(this).data("value");
            if (scheduledTime < showTime()){
                $(this).parents('tr')[0].remove();
            }
        });
    },1000);

    $('#fbLiveSwitcher').click(function(){
        var urlStorage = $('#urlStorage').val();
        sendMessage("FBLIVE");
    });

    $('#dmsSwitcher').click(function(){
        sendMessage("DMS");
    });

    $('#updateUrl').click(function(){
        var token = $("input[name=_token]").val();
        var urlInput = $("#urlInput").val();
        var videoStreamingUrl = '{"live_url": "'+ urlInput +'" }';
        sendMessage(videoStreamingUrl);
        $.ajax({
            url: 'video-streaming-url',
            type: 'POST',
            data: {
                "_token": token,
                "videoStreamingUrl":urlInput
            },
            success: function(result) {
                if (result == 1) {
                    console.log("URL Updated");   
                }else{
                    console.log("error");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
    });

        $('#updateTickerMessage').click(function(){
        var token = $("input[name=_token]").val();
        var tickerInput = $("#tickerInput").val();
        $.ajax({
            url: 'ticker-message',
            type: 'POST',
            data: {
                "_token": token,
                "tickerInput":tickerInput
            },
            success: function(result) {
                if (result == 1) {
                    console.log("Ticker message Updated");   
                }else{
                    console.log("error");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
    });

    $('#addEntry').click(function(){
        var token = $("input[name=_token]").val();
        var startTime = $("#startTimeInput").val();
        var endTime = $("#endTimeInput").val();
        $.ajax({
            url: 'add-time-in-control-panel',
            type: 'POST',
            data: {
                "_token": token,
                "start_time":startTime,
                "end_time": endTime
            },
            success: function(result) {
                if (result == 1) {
                    $('#addTimeSequenceModal').modal('toggle');
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

    $('#addTickerModal').click(function(){
        var token = $("input[name=_token]").val();
        var message = $("#tickerMessageInput").val();
        var startTime = $("#startTimeTickerInput").val();
        var endTime = $("#endTimeTickerInput").val();
        $.ajax({
            url: 'add-ticker-in-control-panel',
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



    $('#startBtn').click(function(){
        sendMessage("START");
    });
    $('#stopBtn').click(function(){
        sendMessage("STOP");
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