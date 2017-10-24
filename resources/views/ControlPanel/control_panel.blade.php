@extends('layout.admin_bsb')
@section('control-panel-content')
    <!-- Custom -->
    <script src="{{ asset('js/control-panel.js') }}"></script>
    <section class="content">
            <!-- PHP hidden inputs -->
        <input type = "hidden" id = "websocketUrl" value = "{{$websocketUrl}}">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Control Panel</h2>
            </div>
            <input type = "hidden" id = "websocketUrl" value = "{{$websocketUrl}}">
             <!-- Logout form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
            </form> 
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
            <div class = "container-fluid" style = "padding-top:20px;">
                <div class='col-sm-1'>
                    <label for="url">Switcher:</label>
                </div>
                <div class='col-sm-5'>
                    <button class = "btn btn-info waves-effect" type = "button" id = "fbLiveSwitcher" value = "FBLIVE">VIDEO STREAM</button>
                    <button class = "btn btn-basic waves-effect" type = "button" id = "dmsSwitcher" value = "DMS">DMS</button>
                </div>
                
            </div>
            <!-- URL Input -->
            <div class = "container-fluid" style = "padding-top:20px;">
                <div class='col-sm-1'>
                    <label for="url">URL:</label>
                </div>
                <form method = "POST" action = "{{url('/')}}/video-streaming-url">
                    {{ csrf_field() }}
                    <div class='col-sm-4'>
                        <input name = "videoStreamingUrl" id = "urlInput" class = "form-control" type = "text" value = "{{ $urlStorage }}">
                    </div>
                    <div class='col-sm-4'>
                        <input type = "hidden" id = "urlStorage" value = "{{ $urlStorage }}">
                        <button type = "submit" id = "updateUrl" class = "btn btn-warning waves-effect">UPDATE</button>
                    </div>
                </form>
            </div>
            <div class = "container-fluid" style = "padding-top:20px;">
                <div class='col-sm-1'>
                    <label for="url">Message:</label>
                </div>
                <form method = "POST" action = "{{url('/')}}/ticker-message">
                    {{ csrf_field() }}
                    <div class='col-sm-4'>
                        <input type = "hidden" id = "tickerMessage" value = "{{ $tickerMessage }}">
                        <input name = "tickerInput" id = "tickerInput" class = "form-control" type = "text" value = "{{ $tickerMessage }}">
                    </div>
                    <div class='col-sm-4'>
                        <button type = "submit" id = "updateTickerMessage" class = "btn btn-warning waves-effect">UPDATE</button>
                    </div>
                </form>
            </div>
             <div class = "container-fluid" style = "padding-top:20px;">
                <div class='col-sm-1'>
                    <label for="url">Action:</label>
                </div>
                <div class='col-sm-9'>
                    <button class = "btn btn-primary waves-effect" type = "button" id = "startBtn" value = "START">START DMS</button>
                    <button class = "btn btn-danger waves-effect" type = "button" id = "stopBtn" value = "START">STOP DMS</button>
                    <button type = "button" id = "startTicker" class = "btn btn-success waves-effect">START TICKER</button>
                    <button type = "button" id = "endTicker" class = "btn btn-danger waves-effect">STOP TICKER</button>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach ($controlPanelData as $log)
                                                <tr>
                                                    <td class = "time" align = "center" data-value = "{{ $log->time }}">{{$log->time}}</th>
                                                    <input type = "hidden" class = "log-id" value = "{{$log->id}}">
                                                    <td align = "center">{{$log->returnMessage}}</td>
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
        </div>
    </section>
@endsection