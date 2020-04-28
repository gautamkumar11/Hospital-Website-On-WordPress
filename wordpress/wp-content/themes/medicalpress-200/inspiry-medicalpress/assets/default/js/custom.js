(function ($) {
    "use strict";
    $(document).ready(function ($) {

        /*-----------------------------------------------------------------*/
        /* General Targets
        /*-----------------------------------------------------------------*/
        $('.appoint-widget p span:last-child').css('border-bottom', 'none');
        $('footer .appoint-widget p span:last-child').css('border-bottom', 'none');
        //$('.services-page .services-tabs .tab-main .tab-title:first-of-type').animate({borderTop: '1px solid #dcdee4', marginTop: '0'});

        /*-----------------------------------------------------------------------------------*/
        /*	Flex Slider
        /*  You can learn more about its options from http://www.woothemes.com/flexslider/
        /*-----------------------------------------------------------------------------------*/
        if (jQuery().flexslider) {

            // Flex Slider for Home page
            $('.home-slider .flexslider').flexslider({
                animation: "fade",
                controlNav: false,
                directionNav: true,
                pauseOnHover: true,
                pauseOnAction: false,
                smoothHeight: false,
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
                start: function (slider) {
                    slider.removeClass('loading');
                }
            });
        }

        /*-----------------------------------------------------------------*/

        /* Header Nav Animate
        /*-----------------------------------------------------------------*/
        function initHeaderNav() {
            if ($(window).width() > '767') {

                var mainMenuItem = $('#header nav li');
                mainMenuItem.on('mouseenter',
                    function () {
                        $(this).children('ul').slideDown(200);
                    });

                mainMenuItem.on('mouseleave',
                    function () {
                        $(this).children('ul').stop(true).slideUp(200);
                    }
                );

                $('#header nav li ul li a').hover(function () {
                    $(this).stop(true, true).velocity({paddingLeft: "23px"}, 150);
                }, function () {
                    $(this).stop(true, true).velocity({paddingLeft: "20px"}, 150);
                });
            }
        }

        initHeaderNav();


        /*-----------------------------------------------------------------------------------*/
        /*	Responsive Nav
        /*  Using MeanMenu Plugin
        /*-----------------------------------------------------------------------------------*/
        if (jQuery().meanmenu) {
            jQuery('nav.main-menu').meanmenu({
                meanMenuClose: '<i class="fa fa-times"></i>', // single character you want to represent the close menu button
                meanExpand: "+", // single character you want to represent the expand for ULs
                meanContract: "-", // single character you want to represent the contract for ULs
                meanMenuContainer: '#responsive-menu-container', // Choose where meanmenu will be placed within the HTML
                meanScreenWidth: "767", // set the screen width you want meanmenu to kick in at
                meanRemoveAttrs: true // true to remove classes and IDs, false to keep them
            });
        }


        /*-----------------------------------------------------------------*/
        /* Appointment Form
        /*-----------------------------------------------------------------*/
        $('.make-appoint').click(function () {
            var $this = $(this);
            var appointment_form = $this.parents('.appointment').find('.appointment-form');
            if ($this.hasClass('open')) {
                appointment_form.slideDown(500);
                $this.removeClass('open');
            } else {
                appointment_form.slideUp(500);
                $this.addClass('open');
            }
        });


        /*-----------------------------------------------------------------*/
        /* For Home Team Section Min Height
        /*-----------------------------------------------------------------*/
        $(window).load(function () {
            var teamMax = -1;
            var team_common = $(".home-team .common");
            team_common.each(function () {
                var teamHeight = $(this).outerHeight();
                teamMax = teamHeight > teamMax ? teamHeight : teamMax;
            });
            team_common.css('min-height', teamMax);
        });

        function equalHeight() {
            var teamMax = -1;
            var team_common = $(".home-team .common");
            team_common.each(function () {
                var teamHeight = $(this).outerHeight();
                teamMax = teamHeight > teamMax ? teamHeight : teamMax;
            });
            team_common.css('min-height', teamMax);
        }

        $(window).bind('resize', function () {
            equalHeight();
        });


        /*-----------------------------------------------------------------*/
        /* For Home Team Section Min Height
        /*-----------------------------------------------------------------*/
        $(window).load(function () {
            var blogMax = -1;
            var home_blog_post = $(".home-blog .common");
            home_blog_post.each(function () {
                var blogHeight = $(this).outerHeight();
                blogMax = blogHeight > blogMax ? blogHeight : blogMax;
            });
            home_blog_post.css('min-height', blogMax);
        });

        /*-----------------------------------------------------------------*/
        /* Tabs for homepage services
        /*-----------------------------------------------------------------*/
        $('.tab-main .tab-title:first-of-type').css('margin-top', '30px').css('border-top', '1px solid #dcdee4');
        $('.tab-main .tab-content .content').first().css('display', 'block');
        $('.tab-main .tab-title').first().addClass("active");
        $(".tab-main .tab-title").click(function () {
            $(this).siblings().removeClass("active").end().andSelf().addClass("active");
            var tab = $(this).index();
            var content = $('.content');
            content.stop(true, true).hide().velocity({opacity: 0}, 500);
            $('.content:eq(' + tab + ')').stop(true, true).show().velocity({opacity: 1}, 500);
        });




        /*----------------------------------------------------------------------------------*/
        /* Textarea Auto Size
        /*---------------------------------------------------------------------------------- */
        if (jQuery().autosize) {
            $('#appointment_form_two textarea').autosize();
            $('#appointment_form_three textarea').autosize();
            $('#appointment_form_main textarea').autosize();
        }


        /*-----------------------------------------------------------------*/
        /* Animated Buttons Effects
        /*-----------------------------------------------------------------*/
        var animatedButton = $(this).find('a.transition-btn');
        animatedButton.wrapInner().wrapInner('<i>');
        animatedButton.append('<span>');

        /*-----------------------------------------------------------------*/
        /* Placeholder Fix in ie9
        /*-----------------------------------------------------------------*/
        if ($.browser.msie) {
            var ie_version = $.browser.version === '8.0' || $.browser.version === '9.0';
            if (ie_version) {
                (function ($) {
                    $.fn.placehold = function (placeholderClassName) {
                        var placeholderClassName = placeholderClassName || "placeholder",
                            supported = $.fn.placehold.is_supported();

                        function toggle() {
                            for (var i = 0; i < arguments.length; i++) {
                                arguments[i].toggle();
                            }
                        }

                        return supported ? this : this.each(function () {
                            var $elem = $(this),
                                placeholder_attr = $elem.attr("placeholder");

                            if (placeholder_attr) {
                                if ($elem.val() === "" || $elem.val() == placeholder_attr) {
                                    $elem.addClass(placeholderClassName).val(placeholder_attr);
                                }

                                if ($elem.is(":password")) {
                                    var $pwd_shiv = $("<input />", {
                                        "class": $elem.attr("class") + " " + placeholderClassName,
                                        "value": placeholder_attr
                                    });

                                    $pwd_shiv.bind("focus.placehold", function () {
                                        toggle($elem, $pwd_shiv);
                                        $elem.focus();
                                    });

                                    $elem.bind("blur.placehold", function () {
                                        if ($elem.val() === "") {
                                            toggle($elem, $pwd_shiv);
                                        }
                                    });

                                    $elem.hide().after($pwd_shiv);
                                }

                                $elem.bind({
                                    "focus.placehold": function () {
                                        if ($elem.val() == placeholder_attr) {
                                            $elem.removeClass(placeholderClassName).val("");
                                        }
                                    },
                                    "blur.placehold": function () {
                                        if ($elem.val() === "") {
                                            $elem.addClass(placeholderClassName).val(placeholder_attr);
                                        }
                                    }
                                });

                                $elem.closest("form").bind("submit.placehold", function () {
                                    if ($elem.val() == placeholder_attr) {
                                        $elem.val("");
                                    }

                                    return true;
                                });
                            }
                        });
                    };

                    $.fn.placehold.is_supported = function () {
                        return "placeholder" in document.createElement("input");
                    };
                })(jQuery);
                $("input, textarea").placehold("something-temporary");
            }
        }

        /*-----------------------------------------------------------------*/
        /* Sticky Header
        /*-----------------------------------------------------------------*/

        if ($('body').hasClass('sticky-header')) {

            $(window).scroll(function () {

                var $window = $(this);

                if ($window.width() > 600) {    // work only above 600px screen size
                    var $body = $('body');
                    var $header = $('#header');

                    /* get the admin bar height */
                    var adminBarHeight = 0;
                    if ($body.hasClass('admin-bar')) {
                        adminBarHeight = $('#wpadminbar').outerHeight();
                    }

                    /* header header top bar and header height */
                    var headerTopBarHeight = $('.header-top').outerHeight();
                    var headerHeight = $header.outerHeight();

                    if ($window.scrollTop() > headerTopBarHeight) {
                        $header.addClass('stick');
                        $header.css('top', adminBarHeight);
                        $body.css('padding-top', headerHeight);
                    } else {
                        $header.removeClass('stick');
                        $header.css('top', 'auto');
                        $body.css('padding-top', 0);
                    }
                }

            });
        }

    });

})(jQuery);






