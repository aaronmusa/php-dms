<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>DMS</title>
    <!-- Google Fonts -->
    <link href="//fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('admin/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('admin/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('admin/plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">
</head>

<body class="login-page bg-blue">
    <div class="login-box">
       
        <div class="card">
            <div class="body">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap Core Js -->
    <script src="{{asset('admin/plugins/bootstrap/js/bootstrap.js')}}"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('admin/plugins/node-waves/waves.js')}}"></script>
    <!-- Validation Plugin Js -->
    <script src="{{asset('admin/plugins/jquery-validation/jquery.validate.js')}}"></script>
    <!-- Custom Js -->
    <script src="{{asset('admin/js/admin.js')}}"></script>
    <script src="{{asset('admin/js/pages/examples/sign-in.js')}}"></script>
</body>

</html>