@extends('layout.admin_bsb')
@section('edit-time-content')
 <script src="{{ asset('js/sequence-management.js') }}"></script>
    <section class="content">
    <input type = "hidden" id = "websocketUrl" value = "{{$websocketUrl}}">
        <div class="container-fluid">
            <div class="block-header">
                <h2>EDIT</h2>
            </div>
			<div class="row clearfix">
			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			        <div class="card">
			            <div class="header">
			                <h2>
			                    EDIT ENTRY
			                </h2>
			            </div>
			            <div class="body">
			                <form method = "POST" action = "{{url('/')}}/ticker/{{$id}}">
			                	{{ csrf_field() }}
			                	{!! method_field('patch') !!}
			                	<input name = "id" type = "hidden" value = "{{$id}}">
			                    <label for="startTime">Start Time</label>
			                    <div class="form-group">
			                        <div class="form-line">
			                            <input type="text" name = "start_time" id="startTime" value="{{ $startTime }}" class="datePicker form-control">
			                        </div>
			                    </div>
			                    <label for="password">End Time</label>
			                    <div class="form-group">
			                        <div class="form-line">
			                            <input type="text" name = "end_time" value = "{{ $endTime}}" id="endTime" class=" datePicker form-control">
			                        </div>
			                    </div>
			                    <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
			                </form>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</section>
@endsection