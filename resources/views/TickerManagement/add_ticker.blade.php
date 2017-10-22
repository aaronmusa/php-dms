@extends('layout.admin_bsb')
@section('add-ticker-content')
	 <script src="{{ asset('js/ticker.js') }}"></script>
    <section class="content">
    <input type = "hidden" id = "websocketUrl" value = "{{$websocketUrl}}">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ADD TICKER</h2>
            </div>
			<div class="row clearfix">
			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			        <div class="card">
			            <div class="header">
			                <h2>
			                    NEW ENTRY
			                </h2>
			            </div>
			            <div class="body">
			                <form method = "POST" action =  "{{url('/')}}/ticker">
			                	{{ csrf_field() }}
			                	<label for="message">Message</label>
			                    <div class="form-group">
			                        <div class="form-line">
                                        <textarea name = "message" rows="4" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
                                    </div>
			                    </div>
			                    <label for="start_time">Start Time</label>
			                    <div class="form-group">
			                        <div class="form-line">
			                            <input type="text" name = "start_time" class="currentTime datePicker form-control">
			                        </div>
			                    </div>
			                    <label for="end_time">End Time</label>
			                    <div class="form-group">
			                        <div class="form-line">
			                            <input type="text" name = "end_time" class="currentTime datePicker form-control">
			                        </div>
			                    </div>
			                    <button type="submit" class="btn btn-primary m-t-15 waves-effect">ADD</button>
			                </form>
			                <div class = "body">
			                	@include ('errors.errors')
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</section>
@endsection