<!-- start time -->
<h3>{{ $log->id }}</h3>
<div class='col-sm-4'>
	<input type="text" class = "startTime form-control" value = "{{ $log->start_time }}" />
</div>
<!-- end time -->
<div class='col-sm-4'>
	<input type="text" class = "endTime form-control" value = "{{ $log->end_time }}" />
</div>
<button class = "btn btn-danger">X</button>

<!-- <div class='col-sm-5'>
	<button class = "btn btn-danger">Delete</button>
	<button class = "btn btn-warning">Update</button>
</div> -->
