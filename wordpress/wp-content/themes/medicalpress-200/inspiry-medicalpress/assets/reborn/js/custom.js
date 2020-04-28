(function ($) {
    "use strict";


    // Globals
    var $window = $(window),
        $body = $('body'),
        isRtl = $body.hasClass('rtl');


    // Helper function to store setting(s) in Storage
    var inspiryStoreSettings = function (id, callback) {
        if (typeof(Storage) !== "undefined") {
            callback(id);
        }
    };

    /*-----------------------------------------------------------------------------------*/
    /*	Flex Slider
    /*  You can learn more about its options from http://www.woothemes.com/flexslider/
    /*-----------------------------------------------------------------------------------*/
    if (jQuery().flexslider) {

        // Flex Slider for Home page
        $('.home-slider .flexslider').flexslider({
            pauseOnAction: false,
            smoothHeight: false,
            slideshow: true,
            slideshowSpeed: 4000,
            pauseOnHover: true,
            touch: true,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            controlNav: false,
            start: function (slider) {
                slider.removeClass('loading');
            }
        });


        /* Gallery slider for home page blog section and blog page */
        $('.gallery-slider').flexslider({
            animation: "slide",
            controlNav: false,
            directionNav: true,
            pauseOnHover: true,
            pauseOnAction: false,
            smoothHeight: true,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            start: function (slider) {
                slider.removeClass('loading');
            }
        });
    }


    /*---------------------------------------------------------------------------------
     * Mean menu for responsive navigation
     *--------------------------------------------------------------------------------*/
    if (jQuery().meanmenu) {
        var $mainNavigation = $("#main-navigation");
        $mainNavigation.meanmenu({
            meanMenuContainer: '#mobile-navigation',
            meanRevealPosition: "left",
            meanMenuCloseSize: "20px",
            meanScreenWidth: "991",
            meanExpand: '+',
            meanContract: '-',
            meanDisplay: "inline-block"
        });
    }

    /*---------------------------------------------------------------------------------
     *  Carousels
     *  http://owlcarousel2.github.io/OwlCarousel2/
     *--------------------------------------------------------------------------------*/
    if (jQuery().owlCarousel) {
        $(".testimonials-carousel").owlCarousel({
            rtl: isRtl,
            smartSpeed: 800,
            autoHeight: true,
            responsive: {
                0: {
                    items: 1
                },
                1199: {
                    items: 2,
                    margin: 20
                }
            }
        });
    }

})(jQuery);