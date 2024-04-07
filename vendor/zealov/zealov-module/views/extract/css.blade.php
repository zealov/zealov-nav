@foreach($css as $c)
<link rel="stylesheet" href="{{ \Zealov\Kernel\Assets\AssetsUtil::fix($c) }}" />
@endforeach
