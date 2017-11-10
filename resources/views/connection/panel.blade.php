@extends('layout.admin_bsb')
@section('panel-content')
<script src="{{ asset('js/panel.js') }}"></script>
<section class="content">
	<div class = "container-fluid" style = "padding-top:20px;">
		<input type = "hidden" id = "websocketUrl" value = "{{$websocketUrl}}">	
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="body bg-light-blue">
                	@foreach ($currentConnection as $current)
                		<input type = "hidden" id = "pcName" value = "{{$current->name}}">
                		<input type = "hidden" id = "pcUrl" value = "{{$current->livestream_url}}">
                		<input type = "hidden" id = "pcMacAddress" value = "{{$current->mac_address}}">
            		<input type = "hidden" id = "pcTickerMessage" value = "{{$current->ticker_message}}">
                    	TIME SEQUENCE FOR <br>
                    	<label id = "name">{{$current->name }}</label> -  {{ $current->mac_address }} &nbsp;
                    	<button class = "btn btn-primary" id = "editPcName" data-toggle = "modal" data-target = "#editPcNameModal"><i class="material-icons">mode_edit</i></button><br>
                    	URL: <label id = "url">{{ $current->livestream_url}}</label><br>
                    	Ticker Message: <label id = "tickerMessage">{{ $current->ticker_message}}</label>
                    @endforeach
                </div>
            </div>
        </div>
      	{{ csrf_field() }}
    </div>

    <div class = "container-fluid" style = "padding-top:20px;">
        <div class='col-sm-1'>
            <label for="url">Operation:</label>
        </div>
        <div class='col-sm-9'>
            <button class = "btn btn-primary waves-effect setCurrentTime" type = "button" id = "addTimeSequence" data-toggle="modal" data-target="#addTimeSequenceModal">ADD TIME SEQUENCE</button>
            <button class = "btn btn-primary waves-effect setCurrentTime" type = "button" id = "addTicker" data-toggle = "modal" data-target = "#addTickerSequenceModal">ADD TICKER</button>
            <!--  <button class = "btn btn-warning waves-effect" type = "button" id = "restartBtn" value = "RESTART">RESTART</button> -->
        </div>
    </div>


    <div class = "container-fluid" style = "padding-top: 30px;">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="container-fluid">
                    	<header><h4>Time Sequence</h4></header>
                        <div class="body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style = "text-align:center;">Start Time</th>
                                        <th style = "text-align:center;">End Time</th>
                                    </tr>
                                </thead>
                                <tbody id = "panelTableBody">
                                	@foreach ($panelData as $data)
	                                	<tr>
	                                		@if ($data->message == "No Message")
		                                		<td align = "center">{{$data->start_time}}</td>
		                                		<td align = "center">{{$data->end_time}}</td>
	                                		@endif
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

    <div class = "container-fluid" style = "padding-top: 30px;">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="container-fluid">
                    	<header><h4>Tickers</h4></header>
                        <div class="body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style = "text-align:center;">Start Time</th>
                                        <th style = "text-align:center;">End Time</th>
                                        <th style = "text-align:center;">Message</th>
                                    </tr>
                                </thead>
                                <tbody id = "panelTableBody">
                                	@foreach ($panelData as $data)
	                                	<tr>
	                                		@if ($data->message != "No Message")
		                                		<td align = "center">{{$data->start_time}}</td>
		                                		<td align = "center">{{$data->end_time}}</td>
		                                		<td align = "center">{{$data->message}}</td>
	                                		@endif
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

    <div class="modal fade" id="editPcNameModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">EDIT NAME</h4>
                </div>
                <form id = "editPcNameForm">
                    <div class="modal-body" id = "modal-body">
	                        <label for="name">Name</label>
	                        <input type = "text" class = "form-control" id = "pcNameInput" required/>
	                        <label for="livestreamUrl">Livestream URL</label>
	                        <input type = "text" class = "form-control" id = "livestreamUrlInput" required/>
	                        <label for="tickerMessage">Ticker Message</label>
	                        <input type = "text" class = "form-control" id = "tickerMessageInput" required/>
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

     <!-- Large Size -->
        <div class="modal fade" id="addTimeSequenceModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="largeModalLabel">ADD TIME SEQUENCE</h4>
                    </div>
                    <form id = "add_time_sequence_form">
                        <div class="modal-body">
                           <label for="startTime">Start Time</label>
                           <input type = "text" class = "currentTime datePicker form-control" id = "startTimeInput" required/>
                           <label for="endTime">End Time</label>
                           <input type = "text" class = "currentTime datePicker form-control" id = "endTimeInput" required/>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id = "addEntry" class="btn btn-link waves-effect">ADD</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addTickerSequenceModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="largeModalLabel">ADD TICKER</h4>
                    </div>
                    <form id = "add_ticker_form">
                        <div class="modal-body">
                           <label for="message">Message</label>
                           <input type = "text" class = "form-control" id = "messageInput" required/>
                           <label for="startTime">Start Time</label>
                           <input type = "text" class = "currentTime datePicker form-control" id = "startTimeTickerInput" required/>
                           <label for="endTime">End Time</label>
                           <input type = "text" class = "currentTime datePicker form-control" id = "endTimeTickerInput" required/>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id = "addTickerModal" class="btn btn-link waves-effect">ADD</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>
@endsection