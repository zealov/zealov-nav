@foreach($js as $j)
<script src="{{  \Zealov\Kernel\Assets\AssetsUtil::fix($j) }}"></script>
@endforeach
