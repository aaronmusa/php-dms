var copyShortCode = new Clipboard('.copyshortcode');
copyShortCode.on('success', function(e) {
    e.clearSelection();
    $(e.trigger).tooltip({
        title : "Copied!",
        delay : 0,
        hide  : 3000,
        placement : "left",
    });
    $(e.trigger).tooltip('show');
});