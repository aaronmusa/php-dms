<!-- start time -->


<div class = "col-lg-9">
	<input type = "hidden" name = "id" value = "{{ $log->id }}">
	<div class='form-group col-sm-4'>
		<h4 style = "display:block;" >{{ $log->id }}</h4>
		<input type="text" id = "startTime{{ $log->id }}" class = "startTime form-control" value = "{{ $log->start_time }}" />
	</div>
	<!-- end time -->
	<div class='form-group col-sm-4'>
		<h4 style = "visibility:hidden;" >{{ $log->id }}</h4>
		<input type="text" id = "endTime{{ $log->id }}" class = "endTime form-control" value = "{{ $log->end_time }}" />
	</div>
	<div class='form-group col-sm-4'>
		<h4 style = "visibility:hidden;" >{{ $log->id }}</h4>
		<button type = "button" value = "{{ $log->id }}" data-id = "{{ $log->id }}" class = "deleteBtn btn btn-danger">X</button>
		<button type = "button" data-id = "{{ $log->id }}" value = "{{ $log->id }}" class = "updateBtn btn btn-warning">UPDATE</button>
	</div>
</div>

<!-- <div class='col-sm-5'>
	<button class = "btn btn-danger">Delete</button>
	<button class = "btn btn-warning">Update</button>
</div> -->
