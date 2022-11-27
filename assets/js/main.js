jQuery(document).ready(function ($) {
    var nav = $("#mobile-menu");

    $(".menu-action").on('click', function () {
        if ($(".mobile-menu").is(':visible')) {
            $(".mobile-menu").hide();
        } else {
            $(".mobile-menu").show();
        }
    });

    $(".search-action").on('click', function () {
        if ($(".top-search").is(':visible')) {
            $(".top-search").hide();
        } else {
            $(".top-search").show();
        }
    });

    $(window).scroll(function () {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            if ($(this).scrollTop() > 50) {
                nav.parents('.container-topo').css("top", "0");
                nav.slideDown('30');
            } else {
                nav.parents('.container-topo').css("top", "none");
                nav.slideUp('30');
            }
        }
    });
});
