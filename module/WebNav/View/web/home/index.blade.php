@extends($_viewFrame)
@section('body')
    {!! \Zealov\Zealov::css('asset/layui/css/layui.css') !!}
    <style>
        body {
            background-color: #f9f9f9;
        }
        .main-content {
            padding: 0px 30px 30px 30px;
        }
        .text-gray {
            font-weight: bold;
            font-size: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .item-nav {
            padding: 15px;
            background: #fff;
            height: 54px;
            cursor: pointer;
            border-radius: 4px;
            border: 1px solid #e4ecf3;
            transition: all 0.3s ease;
        }
        .item-nav:hover {
            background: #FFCA3A;
        }

        .item-nav-entry {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }
        .item-nav-entry img {
            float: left;
            display: block;
            margin-right: 10px;
            padding: 7px 0;
            border-radius: 50%;
            vertical-align: middle;
        }
        .item-nav-entry-content {
            transform: translateY(-50%);
            position: absolute;
            margin-left: 50px;
            top: 50%;
        }
        .item-nav-entry-content a {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }
        .item-nav-entry-content p {
            margin-bottom: 0px;
            margin-right: 15px;
            color: #979898;
        }
        .layui-layout-admin .layui-header {
            background-color: #fff !important;
        }
        .layui-nav {
            color: #0C0C0C !important;
        }
        .layui-bg-black {
            background-color: rgb(48, 65, 86) !important;
        }
        .layui-nav-tree{
            background-color: rgb(48, 65, 86) !important;
        }
    </style>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <div class="layui-logo layui-hide-xs layui-bg-black">{{app('SystemConfig')->value('siteName')}}</div>
        </div>
        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <ul class="layui-nav layui-nav-tree ">
                    @foreach(\ZealovNav::CatgoryTree() as $key=>$value)
                        <li class="layui-nav-item">
                            <a href="#{{$value['label']}}_{{$value['id']}}">{{$value['name']}}</a>
                            @if(isset($value['children']))
                                <dl class="layui-nav-child">
                                    @foreach($value['children'] as $k=>$v)
                                        <dd><a href="#{{$v['label']}}_{{$v['id']}}">
                                                <span
                                                    style="padding-left: 25px">{{$v['name']}}</span>
                                            </a>
                                        </dd>
                                    @endforeach
                                </dl>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="layui-body">
            <div class="main-content">
                @foreach(\ZealovNav::navAll() as $key=>$value)
                    <h4 class="text-gray" id="{{$value['label']}}_{{$value['id']}}">
                        <i class="linecons-tag" style="margin-right: 7px;" id="常用推荐"></i>
                        {{$value['name']}}
                    </h4>
                    <div class="layui-row  layui-col-space10">
                        @foreach($value['navigations'] as $k=>$v)
                            <div class="layui-col-md3 ">
                                <div class="item-nav ">
                                    <div onclick="window.open('{{$v['url']}}', '{{$v['target']}}')">
                                        <div class="item-nav-entry">
                                            <a class="item-nav-entry-img">
                                                <img src="{{$v['image_path']}}" width="40">
                                            </a>
                                            <div class="item-nav-entry-content">
                                                <a href="#">
                                                    <strong>{{$v['name']}}</strong>
                                                </a>
                                                <p>{{$v['description']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            Copyright &copy; 2023 备案号：<a href="{{app('SystemConfig')->value('siteBeianGonganLink')}}" target="_blank">
                {{app('SystemConfig')->value('siteBeian')}}
        </a>
        </div>
    </div>
@endsection
{!! \Zealov\Zealov::js('asset/common/js/jquery-1.11.1.min.js') !!}
{!! \Zealov\Zealov::js('asset/layui/layui.js') !!}
@section('scripts')
    <script>
        //JS
        layui.use(['element', 'layer', 'util'], function(){
            var element = layui.element
                ,layer = layui.layer
                ,util = layui.util
                ,$ = layui.$;
        });
    </script>
@stop
