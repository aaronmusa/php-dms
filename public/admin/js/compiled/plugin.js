$(document).ready(function() {
	// try{
	// 	$('.date').inputmask('m/d/y', { placeholder: '__/__/____', alias: "date"});
	// }catch(e){

	// }


	var withArticle    = false;
	var selector       = $('#card-list');
	var selectorPrefix = 'card-';

	if(selector.length == 0){
		selector       = $('#list-view');
		selectorPrefix = 'list-';
	}

	autosize(document.querySelectorAll('textarea'));
	selector.sortable({
		cursor: 'move',
		update: function(event, ui) {
			if(selectorPrefix == 'list-'){
				$('.order').each(function(i, e){
					var value = (i + 1) +'.';
					$(this).html(value);
				});
			}
			var postURL = selector.data('post-href') ;
			var _token = $('meta[name="csrf-token"]').attr('content');
			var orderList = selector.sortable('toArray');
			$.each(orderList, function(index, value){
				orderList[index] = value.replace(selectorPrefix, '');
			});
			$.post(postURL, {data: orderList, _token: _token});
		}
	}).disableSelection();

	$(".chart-modal").click(function() {
		$('.page-loader-wrapper').show();
		var dataID = $(this).data('id');
		var url = $(this).data('action') +  dataID;
		var urlGet = $(this).data('get') + dataID;
		var chartContainer = document.getElementById('chart-data');

		$.get(urlGet, {id: dataID}, function(jsonRes){
			var data = $.parseJSON(jsonRes);

			var chartValue = [];
			var labels = [];
			var colors = [];
			var chartData = $.parseJSON(data.values);

			$.each(chartData, function(index, value){
				chartValue.push(value.y_label);
				labels.push(value.x_label);
				colors.push('#00b0e4');
			});

			var chartView = new Chart(chartContainer, {
				type: 'bar',
				data: {
					labels: labels,
					datasets: [{
						label: data.description,
						data: chartValue,
						backgroundColor: colors,
		                borderColor: colors,
		                borderWidth: 1
					}]
				},
				options: {
		            scales: {
		                yAxes: [{
		                    ticks: {
		                        beginAtZero: true
		                    }
		                }]
		            }
		        }
			});

		});

		$('.page-loader-wrapper').hide();
		$("#view-chart-modal").modal('toggle');
	});

	$('#view-chart-modal').on('hidden.bs.modal', function () {
		chartView.destroy();
	});

	$(".btn-modal").click(function(){
		$('.page-loader-wrapper').show();
		var dataID = $(this).data('id');
		var url = $(this).data('action') +  dataID;
		var urlGet = $(this).data('get') + dataID;
		var target = $(this).data('target');

		$("#edit-form-detail").trigger("reset");
		$("#edit-form-detail").attr('action', url);

		$.get(urlGet, {id: dataID}, function(jsonRes){
			var res = $.parseJSON(jsonRes);
			if (res.header.substring(res.header.indexOf('[') + 1, res.header.indexOf(':')) == "article") {
				withArticle = true;
				var articleID = res.header.substring(res.header.indexOf(':') + 1, res.header.indexOf(']'));

				$("#edit-header").closest('.form-group').addClass('hidden');
				$("#edit-description").closest('.form-group').addClass('hidden');
				$("#edit-image").closest('.form-group').addClass('hidden');

				var articleURL = $("#article-href").val();
				var result = "";
				$.get(articleURL, {id: articleID}, function(jsonRes) {
					result = $.parseJSON(jsonRes);
					$("#edit-article").val(result.slug);
					$.each($("#edit-article option"), function(index, value) {
						if (value.value == result.slug) {
							$(this)[0].setAttribute('selected', 'selected');
							$("#edit-article").trigger('change');
						}
					});
				});
			}

			$("#edit-header").val(res.header);
			$("#edit-description").val(res.description);
			$("#edit-group").val(res.group);
			$("#edit-button-text").val(res.button_text);

			if (res.custom_link != "") {
				var customLink = $.parseJSON(res.custom_link);
				$("#edit-custom-link").val(customLink.link);
				$("#edit-custom-label").val(customLink.label);
			}

			if(res.image != ""){
				var ext = res.image.substr(res.image.lastIndexOf('.') + 1);
				ext = ext.toLowerCase();
				if(ext == "jpg" ||
				 	ext == "jpeg" ||
				 	ext == "png" ||
			 	 	ext == "gif"){
					$('#edit-file').find('img').remove();
					$('#edit-file').prepend('<img src="'+ assetUrl.replace('index.php', '') + res.image +'" style="width:100%;height:auto;"/>');
				}else{
					$('#edit-file').find('a').remove();
					$('#edit-file').prepend('<a href="'+ assetUrl.replace('index.php', '') + res.image +'" target="_blank">View File</a>');
				}
			}else{
				$('#edit-file').find('img').remove();
				$('#edit-file').find('a').remove();
			}

			if(res.video != ""){
				$('#edit-video').find('video').remove();
				$('#edit-video').prepend('<video controls src="'+ assetUrl.replace('index.php', '') + res.video+'" style="width:100%;height:auto;"></video>')
			}

			if(res.new_date != ""){
				$("#edit-date").val(res.new_date);
			}

			if(res.item_link != ""){
				$("#edit-item-link").val(res.item_link);
			}

			if(withArticle == false){
				$('.page-loader-wrapper').hide();
			}
		});

		$("#" + target).modal('toggle');
	});

	$(".btn-header-modal").click(function() {
		var dataID = $(this).data('id');
		var url = $(this).data('action') +  dataID;
		var urlGet = $(this).data('get') + dataID;

		$("form#edit-form-header").attr('action', url).trigger('reset');

		$.get(urlGet, {id: dataID}, function(jsonRes){
			var res = $.parseJSON(jsonRes);

			$("#header-edit-header").val(res.header);
			$("#header-edit-description").val(res.description);
			$("#header-edit-button-text").val(res.button_text);

			if (res.custom_link != "") {
				var customLink = $.parseJSON(res.custom_link);
				$("#header-edit-custom_link").val(customLink.link);
				$("#header-edit-custom_label").val(customLink.label);
			}

			if(res.image != ""){
				var ext = res.image.substr(res.image.lastIndexOf('.') + 1);
				ext = ext.toLowerCase();
				if(ext == "jpg" ||
				 	ext == "jpeg" ||
				 	ext == "png" ||
			 	 	ext == "gif"){
					$('#header-edit-file').find('img').remove();
					$('#header-edit-file').prepend('<img src="'+ assetUrl.replace('index.php', '') + res.image +'" style="width:100%;height:auto;"/>');
				}else{
					$('#header-edit-file').find('a').remove();
					$('#header-edit-file').prepend('<a href="'+ assetUrl.replace('index.php', '') + res.image +'" target="_blank">View File</a>');
				}
			}else{
				$('#header-edit-file').find('img').remove();
				$('#header-edit-file').find('a').remove();
			}

			$.each($("#edit-orientation option"), function(index, option) {
				$(this).removeAttr('selected');
				if (option.value == res.orientation) {
					$(this).prop('selected', 'selected');
					$("#edit-orientation").trigger('change');
				}
			});
		});
	});

	$("#article").change(function() {
		if($('.page-loader-wrapper').css('display') == 'none'){
			$('.page-loader-wrapper').show();
		}
		var articleSlug = $(this).val();
		var url = $("#article-href").val();

		if (articleSlug == "") {
			if ($("#header").closest('.form-group').hasClass('hidden')) {
				$("#header").closest('.form-group').removeClass('hidden');
				$("#header").val('');
				$("#header").attr('required');
				$("#header").removeAttr('disabled');
			}

			if ($("#description").closest('.form-group').hasClass('hidden')) {
				$("#description").closest('.form-group').removeClass('hidden');
				$("#description").val('');
				$("#header").attr('required');
				$("#header").removeAttr('disabled');
			}

			if ($("#image").closest('.form-group').hasClass('hidden')) {
				$("#image").closest('.form-group').removeClass('hidden');
				$("#image").val('');
				$("#image").attr('required');
			}

			$("#custom_link").val('');
			$("#custom_label").val('');
			$('.page-loader-wrapper').hide();
			return false;
		}

		$("#header").closest('.form-group').addClass('hidden');
		$("#description").closest('.form-group').addClass('hidden');
		$("#image").closest('.form-group').addClass('hidden');

		$.get(url, {slug: articleSlug}, function(jsonRes) {
			var result = $.parseJSON(jsonRes);

			$("#header").val(result.title);
			$("#header").attr('disabled', 'true');

			$("#description").val(result.content.replace(/(<([^>]+)>)/ig,""));
			$("#description").attr('disabled', 'true');

			$("#image").removeAttr('required');

			$("#custom_link").val('http://' + window.location.hostname + '/articles/' + articleSlug);
			$("#custom_label").val("Read More");
			$('.page-loader-wrapper').hide();
		});
	});

	$("#edit-article").change(function() {
		if($('.page-loader-wrapper').css('display') == 'none'){
			$('.page-loader-wrapper').show();
		}
		var articleSlug = $(this).val();
		var url = $("#article-href").val();

		if (articleSlug == "") {
			if ($("#edit-header").closest('.form-group').hasClass('hidden')) {
				$("#edit-header").closest('.form-group').removeClass('hidden');
				$("#edit-header").val('');
				$("#edit-header").attr('required');
				$("#edit-header").removeAttr('disabled');
			}

			if ($("#edit-description").closest('.form-group').hasClass('hidden')) {
				$("#edit-description").closest('.form-group').removeClass('hidden');
				$("#edit-description").val('');
				$("#edit-description").attr('required');
				$("#edit-description").removeAttr('disabled');
			}

			if ($("#edit-image").closest('.form-group').hasClass('hidden')) {
				$("#edit-image").closest('.form-group').removeClass('hidden');
				$("#edit-image").val('');
				$("#edit-image").attr('required');
			}

			$("#edit-custom-link").val('');
			$("#edit-custom-label").val('');
			$('.page-loader-wrapper').hide();
			return false;
		}

		$("#edit-header").closest('.form-group').addClass('hidden');
		$("#edit-description").closest('.form-group').addClass('hidden');
		$("#edit-image").closest('.form-group').addClass('hidden');

		$.get(url, {slug: articleSlug}, function(jsonRes) {
			var result = $.parseJSON(jsonRes);

			$("#edit-header").val(result.title);
			$("#edit-header").attr('disabled', 'true');

			$("#edit-description").val(result.content.replace(/(<([^>]+)>)/ig,""));
			$("#edit-description").attr('disabled', 'true');

			$("#edit-image").removeAttr('required');

			$("#edit-custom_link").val(window.location.hostname + '/articles/' + articleSlug);
			$("#edit-custom_label").val("Read More");
			withArticle = false;
			$('.page-loader-wrapper').hide();
		});
	});

	var copyShortCode = new Clipboard('#copyshortcode');
	copyShortCode.on('success', function(e) {
	    e.clearSelection();
	    $('#copyshortcode').tooltip({
	    	title : "Copied!",
	    	delay : 0,
	    	hide  : 1000,
	    	placement : "right",
	    });
	    $('#copyshortcode').tooltip('show');
	});
});
