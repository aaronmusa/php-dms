<!DOCTYPE html>
<html lang="en">

  <head>

   @include ('layouts.head_contents')

  </head>

  <body>
  	<div class = "container" style = "padding-top: 50px;">
		<div class="container">
			<form  method = "post">
				{{ csrf_field() }}
				<div class = "datepickerContainer col-md-9">
				@foreach ($logs as $log)
					@include ('layouts.datePickers')
				@endforeach
			</div>
			<!-- button -->
			    <div class='col-sm-6' id = "divParent">
		            <div class="form-group" id = "divClass">
		                <button type = "button" class = "addBtn btn btn-primary glyphicon glyphicon-plus"></button>
		            </div>
				</div>
				<div class='col-md-6'>
		            <div class="form-group">
		                <button type = "submit" class = "btn btn-success">Submit</button>
		            </div>
				</div>
		</form>
		<!-- error -->
		@include ('layouts.errors')

	</div>
	</div>

   <!-- Script -->
   	@include ('layouts.scripts')
  </body>
</html>