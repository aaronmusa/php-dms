<!DOCTYPE html>
<html lang="en">

  <head>

   @include ('layouts.head_contents')

  </head>

  <body>
  	<div class = "container" style = "padding-top: 50px;">
			<form id = "formId" action = "/socket" method = "post">
				{{ csrf_field() }}
				<input id = "methodName" type="hidden" name="_method" value="POST">
				<div class = "form-group col-lg-12">
					<div class = "col-lg-9">
						<div class='col-sm-4'>
							<label for="start_time">Start Time</label>
						</div>
						<div class='col-sm-4'>
							<label for="end_time">End Time</label>
						</div>
					</div>
				</div>
				<div id = "timePickerContainer" class = "form-group col-lg-12">
					@foreach ($logs as $log)
						<?php $counter = 0; ?>
						@include ('layouts.datePickers')
					@endforeach
				</div>
			<!-- button -->
			    <div class='form-group col-lg-12' id = "divParent">
		            <div class="col-sm-4" id = "divClass">
		            	<div class = "col-lg-9">
		                	<button type = "button" class = "addBtn btn btn-primary glyphicon glyphicon-plus"></button>
		                	<button style = "visibility:hidden;" type = "button" class = "removeBtn btn btn-danger glyphicon glyphicon-minus"></button>
		                	<button style = "visibility:hidden;" id = "submitBtn" type = "submit" class = "btn btn-success">Submit</button>
		            	</div>
		            </div>
				</div>
			</form>
		<!-- error -->
		@include ('layouts.errors')
	</div>

   <!-- Script -->
   	@include ('layouts.scripts')
  </body>
</html>