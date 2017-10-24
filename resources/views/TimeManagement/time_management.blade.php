@extends('layout.admin_bsb')
@section('time-management-content')
    <!-- Custom -->
    <script src="{{ asset('js/sequence-management.js') }}"></script>
    <section class="content">
            <!-- PHP hidden inputs -->
        <input type = "hidden" id = "websocketUrl" value = "{{$websocketUrl}}">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Sequence Management</h2>
            </div>
           <input type = "hidden" id = "timeLogs" value = "{{$timeManagement}}">
            <input type = "hidden" id = "websocketUrl" value = "{{$websocketUrl}}">
             <!-- Logout form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
            </form> 
            <!-- Time Inputs -->
            <div class = "container-fluid" style = "padding-top: 30px;">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
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
                                                    <input type = "hidden" class = "log-update-at" value = "{{$log->updated_at}}">
                                                    <input type = "hidden" class = "log-created-at" value = "{{$log->created_at}}">
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