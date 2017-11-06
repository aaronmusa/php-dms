@extends('layout.admin_bsb')
@section('connections-content')
<script src="{{ asset('js/connection.js') }}"></script>
<input type = "hidden" id = "routeName" value = "{{\Route::currentRouteName()}}">
<section class="content">
	<div class = "container-fluid" style = "padding-top:20px;">
		<input type = "hidden" id = "websocketUrl" value = "{{$websocketUrl}}">	
      	{{ csrf_field() }}
    </div>
	<div class = "container-fluid" style = "padding-top: 30px;">
	    <div class="row clearfix">
	        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	            <div class="card">
	                <div class="header">
	                    <h2>
	                        CONNECTIONS
	                       <img src = "{{ asset('images/connected.png') }}" width = "25px" height = "25px">
	                    </h2>
	                </div>
	                <div class="container-fluid">
	                    <div class="body table-responsive">
	                        <table class="table table-hover">
	                            <thead>
	                                <tr>
	                                    <th style = "text-align:center;">Name</th>
	                                    <th style = "text-align:center;">MAC ADDRESS</th>
	                                    <th style = "text-align:center;">Local Time</th>
	                                    <th style = "text-align:center;">Server Time</th>
	                                    <th style = "text-align:center;">Status</th>
	                                </tr>
	                            </thead>
	                            <tbody id = "connectionTable">
	                        
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