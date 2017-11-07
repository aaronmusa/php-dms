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
	                                    <th>Name</th>
	                                    <th style = "text-align:center;">MAC ADDRESS</th>
	                                    <th style = "text-align:center;">Local Time</th>
	                                    <th style = "text-align:center;">Server Time</th>
	                                    <th style = "text-align:center;">Action</th>
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
	<div class="modal fade" id="editPcNameModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">EDIT NAME</h4>
                </div>
                <form id = "editPcNameForm">
                    <div class="modal-body" id = "modal-body">
                       <label for="name">Name</label>
                       <input type = "text" class = "form-control" id = "pcNameInput" required/>
                       <input type = "hidden" id = "macAddressInput" value = "">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id = "addPcName" class="btn btn-link waves-effect">UPDATE</button>
                        <button type="button" id = "modal-close" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection