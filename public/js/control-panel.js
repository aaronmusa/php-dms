$(function() {
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
        var urlInput = $("#urlInput").val();
        var videoStreamingUrl = '{"live_url": "'+ urlInput +'" }';
        sendMessage(videoStreamingUrl);
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