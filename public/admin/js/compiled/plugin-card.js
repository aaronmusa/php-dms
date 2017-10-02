$(document).ready(function() {
	var withArticle = false;

	autosize(document.querySelectorAll('textarea'));
	$("#card-list").sortable({
		cursor: 'move',
		update: function(event, ui) {
			var postURL = $("#card-list").data('post-href') ;
			var _token = $('meta[name="csrf-token"]').attr('content');
			var orderList = $("#card-list").sortable('toArray');

			$.each(orderList, function(index, value){
				orderList[index] = value.replace('card-', '');
			});

			$.post(postURL, {data: orderList, _token: _token});
		}
	}).disableSelection();

	$(".btn-modal").click(function(){
		$('.page-loader-wrapper').show();
		var dataID = $(this).data('id');
		var url = $(this).data('action') +  dataID;
		var urlGet = $(this).data('get') + dataID;

		$("#edit-form-detail").trigger("reset");
		$("#edit-form-detail").attr('action', url);

		$.get(urlGet, {id: dataID}, function(jsonRes){
			var res = $.parseJSON(jsonRes);

			if (res.header.substring(res.header.indexOf('[') + 1, res.header.indexOf(':')) == "article") {
				withArticle = true;
				var articleID = res.header.substring(res.header.indexOf(':') + 1, res.header.indexOf(']'));

				$("#edit-header").closest('.form-group').addClass('hidden');
				$("#edit-description").closest('.form-group').addClass('hidden');
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
					$('#edit-file').prepend('<img src="'+ assetUrl + res.image +'" style="width:100%;height:auto;"/>');
				}else{
					$('#edit-file').find('a').remove();
					$('#edit-file').prepend('<a href="'+ assetUrl + res.image +'" target="_blank">View File</a>');
				}
			}

			if(res.video != ""){
				$('#edit-video').find('video').remove();
				$('#edit-video').prepend('<video controls src="'+ assetUrl + res.video+'" style="width:100%;height:auto;"></video>')
			}

			if(withArticle == false){
				$('.page-loader-wrapper').hide();
			}
		});

		$("#edit-detail-modal").modal('toggle');
	});

	$(".btn-header-modal").click(function() {
		var dataID = $(this).data('id');
		var url = $(this).data('action') +  dataID;
		var urlGet = $(this).data('get') + dataID;

		$("#edit-form-header").trigger("reset");
		$("#edit-form-header").attr('action', url);

		$.get(urlGet, {id: dataID}, function(jsonRes){
			var res = $.parseJSON(jsonRes);

			$("#header-edit-header").val(res.header);
			$("#header-edit-description").val(res.description);
			$("#header-edit-button-text").val(res.button_text);

			if (res.custom_link != "") {
				var customLink = $.parseJSON(res.custom_link);
				$("#header-edit-custom-link").val(customLink.link);
				$("#header-edit-custom-label").val(customLink.label);
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

	$('.date').inputmask('m/d/y', { placeholder: '__/__/____', alias: "date"});

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

})
