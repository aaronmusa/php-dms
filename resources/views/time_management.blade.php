@extends('layout.admin_bsb')
@section('time-management-content')
    <!-- Custom -->
    <script src="{{ asset('js/sequence-management.js') }}"></script>
    <section class="content">
            <!-- PHP hidden inputs -->
        <input type = "hidden" id = "websocketUrl" value = "{{$websocketUrl}}">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Time Scheduler</h2>
            </div>
           <input type = "hidden" id = "timeLogs" value = "{{$timeManagement}}">
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
                        <input name = "videoStreamingUrl" id = "urlInput" class = "form-control" type = "text" value = @if ($urlStorage != '') "{{ $urlStorage }}" 
                        @endif >
                    </div>
                    <div class='col-sm-4'>
                        <input type = "hidden" id = "urlStorage" value = "{{$urlStorage}}">
                        <button type = "submit" id = "updateUrl" class = "btn btn-info waves-effect">Update</button>
                    </div>
                </form>
            </div>
             <div class = "container-fluid" style = "padding-top:20px;">
                <div class='col-sm-1'>
                    <label for="url">Action:</label>
                </div>
                <div class='col-sm-5'>
                    <button class = "btn btn-primary waves-effect" type = "button" id = "startBtn" value = "START">START</button>
                    <button class = "btn btn-danger waves-effect" type = "button" id = "stopBtn" value = "START">STOP</button>
                    <!--  <button class = "btn btn-warning waves-effect" type = "button" id = "restartBtn" value = "RESTART">RESTART</button> -->
                </div>
                
            </div>
            <!-- Time Inputs -->
            <div class = "container-fluid" style = "padding-top: 30px;">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    TIME MANAGEMENT
                                </h2>
                                <div style = "padding-top:10px;" >
                                    <a href = "{{ route('addPage') }}"><button type = "submit" id = "add" class = "btn btn-info waves-effect"><i class = 'material-icons'>add</i></button></a>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="body table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>id#</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th style = "text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($timeLogs as $log)
                                                <tr>
                                                    <th scope="row">{{$log->id}}</th>
                                                    <input type = "hidden" class = "log-id" value = "{{$log->id}}">
                                                    <input type = "hidden" class = "startTime" value = "{{$log->start_time}}">
                                                    <td>{{$log->start_time}}</td>
                                                    <input type = "hidden" class = "endTime" value = "{{$log->end_time}}">
                                                    <td>{{$log->end_time}}</td>
                                                    <td align="center">
                                                        <a href = "{{ route('editPage',$log->id) }}" ><button type = "submit" name = "editBtn" value = "{{$log->id}}" class = "btn btn-info waves-effect"><i class="material-icons">mode_edit</i></button></a>
                                                        <button type = "button" value = "{{ $log->id }}" data-id = "{{ $log->id }}" class = "deleteBtn btn btn-danger waves-effect"><i class="material-icons">delete</i></button>       
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