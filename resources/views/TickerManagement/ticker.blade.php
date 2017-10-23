@extends('layout.admin_bsb')
@section('ticker-management-content')
    <!-- Custom -->
    <script src="{{ asset('js/ticker.js') }}"></script>
    <input type = "hidden" id = "routeName" value = "{{\Route::currentRouteName()}}">
    <section class="content">
            <!-- PHP hidden inputs -->
        <input type = "hidden" id = "websocketUrl" value = "{{$websocketUrl}}">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Ticker Management</h2>
            </div>
           <input type = "hidden" id = "tickers" value = "{{$tickerManagement}}">
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
            <div class = "container-fluid" style = "padding-top:20px;">
                <div class='col-sm-1'>
                    <label for="url">URL:</label>
                </div>
                    {{ csrf_field() }}
                <div class='col-sm-4'>
                    <input name = "tickerInput" id = "tickerInput" class = "form-control" type = "text" value = "Sample Ticker">
                </div>
                <div class='col-sm-4'>
                    <button type = "submit" id = "startTicker" class = "btn btn-info waves-effect">START TICKER</button>
                    <button type = "submit" id = "endTicker" class = "btn btn-info waves-effect">END TICKER</button>
                </div>
            </div>

            <!-- Time Inputs -->
            <div class = "container-fluid" style = "padding-top: 30px;">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    TICKERS
                                </h2>
                                <div style = "padding-top:10px;" >
                                    <a href = "{{ route('addTickerPage') }}"><button type = "submit" id = "add" class = "btn btn-info waves-effect"><i class = 'material-icons'>add</i></button></a>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="body table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>id#</th>
                                                <th>Message</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th style = "text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tickers as $ticker)
                                                <tr>
                                                    <th scope="row">{{$ticker->id}}</th>
                                                    <input type = "hidden" class = "ticker_id" value = "{{$ticker->id}}">
                                                    <input type = "hidden" class = "ticker_message" value = "{{$ticker->message}}">
                                                    <td>{{$ticker->message}}</td>
                                                    <input type = "hidden" class = "ticker_start_time" value = "{{$ticker->start_time}}">
                                                    <td>{{$ticker->start_time}}</td>
                                                    <input type = "hidden" class = "ticker_end_time" value = "{{$ticker->end_time}}">
                                                    <td>{{$ticker->end_time}}</td>
                                                    <td align="center">
                                                        <a href = "{{ route('editTickerPage',$ticker->id) }}" ><button type = "submit" name = "editBtn" value = "{{$ticker->id}}" class = "btn btn-info waves-effect"><i class="material-icons">mode_edit</i></button></a>
                                                        <button type = "button" value = "{{ $ticker->id }}" data-id = "{{ $ticker->id }}" class = "deleteBtn btn btn-danger waves-effect"><i class="material-icons">delete</i></button>       
                                                    </td>
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