
<!DOCTYPE html>
<html>
@php
    $config = [
        'appName' => config('app.name'),
    ];
    $appJs = mix('/js/app.js','/module/WebNav/back/');
    $appCss = mix('/css/app.css','/module/WebNav/back/');
@endphp
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ (str_starts_with($appCss, '//') ? 'http:' : '').$appCss }}">
</head>
<body>
<div id="app"></div>
<script src="{{asset('asset/vendor/vue.js')}}"></script>
<script src="{{asset('asset/vendor/element-ui/index.js')}}"></script>
<script>
    window.config = @json($config);
</script>

<script src="{{ (str_starts_with($appJs, '//') ? 'http:' : '').$appJs }}"></script>
</body>
</html>

