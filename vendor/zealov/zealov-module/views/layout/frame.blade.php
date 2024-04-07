<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="@yield('icon','')" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title','')</title>
    <meta name="keywords" content="@yield('keywords','')">
    <meta name="description" content="@yield('description','')">
    {!! \Zealov\Zealov::css() !!}
    {!! \Zealov\Zealov::style() !!}
    @section('appendHead')@show
</head>
<body class="@yield('body-class')">
    @section('body')@show
    {!! \Zealov\Zealov::js() !!}
    {!! \Zealov\Zealov::script() !!}
    @section('appendBody')@show
</body>
@section('scripts')@show
</html>
