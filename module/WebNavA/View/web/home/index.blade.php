@extends($_viewFrame)
@section('appendHead')
    {!! \Zealov\Zealov::css('module/WebNavA/front/layui/css/layui.css') !!}
    {!! \Zealov\Zealov::css('module/WebNavA/front/css/fonts/iconfont.css') !!}
    {!! \Zealov\Zealov::css('module/WebNavA/front/css/jquery.mCustomScrollbar.css') !!}
    {!! \Zealov\Zealov::css('module/WebNavA/front/css/css.css?v=2024041701') !!}
    {!! \Zealov\Zealov::css('module/WebNavA/front/css/style.css?v=2024041701') !!}
@stop
@section('body-class','header-white')
@section('body')

    <body class="header-white">
    <div class="headerTemp"></div>
    <header class="fixed show">
        <div class="header">
            <div class="header-top">
                <div class="layui-container">
                    <div class="flex">
                        <div class="logo">
                            <a href="/" class="logo-black"><img src="{{app('SystemConfig')->value('siteLogo')}}" alt="{{app('SystemConfig')->value('siteName')}}"></a>
                        </div>
                        <div class="header-main">
                            <div class="header-nav">
                                <div class="mobile-bg"></div>
                                <ul class="layui-nav nav-horizon" lay-filter="" id="resText">
                                    <li class="show-mobile">
                                        <div class="close-btn"><i class="iconfont icon-close"></i></div>
                                    </li>
                                    @foreach(\ZealovNav::navAll('main') as $key=>$value)
                                        @foreach($value['navigations'] as $k=>$v)
                                            <li class="layui-nav-item active">
                                                <a href="{{$v['url']}}" target="{{$v['target']}}">{{$v['name']}}</a>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                            <div class="menu-toggle">
                                <div class="toggle-iconfont">
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="pb-page-links">
        <div class="container">
            <div class="side">
                <div class="side-menu">
                    <div class="menu" data-category-menu-list="">
                        @foreach(\ZealovNav::CatgoryTree() as $key=>$value)
                            <a class="item @if($key==0) active @endif" data-category-id="{{$value['id']}}"
                               href="javascript:;">
                                <i class="fa fa-photo"></i>
                                {{$value['name']}}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="main">
                <div class="ub-search-block margin-top tw-rounded-xl"
                     style="background-image: url({{app('SystemConfig')->value('searchBanner')}});background-repeat:no-repeat;background-size:cover;background-position:center;">
                    <div class="title">
                        链接世界，发现无限可能！
                    </div>
                    <div class="form">
                        <div class="tab" data-search-form-tab="">
                            <a class="tab-item active" href="javascript:;">
                                百度
                            </a>
                            <a class="tab-item" href="javascript:;">
                                搜狗
                            </a>
                            <a class="tab-item" href="javascript:;">
                                Google
                            </a>
                        </div>
                        <form action="https://www.baidu.com/s?wd=" data-search-form="" method="get" target="_blank">
                            <div class="box rect">
                                <input type="text" name="b" class="form form-lg" placeholder="输入关键词搜索">
                                <button type="submit" class="btn btn-lg"><i class="iconfont icon-search"></i> 搜索
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div data-category-content-list>
                    @foreach(\ZealovNav::navAll() as $key=>$value)
                        <div class="group" data-category-id="{{$value['id']}}">
                            <h2 class="group-title">
                                {{$value['name']}}
                            </h2>
                            <div class="items">
                                <div class="layui-row row-flex layui-col-space20">
                                    @foreach($value['navigations'] as $k=>$v)
                                        <div class="layui-col-md3 layui-col-sm4 layui-col-xs6"
                                             onclick="window.open('{{$v['url']}}', '{{$v['target']}}')">
                                            <a href="javascript:;" class="item">
                                                <div class="top">
                                                    <div class="left">
                                                        <div class="img">
                                                            <img src="{{$v['image_path']}}" alt="">
                                                        </div>
                                                        <div class="name">
                                                            {{$v['name']}}
                                                        </div>
                                                    </div>
                                                    <div class="icon-box">
                                                        <i class="iconfont icon-right-mini"></i>
                                                    </div>
                                                </div>
                                                <div class="desc">
                                                    {{$v['description']}}
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-top">
            <div class="layui-container">
                <div class="copyright">
                    Copyright &copy; <a href="/">{{app('SystemConfig')->value('siteName')}}</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    备案号： <a
                        href="{{app('SystemConfig')->value('siteBeianGonganLink')}}"
                        target="_blank">{{app('SystemConfig')->value('siteBeian')}}</a>
                </div>
            </div>
        </div>
    </footer>
    <a href="#" id="button-to-top" style="display: block;"><i class="iconfont icon-up"></i></a>

    {!! \Zealov\Zealov::js('asset/common/js/jquery-1.11.1.min.js') !!}
    {!! \Zealov\Zealov::js('module/WebNavA/front/layui/layui.js') !!}
    {!! \Zealov\Zealov::js('module/WebNavA/front/js/jquery.nicescroll.min.js') !!}
    <!-- Swiper JS -->
    {!! \Zealov\Zealov::js('module/WebNavA/front/js/jquery.mCustomScrollbar.concat.min.js') !!}
    {!! \Zealov\Zealov::js('module/WebNavA/front/js/base.js') !!}
    {!! \Zealov\Zealov::js('module/WebNavA/front/js/index.js') !!}

@stop
    @section('scripts')
        <script>
            $(function () {
                change();

                function change() {
                    var pmWidth = document.documentElement.clientWidth;
                    document.documentElement.style.fontSize = pmWidth / 375 * 100 + "px"
                }

                window.onresize = function () {
                    change();
                }
                $('header .search-btn').click(function () {
                    $('.header-main .header-nav').addClass("none");
                    $(this).addClass("none");
                    $('header .search-box').addClass("show");
                });
                $('.search-box .close-btn').click(function () {
                    $('.header-main .header-nav').removeClass("none");
                    $('header .search-btn').removeClass("none");
                    $('header .search-box').removeClass("show");
                });
                $(".search-box input").keypress(function (e) {
                    if (e.which == 13) {
                        window.location.href = "search.php"
                    }
                });
                layui.use(['element', 'form', 'layer', 'laypage'], function () {
                    var $ = layui.jquery,
                        element = layui.element,
                        layer = layui.layer,
                        laypage = layui.laypage,
                        form = layui.form;

                    // 分页
                    laypage.render({
                        elem: 'pages'
                        , count: 100
                        , theme: '#6997bf'
                        , prev: '<i class="iconfont icon-left"></i>'
                        , next: '<i class="iconfont icon-right"></i>'
                        , groups: 3
                    });

                    $('.header .menu-toggle').click(function () {
                        if (!$('body').hasClass('mobile-site')) {
                            $('body').addClass('mobile-site').addClass('body-hidden');
                        } else {
                            $('body').removeClass('mobile-site').removeClass('body-hidden');
                        }
                    })
                    $('.mobile-bg').click(function () {
                        $('body').removeClass('mobile-site').removeClass('body-hidden');
                    })

                    function mobileMenu() {
                        $('.header-nav .layui-nav .layui-nav-item .layui-nav-more').click(function (e) {
                            $(this).parents('a').next().addClass("layui-show");
                            e.preventDefault();
                            return false;
                        })
                        $('.header-nav .layui-nav').niceScroll({
                            cursorborder: "",
                            cursorcolor: "rgba(0,0,0,.5)",
                            cursorwidth: '4px'
                        });
                        $('.header-nav .layui-nav .layui-nav-child .layui-container').niceScroll({
                            cursorborder: "",
                            cursorcolor: "rgba(0,0,0,.5)",
                            cursorwidth: '4px'
                        });

                    }

                    if ($(window).width() < 992) {
                        mobileMenu();
                    }
                    $(window).resize(function () {
                        if ($(window).width() < 992) {
                            mobileMenu();
                        }
                    });

                    $('.header-nav .close-btn').click(function () {
                        $('body').removeClass('mobile-site').removeClass('body-hidden');
                        $(this).parents('.layui-nav-child').removeClass("layui-show");
                    })
                    $('.header-nav .back-btn').click(function () {
                        $(this).parents('.layui-nav-child').removeClass("layui-show");
                    })
                })
                if ($(window).width() < 991.9) {
                    $('.header-nav .layui-nav-item').click(function () {
                        var hideBox = $(this).children('.layui-nav-child');
                        hideBox.removeClass('layui-anim layui-anim-upbit layui-show')
                        if (hideBox.children('.dropmenu').css("display") == "none") {
                            hideBox.children('.dropmenu').slideDown(300);
                            hideBox.addClass('active')
                            $(this).children('a').children('.layui-nav-more').addClass('rotate')
                        } else {
                            hideBox.removeClass('active')
                            hideBox.children('.dropmenu').slideUp(300);
                            $(this).children('a').children('.layui-nav-more').removeClass('rotate')
                        }
                    })
                }


            })
        </script>

        <script>
            $(function () {
                $(window).on('scroll', function () {
                    var $footer = $('footer');
                    if ($(window).scrollTop() + $(window).height() > $footer.offset().top) {
                        $('.pb-page-links .side').addClass('abs');
                    } else {
                        $('.pb-page-links .side').removeClass('abs');
                    }
                });
                $(".pb-page-links .side-menu").mCustomScrollbar({
                    scrollButtons: {
                        enable: true
                    }
                });
                $(window).resize(function () {
                    $('.pb-page-links .side-menu').mCustomScrollbar('update');
                })

                // 搜索
                var $form = $('[data-search-form]');
                var engines = [
                    {"name": "百度", "url": "https://www.baidu.com/s", "field": "wd"},
                    {"name": "搜狗", "url": "https://sogou.com/web?", "field": "query"},
                    {"name": "Google","url": "https://www.google.com/search","field": "q"}
                ];
                $('[data-search-form-tab]').on('click', '.tab-item', function () {
                    $(this).parent().find('.tab-item').removeClass('active');
                    $(this).addClass('active');
                    var i = $(this).index();
                    $form.attr('action', engines[i].url);
                    $form.find('input').attr('name', engines[i].field);
                    return false;
                });
                $('[data-search-form-tab] .tab-item:first').click();

                // 点击切换
                var $menu = $('[data-category-menu-list]');
                var $content = $('[data-category-content-list]');
                $menu.on('click', '[data-category-id]', function () {
                    var id = $(this).attr('data-category-id');
                    MS.util.scrollTo('[data-category-content-list] [data-category-id=' + id + ']', null, {
                        offset: -60
                    });

                    return false;
                });
                $(window).on('scroll', function () {
                    var top = $(window).scrollTop();
                    var $items = $content.find('[data-category-id]');
                    var $activeItem = null;
                    for (var i = 0; i < $items.length; i++) {
                        var $item = $($items[i]);
                        var offset = $item.offset();
                        if (top + 200 > offset.top) {
                            $activeItem = $item;
                        }
                    }
                    $menu.find('[data-category-id]').removeClass('active');
                    if ($activeItem) {
                        var id = $activeItem.attr('data-category-id');
                        $menu.find('[data-category-id=' + id + ']').addClass('active');
                    }
                });

            })

        </script>
@stop
