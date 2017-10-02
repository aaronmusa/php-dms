$(document).ready(function(){
	/* Sortable Menu */
	$( ".sortable-menu,.sortable-submenu" ).sortable({
		connectWith: '.sortable-menu,.sortable-submenu',
		start: function( event, ui ) {
            clone = $(ui.item[0].outerHTML).clone();
        },
        placeholder: {
            element: function(clone, ui) {
                return $('<li class="selected">'+clone[0].innerHTML+'</li>');
            },
            update: function() {
                return;
            }
        },
		stop: function(event, ui) {

			if (ui.item.closest('.sortable-submenu').length > 0) {
				if (ui.item.data('menu-type') == "category") {
					$(this).sortable("cancel");
				}
				ui.item.find('.sortable-submenu').sortable("disable");
				ui.item.find('.clearfix').remove();
			}
			else {
				var clearfixDiv = "<div class='clearfix'></div>";
				ui.item.find('list-group-item').after(clearfixDiv);
				ui.item.find('.sortable-submenu').sortable("enable");
			}

		},
	}).disableSelection();

	/* Saving Menu */
	$("#btn-save-menu").click(function(){
		$( "#sortable" ).nestedSortable({
			'handle': 'div',
			items: 'li',
			toleranceElement: '> div', 
			maxLevels : 2, 
			listType: 'ul'
		});
		var postURL = $(this).data('post-url'),
			postData = $("#sortable").nestedSortable('toArray');

			$.each(postData, function(index, obj){
				obj.name    = $("#menu-" + obj.item_id).data('menu-name');
				obj.link    = $("#menu-" + obj.item_id).data('menu-link');
				obj.slug    = $("#menu-" + obj.item_id).data('menu-slug');
				obj.type    = $("#menu-" + obj.item_id).data('menu-type');
				obj.menu_id = $("#menu-" + obj.item_id).data('menu-id');
			});

		$.post(postURL, { data: postData }, function(jsonRes){
			var result = $.parseJSON(jsonRes);

			if (!result.status) {
				swal("Failed", result.message, "error");
			}

			swal({
                title: 'Successfull!',
                text: 'Successfull!',
                type: 'success'
            }, function() {
                location.reload();
            });
		});
	})

	/* Adding Custom link in the Menu List */
	$("#btn-add-link").click(function(){
		var title = $(this).parent().find(".menu-name").val();
		var slug = convertToSlug(title);
		var url = $(this).parent().find(".menu-link").val();
		var id = getRandomInt();
		var newMenu = "";

		newMenu +='<li id="menu-'+ id + '" data-menu-id="" data-menu-name="' + title +'" data-menu-link="' + url +'" data-menu-type="link" data-menu-slug="' + slug +'" class="list-items" >';
		newMenu +=	'<div  class="list-group-item">';
		newMenu +=		'<span class="active-menu-name">' + title +'</span>';
		newMenu +=		'<span style="float: right;" class="expand-collapse" data-toggle="collapse" data-target="#collapse-' + id + '" data-controls="collapse-' + id + '" aria-expanded="true"><i class="material-icons">more_vert</i></span>';
		newMenu +=	'</div>';
		newMenu +=	'<div class="clearfix"></div>';
		newMenu +=	'<div class="collapse list-group-info" id="collapse-' + id + '" aria-expanded="false" role="tabpanel">';
		newMenu +=		'<label for="edit-menu">URL</label>';
		newMenu +=		'<div class="form-group">';
		newMenu +=			'<div class="form-line ">';
		newMenu +=				'<input type="text" name="edit-url" class="form-control menu-url" placeholder="Page URL" value="' + url + '">';
		newMenu +=			'</div>';
		newMenu +=		'</div>';
		newMenu +=		'<label for="edit-menu">Menu Name</label>';
		newMenu +=		'<div class="form-group">';
		newMenu +=			'<div class="form-line ">';
		newMenu +=				'<input type="text" name="edit-menu" class="form-control menu-name" placeholder="Page Title" value="' + title + '">';
		newMenu +=			'</div>';
		newMenu +=		'</div>';
		newMenu +=		'<div class="form-group">';
		newMenu +=			'<a href="javascript:void(0)" class="remove-menu">Remove</a>';
		newMenu +=			'<span> | </span>';
		newMenu +=			'<a href="javascript:void(0)" data-toggle="collapse" data-target="#collapse-' + id + '" data-controls="collapse-' + id + '" aria-expanded="true">Cancel</a>';
		newMenu +=		'</div>';
		newMenu +=	'</div>';
		newMenu +=	'<ul class="list-group sortable sortable-submenu">';
		newMenu +=	'</ul>';
		newMenu += '</li>';
		$(newMenu).appendTo("#sortable");

		$(this).parent().find(".menu-name").val('');
		$(this).parent().find(".menu-link").val('http://');

		$( ".sortable-menu,.sortable-submenu" ).sortable({
			connectWith: '.sortable-menu,.sortable-submenu',
			start: function( event, ui ) {
	            clone = $(ui.item[0].outerHTML).clone();
	        },
	        placeholder: {
	            element: function(clone, ui) {
	                return $('<li class="selected">'+clone[0].innerHTML+'</li>');
	            },
	            update: function() {
	                return;
	            }
	        },
			stop: function(event, ui) {
				if (ui.item.closest('.sortable-submenu').length > 0) {
					if (ui.item.data('menu-type') == "category") {
						$(this).sortable("cancel");
					}
					ui.item.find('.sortable-submenu').sortable("disable");
					ui.item.find('.clearfix').remove();
				}
				else {
					var clearfixDiv = "<div class='clearfix'></div>";
					ui.item.find('list-group-item').after(clearfixDiv);
					ui.item.find('.sortable-submenu').sortable("enable");
				}
			},
		}).disableSelection();
		
	});

	$("#link-url").keydown(function(e) {
	    var oldvalue=$(this).val();
	    var field=this;
	    setTimeout(function () {
	        if(field.value.indexOf('http://') !== 0) {
	            $(field).val(oldvalue);
	        } 
	    }, 1);
	});

	$(".btn-add-list").click(function(){
		var menuItems = $(this).parent().find(".menu-items:checkbox:checked");
		var newMenu = "";
		var title = "";
		var slug = "";
		var type = "";
		var menuID = "";
		var id = 0;
		$.each(menuItems, function(key, obj){
			title = obj.getAttribute('data-menu-name');
			slug = obj.getAttribute('data-menu-slug');
			type = obj.getAttribute('data-menu-type');
			menuID = obj.getAttribute('data-menu-id');
			id = getRandomInt();

			if (type == "category") {
				slug = 'category/' + slug;
			}

			newMenu +='<li id="menu-'+ id + '" data-menu-name="' + title +'" data-menu-slug="' + slug + '" data-menu-id="' + menuID + '" data-menu-type="' + type +'" data-menu-link=""  class="list-items" >';
			newMenu +=	'<div class="list-group-item">';
			newMenu +=		'<span class="active-menu-name">' + title +'</span>';
			newMenu +=		'<span style="float: right;" class="expand-collapse" data-toggle="collapse" data-target="#collapse-' + id + '" data-controls="collapse-' + id + '" aria-expanded="true"><i class="material-icons">more_vert</i></span>';
			newMenu +=	'</div>';
			newMenu +=	'<div class="clearfix"></div>';
			newMenu +=	'<div class="collapse list-group-info" id="collapse-' + id + '" aria-expanded="false" role="tabpanel">';
			newMenu +=		'<label for="edit-menu">Menu Name</label>';
			newMenu +=		'<div class="form-group">';
			newMenu +=			'<div class="form-line ">';
			newMenu +=				'<input type="text" name="edit-menu" class="form-control menu-name" placeholder="Page Title" value="' + title + '">';
			newMenu +=			'</div>';
			newMenu +=		'</div>';
			newMenu +=		'<div class="form-group">';
			newMenu +=			'<a href="javascript:void(0)" class="remove-menu">Remove</a>';
			newMenu +=			'<span> | </span>';
			newMenu +=			'<a href="javascript:void(0)" data-toggle="collapse" data-target="#collapse-' + id + '" data-controls="collapse-' + id + '" aria-expanded="true">Cancel</a>';
			newMenu +=		'</div>';
			newMenu +=	'</div>';
			newMenu +=	'<ul class="list-group sortable sortable-submenu"></ul>';
			newMenu += '</li>';
			
			$(this).parent().remove();
		})
		
		$(newMenu).appendTo("#sortable");
		$(this).parent().find(".menu-items:checkbox").prop('checked', false);

		$( ".sortable-menu,.sortable-submenu" ).sortable({
			connectWith: '.sortable-menu,.sortable-submenu',
			start: function( event, ui ) {
	            clone = $(ui.item[0].outerHTML).clone();
	        },
	        placeholder: {
	            element: function(clone, ui) {
	                return $('<li class="selected">'+clone[0].innerHTML+'</li>');
	            },
	            update: function() {
	                return;
	            }
	        },
			stop: function(event, ui) {
				if (ui.item.closest('.sortable-submenu').length > 0) {
					if (ui.item.data('menu-type') == "category") {
						$(this).sortable("cancel");
					}
					ui.item.find('.sortable-submenu').sortable("disable");
					ui.item.find('.clearfix').remove();
				}
				else {
					var clearfixDiv = "<div class='clearfix'></div>";
					ui.item.find('list-group-item').after(clearfixDiv);
					ui.item.find('.sortable-submenu').sortable("enable");
				}
			},
		}).disableSelection();
	});

	$(document).on('keyup', ".menu-name", function(){
		var changeMenuName =  $(this).val();
		var currentMenuName = $(this).closest('.list-items').find('.active-menu-name:first');
		$(this).closest('.list-items').attr('data-menu-name', changeMenuName);
		currentMenuName.html(changeMenuName);
	});

	$(document).on('click', '.remove-menu', function(){
		$(this).closest('.list-items').remove();
	});

	$(document).on('keyup', ".menu-url", function(){
		var changeMenuURL =  $(this).val();
		$(this).closest('.list-items').attr('data-menu-link', changeMenuURL);
	});

})

function getRandomInt() {
	min = Math.ceil(900000);
	max = Math.floor(999999);
	return Math.floor(Math.random() * (max - min)) + min;
}

function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-')
        ;
}