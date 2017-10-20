@extends('layout.admin_bsb')
@section('add-time-content')
	 <script src="{{ asset('js/sequence-management.js') }}"></script>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ADD TIME</h2>
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
			                <form method = "POST" action =  "{{url('/')}}/time-scheduler">
			                	{{ csrf_field() }}
			                    <label for="email_address">Start Time</label>
			                    <div class="form-group">
			                        <div class="form-line">
			                            <input type="text" name = "start_time" class="currentTime datePicker form-control">
			                        </div>
			                    </div>
			                    <label for="password">End Time</label>
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