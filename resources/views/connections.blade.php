@extends('layout.admin_bsb')
@section('connections-content')
<script src="{{ asset('js/connection.js') }}"></script>
<input type = "hidden" id = "routeName" value = "{{\Route::currentRouteName()}}">
<section class="content">
	<div class = "container-fluid" style = "padding-top:20px;">
                <div class='col-sm-1'>
                    <label for="url">Action:</label>
                </div>
                <div class='col-sm-5'>
                    <button class = "btn btn-info waves-effect" type = "button" id = "restartConnection" value = "RESTART">RESTART ALL CONNECTIONS</button>
                </div>
                
            </div>
	<div class = "container-fluid" style = "padding-top: 30px;">
	    <div class="row clearfix">
	        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	            <div class="card">
	                <div class="header">
	                    <h2>
	                        CONNECTIONS
	                    </h2>
	                </div>
	                <div class="container-fluid">
	                    <div class="body table-responsive">
	                        <table class="table table-hover">
	                            <thead>
	                                <tr>
	                                    <th>Socket ID</th>
	                                    <th>MAC ADDRESS</th>
	                                    <th>Local Time</th>
	                                    <th>Server Time</th>
	                                    <th>Status</th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                            	@foreach ($connections as $connection)
		                                <tr>
		                                    <th scope="row">{{$connection->socket_id}}</th>
		                                    <td>{{$connection->mac_address}}</td>
		                                    <td>{{$connection->local_time}}</td>
		                                    <td>{{$connection->server_time}}</td>
		                                    <td>{{$connection->status}}</td>
		                                </tr>
	                                @endforeach
	                            </tbody>
	                        </table>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
@endsection