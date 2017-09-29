@extends('layouts.blank')

@section('content')


<form id="sign_in" method="POST" action="{{ route('login') }}">
	<input type="hidden" name="_token" value="{!!csrf_token()!!}">
    <div class="msg">Sign in to start your session</div>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="material-icons">person</i>
        </span>
        <div class="form-line">
            <input type="text" class="form-control" name="name" placeholder="Username" required>
        </div>
    </div>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="material-icons">lock</i>
        </span>
        <div class="form-line{{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
    </div>
<!--     @if (count($errors) > 0)
        <div class="alert alert-danger text-center">
            @foreach ($errors->all() as $error)
                {{ $error }}<br/>
            @endforeach
        </div>
    @endif -->
    <div class="row">
        <div class="col-xs-4">
            <button class="btn btn-block bg-blue waves-effect" type="submit">SIGN IN</button>
        </div>
    </div>
</form>
@stop