function isExitsVariable(variableName) {
    try {
        if (typeof(eval(variableName)) == "undefined") {
            return false;
        } else {
            return true;
        }
    } catch(e) {

    }
    return false;
}
if(!isExitsVariable('total')){
    var total = 0;
}
console.log(total)
$(document).ready(function(){
    var window_w = $(window).width(); // Window Width
    var window_h = $(window).height(); // Window Height
    var window_s = $(window).scrollTop(); // Window Scroll Top
    // On Resize
    $(window).resize(function(){
        window_w = $(window).width();
        window_h = $(window).height();
        window_s = $(window).scrollTop();
    });
    // On Scroll
    $(window).scroll(function(){
        window_s = $(window).scrollTop();
    });

    // 导航动画
    // fixedNav();
    enableBackToTop(); // Back to top button
    slideDoor(); //点击显示隐藏

    function enableBackToTop() {
        $('#button-to-top').hide();
        $(window).scroll(function() {
            if (window_s > 100) {
                $('#button-to-top').fadeIn(300);
            } else {
                $('#button-to-top').fadeOut(300);
            }
        });
        $('#button-to-top').click(function(e) {
            e.preventDefault();
            $('body,html').animate({ scrollTop: 0 }, 600);
        });
    }

    // 点击显示隐藏
    function slideDoor(){
        $(".slide-door .accordion-title").click(function(){
            var hideBox = $(this).next(".accordion-content");
            if (hideBox.css("display")=="none") {
                hideBox.slideDown("300");
                $(this).parent('.slide-door').addClass('open').siblings().removeClass('open');
                $(this).parent('.slide-door').siblings().find('.accordion-content').slideUp("300");
            } else{
                hideBox.slideUp("300");
                $(this).parent('.slide-door').removeClass('open');
            }
        });
    }
});
$(function() {

    change();
    function change() {
        var pmWidth = document.documentElement.clientWidth;
        document.documentElement.style.fontSize = pmWidth / 375*100 + "px"
    }
    window.onresize = function () {
        change();
    }
    $('header .search-btn').click(function(){
        $('.header-main .header-nav').addClass("none");
        $(this).addClass("none");
        $('header .search-box').addClass("show");
    });
    $('.search-box .close-btn').click(function(){
        $('.header-main .header-nav').removeClass("none");
        $('header .search-btn').removeClass("none");
        $('header .search-box').removeClass("show");
    });
    $(".search-box input").keypress(function (e) {
        if (e.which == 13) {
            window.location.href = "/search?keyword="+$("#keyword").val()
        }
    });
    layui.use(['element', 'form', 'layer', 'laypage'], function() {
        var $ = layui.jquery,
            element = layui.element,
            layer = layui.layer,
            laypage = layui.laypage,
            form = layui.form;
        // 分页
        laypage.render({
            elem: 'pages'
            ,count: total
            ,theme: '#6997bf'
            ,curr:currPage()
            ,prev: '<i class="iconfont icon-left"></i>'
            ,next: '<i class="iconfont icon-right"></i>'
            ,groups:6
            ,jump:function(obj, first){

                //obj包含了当前分页的所有参数，比如：
                if(!first){
                    //do something
                    var params = window.location.search
                    var paramsObj = queryURLParams(params)
                    paramsObj.page = obj.curr
                    window.location =window.location.protocol+'//'+window.location.host+ window.location.pathname+jsonUrl(paramsObj)
                }
            }
        });

        $('.header .menu-toggle').click(function(){
            if (!$('body').hasClass('mobile-site')) {
                $('body').addClass('mobile-site').addClass('body-hidden');
            }else{
                $('body').removeClass('mobile-site').removeClass('body-hidden');
            }
        })
        $('.mobile-bg').click(function(){
            $('body').removeClass('mobile-site').removeClass('body-hidden');
        })
        function queryURLParams(url) {
            var searchParams = new URLSearchParams(url)
            var paramsObj = {};
            for (let p of searchParams) {
                paramsObj[p[0]] = p[1];
            }
            return paramsObj
        }
        function currPage(){
            var url = window.location.search
            var searchParams = new URLSearchParams(url)
            var paramsObj = {};
            for (let p of searchParams) {
                paramsObj[p[0]] = p[1];
            }
            if(paramsObj.page ==undefined){
                return 1;
            }
            return paramsObj.page
        }
        function jsonUrl(e){
            let url = '?'
            for (let i in e) {
                url+=(i+'='+e[i]+'&')
            }
            return url.slice(0,url.length-1)
        }
        function mobileMenu(){
            $('.header-nav .layui-nav .layui-nav-item .layui-nav-more').click(function(e){
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
        if($(window).width()<992){
            mobileMenu();
        }
        $(window).resize(function(){
            if($(window).width()<992){
                mobileMenu();
            }
        });

        $('.header-nav .close-btn').click(function(){
            $('body').removeClass('mobile-site').removeClass('body-hidden');
            $(this).parents('.layui-nav-child').removeClass("layui-show");
        })
        $('.header-nav .back-btn').click(function(){
            $(this).parents('.layui-nav-child').removeClass("layui-show");
        })
    })
    if($(window).width()<991.9){
        $('.header-nav .layui-nav-item').click(function(){
            var hideBox = $(this).children('.layui-nav-child');
            hideBox.removeClass('layui-anim layui-anim-upbit layui-show')
            if (hideBox.children('.dropmenu').css("display")=="none") {
                hideBox.children('.dropmenu').slideDown(300);
                hideBox.addClass('active')
                $(this).children('a').children('.layui-nav-more').addClass('rotate')
            } else{
                hideBox.removeClass('active')
                hideBox.children('.dropmenu').slideUp(300);
                $(this).children('a').children('.layui-nav-more').removeClass('rotate')
            }
        })
    }


})

$(function() {
    var bannerSwiper = new Swiper('.banner .swiper-container', {
        pagination: {
            el: '.banner .swiper-pagination',
            clickable: true,
        },
        watchOverflow: true,
        preventClicks : false,
        resistanceRatio: 0,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        speed: 600,
        loop: true,
        autoHeight: true,
    });
    $(".category-nav .swiper-slide").click(function(){
        $(this).addClass('active').siblings().removeClass('active');
    })
    $('.category-nav .swiper-slide').eq(3).addClass('active').siblings().removeClass('active');
    var categorySwiper = new Swiper('.category-swiper .swiper-container', {
        resistanceRatio: 0,
        spaceBetween: 0,
        slidesPerView: 'auto',
        slideToClickedSlide: true,
        centeredSlides : true,
        centeredSlidesBounds: true,
        watchSlidesVisibility: true,/*避免出现bug*/
        normalizeSlideIndex:false,
        autoHeight: true,
    });
})
