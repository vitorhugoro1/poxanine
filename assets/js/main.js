(function($){
    $("#mobile-menu").on('click', '.menu-action', function () {
        if(!$(".mobile-menu").is('visible')){
            $(".mobile-menu").show();
        } else {
            $(".mobile-menu").hide();
        }
    });

    $("#mobile-menu").on('click', '.search-action', function () {
        if(!$(".top-search").is('visible')){
            $(".top-search").show();
        } else {
            $(".top-search").hide();
        }
    });
});