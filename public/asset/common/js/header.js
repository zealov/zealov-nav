$(document).ready(function(){
    $('header').removeClass('fixed')
            fixedNav();
             function fixedNav(){
            var position = $(window).scrollTop();
            $(window).scroll(function() {
                if ($(window).scrollTop() > 80) {
                    $("header").addClass("fixed");
                    var scroll = $(window).scrollTop();
                    if (scroll >= position) {
                        $("header").removeClass("show");
                        $('.header').removeClass('menu-show');
                    }else {
                        $("header").addClass("show");
                    }
                    position = scroll;
                }else if($(window).scrollTop() <= 0){
                    $("header").removeClass("fixed").removeClass("show");
                }
            });
            $(window).on("ontouchmove", function() {
                if ($(window).scrollTop() > 80) {
                    $("header").addClass("fixed");
                    var scroll = $(window).scrollTop();
                    if (scroll >= position) {
                        $("header").removeClass("show");
                    }else {
                        $("header").addClass("show");
                    }
                    position = scroll;
                }else if($(window).scrollTop() <= 0){
                    $("header").removeClass("fixed").removeClass("show");
                }
            });
            
        }  
    
});
