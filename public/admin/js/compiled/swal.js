		$('.swal').click(function(){
			if($(this).data('type') !== undefined){
				Action.init($(this));
			}
		});

		var Action = {
		    init: function(elem) {
		        switch (elem.data('type')) {
		            case "prompt":
		                Action.prompt(elem);
		                break;
		            case "confirm":
		                Action.confirm(elem);
		                break;
		        }
		    },
		    prompt: function(elem) {
		        swal({
		            title: elem.data('title'),
		            text: elem.data('text'),
		            inputPlaceholder: elem.data('placeholder'),
		            inputValue: elem.data('input'),
		            type: "input",
		            showCancelButton: true,
		            closeOnConfirm: false,
		            animation: "slide-from-top",
		            showCancelButton: true,
		            closeOnConfirm: false,
		            showLoaderOnConfirm: true
		        }, function(inputValue) {
		            if (inputValue === false) return false;
		            if (inputValue === "") {
		                swal.showInputError("You need to write something!");
		                return false
		            }

		            if (elem.data('ajax') === true) {
		                var postData = {
		                    data: inputValue,
		                    module: elem.data('module'),
		                    options: elem.data('options')
		                };
		                Action.sendAjax(elem, postData);
		            }
		        });
		    },
		    confirm: function(elem) {
		        swal({
		                title: elem.data('title'),
		                text: elem.data('text'),
		                type: "warning",
		                showCancelButton: true,
		                confirmButtonColor: "#DD6B55",
		                confirmButtonText: "Yes, delete it!",
		                cancelButtonText: "No, cancel pls!",
		                closeOnConfirm: false,
		                closeOnCancel: false,
		                showLoaderOnConfirm: true
		            },
		            function(isConfirm) {
		                if (isConfirm) {
		                    if (elem.data('ajax') === true) {
	                            Action.sendAjax(elem, {
	                                module: elem.data('module')
	                            });
		                    }else{
		                    	Action.resource(elem, {
	                                id: elem.data('module')
	                            });
		                    }
		                } else {
		                    swal("Cancelled", "", "error");
		                }
		            });
		    },
		    sendAjax: function(elem, postData, callback) {
		        postData._token = $('meta[name="csrf-token"]').attr('content');
		        postData._method = elem.data('method');

	            $.ajax({
	                type: elem.data('method'),
	                url: baseUrl + elem.data('url'),
	                data: postData,
	                dataType: 'json',
	                success: function(response) {
	                	if(response.status){
	                		var options = {
		                        title: 'Success!',
		                        text: response.message,
		                        type: 'success'
		                    };
	                	}else{
	                		var options = {
		                        title: 'Oops!',
		                        text: response.message,
		                        type: 'error'
		                    };
	                	}

	                    swal(options, function() {
	                        if(elem.data("resource-route")){
	                        	if(response.status && response.data){
		                       		Action.resource(elem,response.data);
		                       	}else{
		                       		var data = {
		                       			id : elem.data("module")
		                       		};
		                       		Action.resource(elem,data);
		                       	}
	                        }else{	
		                        if(elem.data('reload') === undefined){
		                        	if(elem.data('redirect') === undefined){
		                        		location.reload();
		                        	}else{
		                        		location.href = elem.data('redirect');
		                        	}
		                        }
	                        }
	                       	
	                        callback();
	                    });
	                },
	                error: function(xhr, textStatus, errorThrown) {
	                	if(xhr.status == 500){
	                		swal({
	                		    title: 'Oops!',
	                		    text: 'Something is wrong with the server right now. Please try again later',
	                		    type: 'error'
	                		}, function() {
	                			if(elem.data('reload') === undefined){
	                				if(elem.data('redirect') === undefined){
	                					location.reload();
	                				}else{
	                					location.href = elem.data('redirect');
	                				}
	                			}
	                		});
	                	}else{
	                		var errors = JSON.parse(xhr.responseText);
	                		var html = "<ul class='text-left'>";
	                		$.each(errors, function(index, val) {
                                $(val).each(function(i, message) {
                                    html += "<li>" + message + "</li>";
                                });
                            });
	                		html += "</ul>";
	                		swal({
	                		    title: "Oops!",
	                		    text: html,
	                		    html: true
	                		});
	                	}
	                }
	            });
		    },
            resource: function(elem,data){
            	var resourceRoute = elem.data("resource-route");
            	var resourceAction = elem.data("resource-action");
            	var actions = {
            		index 	: resourceRoute,
            		create 	: resourceRoute + "/create",
            		show 	: resourceRoute + "/" + data.id,
            		edit 	: resourceRoute + "/" + data.id + "/edit",
            		delete 	: resourceRoute + "/" + data.id
            	};
            	var deleteForm = $("<form />",{method: "POST", action: actions[resourceAction]});
            	$('body').append(deleteForm);
            	switch(resourceAction){
            		case "index":
            		case "create":
            		case "show":
            		case "edit":
            			// location.href = actions[resourceAction];
            		break;
            		case "delete":
	            		var spoofDelete = $('<input type="hidden" name="_method" value="DELETE" />');
	            		var token = $('<input type="hidden" name="_token" value="'+$('meta[name="csrf-token"]').attr('content')+'" />');
	            		deleteForm.append(spoofDelete);
	            		deleteForm.append(token);
	            		deleteForm.submit();
            		break;
            		default:
            			
            			var url = resourceAction;
            			var dataKeys = [];
            			var dataValues = [];
						try{
							url.replace(/\{(.+?)\}/g, function(_, m){
								dataKeys.push(m)
								dataValues.push(data[m]);
							});
							for(var i = 0; i < dataKeys.length; i++) {
							    url = url.replace(new RegExp('{' + dataKeys[i] + '}', 'gi'), dataValues[i]);
							}
	            			location.href = url;
						}catch (err){
							console.log("Invalid url for resource action");
						}
            		break;
            	}
            },
		}