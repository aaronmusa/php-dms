$(document).ready(function() {
	$("a.delete-btn").click(function(event) {
		event.preventDefault();
		var mailId = $(this).data("mail-id");
		$("#deleteMailForm").attr('action', 'mail/'+mailId).submit();
	});
	$('.change-status').click(function(){
		var status = $(this);
		var counter = parseInt($("#inbox-counter").html());
		if(isNaN(counter)){
			counter = 0;
		}
		if(status.hasClass('mark-as-read')){
			changeStatus(status.data('mail-id'), status, 'mark-as-read', 'Mark as Read');
			counter--;
			var display = '';
			if(counter > 0){
				display = counter + ' Unread';
			}
				$('#inbox-counter').html(display);
		}else{
			changeStatus(status.data('mail-id'), status, 'mark-as-unread',
				'Mark as Unread');
			counter++;
         	$('#inbox-counter').html(counter + ' Unread');
		}
	});
});
function changeStatus(mailId, selector, url, text){
	console.log(url);
	var newClass;
	if(url == "mark-as-read"){
		newClass = "mark-as-unread";
	}else if(url == "mark-as-unread") {
		newClass = "mark-as-read";
	}
	$.get(url + "/" + mailId, function(data){
			selector
			.addClass(newClass)
			.removeClass(url)
			if(url == "mark-as-unread"){
				selector
				.parents('tr')
				.addClass('visited')
				.removeClass('visited')
			}else if(url == "mark-as-read") {
				selector
				.parents('tr')
				.removeClass('visited')
				.addClass('visited')
			}
			if(newClass == "mark-as-unread"){
   			selector
   			.html("Mark As Unread")
			}else if(newClass == "mark-as-read"){
				selector
   			.html("Mark As Read")
			}
		});
}
