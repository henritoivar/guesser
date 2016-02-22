<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Knowhood</title>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <!-- Google font Roboto -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <!-- Google font Noto Serif -->
    <link href='https://fonts.googleapis.com/css?family=Noto+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <!-- Google Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="{{ asset('lib/jquery/dist/jquery.js') }}"></script>
</head>
<body>
    <!-- Content -->
    @yield('content')
</body>
</html>