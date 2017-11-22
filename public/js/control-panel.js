$(function() {


    integrateDatePicker();

    fetchTickers();
    fetchTimeLogs();
    reloadControlPanelView();


    window.setInterval(function(){

        //Check time logs and send to socket
        $.each(time_sequence, function(index,element){
            var startTime = JSON.stringify(element.start_time);
            var endTime = JSON.stringify(element.end_time);
            var name = JSON.stringify(element.name);
                name = name.replace(/\"/g, "");
            var socketId = JSON.stringify(element.socket_id);
                socketId = socketId.replace(/\"/g, "");
            if (name == 'to all'){
                sendDMSSwitcher(startTime, "FBLIVE");
                sendDMSSwitcher(endTime, "DMS");
            }
            else{
                sendDMSSwitcher(startTime, socketId+"%FBLIVE");
                sendDMSSwitcher(endTime, socketId+"%DMS");
            }
            
        });

        //Check tickers and send to socket
        $.each(tickers, function(index,element){
            var startTime = JSON.stringify(element.start_time);
            var message = JSON.stringify(element.message);
            var startTickerJson = '{"start_ticker":' + message + '}';
            sendDMSSwitcher(startTime, startTickerJson);


            var endTime = JSON.stringify(element.end_time);
            sendDMSSwitcher(endTime, "END_TICKER");
        });

        $("label[for='time']").html(showTime())

    }, 1000);

    function deleteEntry(url,deleteBtnData){
        var token = $("input[name=_token]").val();
        $.ajax({
            url:  url + deleteBtnData,
            type: 'POST',
            data: {
                "_token": token,
                "_method": "DELETE"
            },
            success: function(result) {
                if (result == 1) {
                    console.log("Deleted Successfully");              
                }else{
                    console.log(result.error);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
    }

    window.setInterval(function(){
        $(".time").each(function(){
            var scheduledTime = $(this).data("value");
            var id = $(this).data("id");
            var status = $(this).data("status");
            var type = $(this).data("type");
            var url;

            if (scheduledTime < showTime()){
                if (status == 2 && type == "Ticker"){
                    url = 'ticker/';
                    deleteEntry(url,id);
                }
              else if (status == 2 && type == "DMS"){
                    url = 'time-scheduler/';
                    deleteEntry(url,id);
                }
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

    $('#add_time_sequence_form').submit(function(e){
        e.preventDefault();
        var token = $("input[name=_token]").val();
        var startTime = $("#startTimeInput").val();
        var endTime = $("#endTimeInput").val();
        $.ajax({
            url: 'add-time-in-control-panel',
            type: 'POST',
            data: {
                "_token": token,
                "start_time":startTime,
                "end_time": endTime,
                "mac_address":"all"
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

    $('#add_ticker_form').submit(function(e){
        e.preventDefault();
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
                "end_time": endTime,
                "mac_address":"all"
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
        var message = $('#tickerInput').val();
        var jsonMessage = '{"start_ticker":' + '"' + message + '"' + '}';
        sendMessage(jsonMessage)
        console.log(jsonMessage);
   });

   $('#endTicker').click(function(){
        sendMessage("END_TICKER");
   });

   $('.setCurrentTime').click(function(){
        setCurrentTime();
        $('#tickerMessageInput').val($('#tickerInput').val());
   });
});