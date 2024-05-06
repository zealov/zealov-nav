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
