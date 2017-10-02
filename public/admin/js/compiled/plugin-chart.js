$(document).ready(function() {
	new Morris.Bar({
	  // ID of the element in which to draw the chart.
	  element: 'myfirstchart',
	  // Chart data records -- each entry in this array corresponds to a point on
	  // the chart.
	  data: $('#my-data').data('chart'),
	  // The name of the data record attribute that contains x-values.
	  xkey: 'year',
	  // A list of names of data record attributes that contain y-values.
	  ykeys: ['value'],
	  // Labels for the ykeys -- will be displayed when you hover over the
	  // chart.
	  labels: ['value']
	});

	$("#btn-edit").click(function() {
		var dataID = $(this).data('id');
		var urlGet = $(this).data('get') + dataID;

		$("#edit-form-detail").trigger("reset");
		$.get(urlGet, {id: dataID}, function(jsonRes){
			var res = $.parseJSON(jsonRes);

			$("#edit-header").val(res.header);
			$("#edit-description").val(res.description);

			if (res.custom_link != "") {
				var customLink = $.parseJSON(res.custom_link);

				$("#edit-custom-link").val(customLink.link);
				$("#edit-custom-label").val(customLink.label);
			}
			
		});

		$("#edit-detail-modal").modal('toggle');
	})
	var copyShortCode = new Clipboard('#copyshortcode');
	copyShortCode.on('success', function(e) {
	    e.clearSelection();
	    // console.info('Action:', e.action);
	    // console.info('Text:', e.text);
	    // console.info('Trigger:', e.trigger);
	    $('#copyshortcode').tooltip({
	    	title : "Copied!",
	    	delay : 0,
	    	hide  : 1000,
	    	placement : "right",
	    });
	    $('#copyshortcode').tooltip('show');
	});
	/*
	copyShortCode.on('error', function(e) {
	    console.error('Action:', e.action);
	    console.error('Trigger:', e.trigger);
	    // showTooltip(e.trigger, fallbackMessage(e.action));
	});*/
})