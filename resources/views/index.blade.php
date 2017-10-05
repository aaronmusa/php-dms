<!DOCTYPE html>
<html lang="en">

  <head>

   @include ('layouts.head_contents')

  </head>

  <body style = "background-color: #a1c4fd;">
  	<input type = "hidden" id = "timeLogs" value = "{{$timeManagement}}">
  	<input type = "hidden" id = "websocketUrl" value = "{{$websocketUrl}}">

	<div class = "container" style = "padding-top: 10px">
		<div class = "form-group col-lg-12">
			<div class = "col-lg-9">
				<div class='col-sm-4'>
					<a href="{{ route('logout') }}"
					    onclick="event.preventDefault();
					             document.getElementById('logout-form').submit();">
					    <button class = "btn btn-primary">Logout</button>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class = "container" style = "padding-top:20px;">
		
		<div class = "form-group col-lg-12">
			<div class = "col-lg-9">
				<div class='col-sm-2'>
					<label for="url">Time:</label>
				</div>
				<div class='col-sm-4'>
					<label for='time'>00:00:00</label>
				</div>
			</div>
		</div>
	</div>

	<div class = "container" style = "padding-top:20px;">

		<div class = "form-group col-lg-12">
			<div class = "col-lg-9">
				<div class='col-sm-2'>
					<label for="url">Switcher:</label>
				</div>
				<div class='col-sm-5'>
					<button class = "btn btn-info" type = "button" id = "fbLiveSwitcher" value = "FBLIVE">VIDEO STREAM</button>
					<button class = "btn btn-basic" type = "button" id = "dmsSwitcher" value = "DMS">DMS</button>
				</div>
			</div>
		</div>
	</div>

	<div class = "container" style = "padding-top:20px;">
		<div class = "form-group col-lg-12">
			<div class = "col-lg-9">
				<div class='col-sm-2'>
					<label for="url">URL:</label>
				</div>
				<form method = "POST" action = "video-streaming-url">
					{{ csrf_field() }}
					<div class='col-sm-4'>
						<input name = "videoStreamingUrl" id = "urlInput" class = "form-control" type = "text" value = @if ($urlStorage != '') "{{ $urlStorage }}" 
						@endif >
					</div>
					<div class='col-sm-4'>
						<input type = "hidden" id = "urlStorage" value = "{{$urlStorage}}">
						<button type = "submit" id = "updateUrl" class = "btn btn-warning">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<form id="logout-form" action="{{ route('logout') }}" method="POST">
	    {{ csrf_field() }}
	   
	</form>

  	<div class = "container" style = "padding-top: 30px;">
			<form id = "formId" action = "timeScheduler" method = "post">
				{{ csrf_field() }}
				<input id = "methodName" type="hidden" name="_method" value="POST">
				<div  class = "form-group col-lg-19">
					<div class = "col-lg-9">
						<div class='col-sm-4'>
							<label for="start_time">Start Time</label>
						</div>
						<div class='col-sm-4'>
							<label for="end_time">End Time</label>
						</div>
					</div>
				</div>
				<div id = "timePickerContainer" class = "form-group container">
					@foreach ($timeLogs as $log)
						@include ('layouts.datepickers')
					@endforeach
				</div>
			<!-- button -->
			    <div class='form-group col-lg-19' id = "divParent">
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
<!-- 	<script src="{{ asset('js/app.js') }}"></script> -->
   <!-- Script -->
   	@include ('layouts.scripts')
  </body>
</html>