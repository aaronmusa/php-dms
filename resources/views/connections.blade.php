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
	                                    <th>id#</th>
	                                    <th>Start Time</th>
	                                    <th>End Time</th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                                <tr>
	                                    <th scope="row">sample</th>
	                                    <td>sample</td>
	                                    <td>sample</td>
	                                </tr>
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