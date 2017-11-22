@extends('layout.admin_bsb')
@section('control-panel-content')
    <!-- Custom -->
    <script src="{{ asset('js/control-panel.js') }}"></script>
    <section class="content">
            <!-- PHP hidden inputs -->
        {{ csrf_field() }}
        <input type = "hidden" id = "websocketUrl" value = "{{$websocketUrl}}">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Control Panel</h2>
            </div>
            <input type = "hidden" id = "websocketUrl" value = "{{$websocketUrl}}"> 
            <!-- Time display -->
            <div class = "container-fluid" style = "padding-top:20px;">
                <div class='col-sm-1'>
                    <label for="url">Time:</label>
                </div>
                <div class='col-sm-4'>
                    <label for='time'>00:00:00</label>
                </div>
            </div>
            <!-- Switcher -->

            <!-- URL Input -->
            <div class = "container-fluid" style = "padding-top:20px;">
                <div class='col-sm-1'>
                    <label for="url">URL:</label>
                </div>
                    
                    <div class='col-sm-4'>
                        <input name = "videoStreamingUrl" id = "urlInput" class = "form-control" type = "text" value = "{{ $urlStorage }}">
                    </div>
                    <div class='col-sm-7'>
                        <input type = "hidden" id = "urlStorage" value = "{{ $urlStorage }}">
                        <button type = "submit" id = "updateUrl" class = "btn btn-warning waves-effect">UPDATE</button>
                        <button class = "btn btn-info waves-effect" type = "button" id = "fbLiveSwitcher" value = "FBLIVE">VIDEO STREAM</button>
                        <button class = "btn btn-basic waves-effect" type = "button" id = "dmsSwitcher" value = "DMS">DMS</button>
                    </div>
            </div>
            <div class = "container-fluid" style = "padding-top:20px;">
                <div class='col-sm-1'>
                    <label for="url">Message:</label>
                </div>
                <div class='col-sm-4'>
                    <input type = "hidden" id = "tickerMessage" value = "{{ $tickerMessage }}">
                    <input name = "tickerInput" id = "tickerInput" class = "form-control" type = "text" value = "{{ $tickerMessage }}">
                </div>
                <div class='col-sm-7'>
                    <button type = "submit" id = "updateTickerMessage" class = "btn btn-warning waves-effect">UPDATE</button>
                    <button type = "button" id = "startTicker" class = "btn btn-success waves-effect">START TICKER</button>
                    <button type = "button" id = "endTicker" class = "btn btn-danger waves-effect">STOP TICKER</button>
                </div>
            </div>
             <div class = "container-fluid" style = "padding-top:20px;">
                <div class='col-sm-1'>
                    <label for="url">Action:</label>
                </div>
                <div class='col-sm-9'>
                    <button class = "btn btn-primary waves-effect" type = "button" id = "startBtn" value = "START">START DMS</button>
                    <button class = "btn btn-danger waves-effect" type = "button" id = "stopBtn" value = "START">STOP DMS</button>
                    <!--  <button class = "btn btn-warning waves-effect" type = "button" id = "restartBtn" value = "RESTART">RESTART</button> -->
                </div>
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
            <!-- Time Inputs -->
            <div class = "container-fluid" style = "padding-top: 30px;">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="container-fluid">
                                <div class="body table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style = "text-align:center;">Time</th>
                                                <th style = "text-align:center;">Action</th>
                                                <th style = "text-align:center;">Recipient</th>
                                            </tr>
                                        </thead>
                                        <tbody id = "controlPanelTable">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
                           <input type = "text" class = "form-control" id = "tickerMessageInput" required/>
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