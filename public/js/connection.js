function setPcName(){
	var pcName = $('#pcName').text();
	$('#pcNameInput').val(pcName.replace('mode_edit',''));
}