(function ($) {
    "use strict";

    var $window = $(window),
        $body = $('body'),
        isRtl = $body.hasClass('rtl');

    /*-----------------------------------------------------------------------------------*/
    /*	Flex Slider
    /*  You can learn more about its options from http://www.woothemes.com/flexslider/
    /*-----------------------------------------------------------------------------------*/
    if (jQuery().flexslider) {

        // Flex Slider for gallery detail page
        $('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            reverse: false,
            slideshow: false,
            itemWidth: 123,
            minItems: 4,
            itemMargin: 10,
            asNavFor: '#slider'
        });

        $('#slider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel"
        });

        // Flex Slider Three for home testimonial section
        $('.flexslider-three').flexslider({
            animation: "fade",
            controlNav: false,
            directionNav: true,
            pauseOnHover: true,
            pauseOnAction: false,
            smoothHeight: true
        });

        // Flex Slider for services single
        $('.services-single .flexslider').flexslider({
            animation: "fade",
            controlNav: true,
            directionNav: false,
            pauseOnHover: true,
            pauseOnAction: false,
            smoothHeight: true
        });
    }

    /*-----------------------------------------------------------------*/
    /* Select2 - https://select2.github.io/
    /*-----------------------------------------------------------------*/
    $(window).on("load", function () {
        $('.woocommerce-ordering .orderby, .woocommerce .variations select, #calc_shipping_country, #product_cat').select2();
    });


    /*-----------------------------------------------------------------*/
    /* Isotopes Effects
    /*-----------------------------------------------------------------*/
    if (jQuery().isotope) {
        var $isotopeContainer = $('#isotope-container');

        $window.on('load', function () {
            $isotopeContainer.isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows'
            });
        });

        $('#filters').not('.no-isotope').on('click', 'a', function (event) {

            event.preventDefault();

            var $this = $(this),
                filterValue = $this.attr('data-filter');

            $(this).parents('li').addClass('active').siblings().removeClass('active');

            $isotopeContainer.isotope({
                filter: filterValue
            });
        });
    }

    /*-----------------------------------------------------------------*/
    /* For FAQ Groups Filtering
    /*-----------------------------------------------------------------*/
    $('#filters a.no-isotope').click(function (e) {
        e.preventDefault();
        $(this).parents('li').addClass('active').siblings().removeClass('active');
        var selector = $(this).attr('data-filter');
        var $questions = $('.toggle-main.faq').find('.toggle');
        if (selector == '*') {
            $questions.show();
        } else {
            $questions.not(selector).hide().end().filter(selector).show();
        }
    });


    /*----------------------------------------------------*/
    /* Tabs for tab widget
    /*----------------------------------------------------*/
    $('.tabs .tabs-content').first().css('display', 'block');
    $(".tabs .tab-head").click(function () {
        $(this).siblings().removeClass("active").end().andSelf().addClass("active");
        var tab = $(this).index();
        var content = $('.tabs-content');
        content.stop(true, true).hide().velocity({opacity: 0}, 500);
        $('.tabs-content:eq(' + tab + ')').stop(true, true).show().velocity({opacity: 1}, 500);
    });

    /*-----------------------------------------------------------------------------------*/
    /* Tabs
    /*-----------------------------------------------------------------------------------*/
    $(function () {

        var $tabsNav = $('.tabs-nav'),
            $tabsNavLis = $tabsNav.children('li');

        $tabsNav.each(function () {
            var $this = $(this);
            $this.next().children('.tab-content').stop(true, true).hide()
                .first().show();
            $this.children('li').first().addClass('active').stop(true, true).show();
        });

        $tabsNavLis.on('click', function (e) {
            var $this = $(this);
            if (!$this.hasClass('active')) {
                $this.siblings().removeClass('active').end()
                    .addClass('active');
                var idx = $this.parent().children().index($this);
                $this.parent().next().children('.tab-content').stop(true, true).hide().eq(idx).fadeIn();
            }
            e.preventDefault();
        });

    });

    /*-----------------------------------------------------------------*/
    /* Toggle
    /*-----------------------------------------------------------------*/
    $('.toggle-main .toggle:first-child').addClass('current')
        .find('i.fa').removeClass('fa-plus').addClass('fa-minus').end()
        .children('.toggle-content').css('display', 'block');

    $('.toggle-title').click(function () {
        var parent_toggle = $(this).closest('.toggle');
        if (parent_toggle.hasClass('current')) {
            $(this).find('i.fa').removeClass('fa-minus').addClass('fa-plus');
            parent_toggle.removeClass('current').children('.toggle-content').slideUp(300);
        } else {
            $(this).find('i.fa').removeClass('fa-plus').addClass('fa-minus');
            parent_toggle.addClass('current').children('.toggle-content').slideDown(300);
        }
    });


    /*-----------------------------------------------------------------*/
    /* Accordion
    /*-----------------------------------------------------------------*/
    $('.accordion-main .accordion:first-child').addClass('current')
        .children('.accordion-content').css('display', 'block').end()
        .find('i.fa').removeClass('fa-plus').addClass('fa-minus');

    $('.accordion-title').click(function () {
        var parent_accordion = $(this).closest('.accordion');
        if (parent_accordion.hasClass('current')) {
            $(this).find('i.fa').removeClass('fa-minus').addClass('fa-plus');
            parent_accordion.removeClass('current').children('.accordion-content').slideUp(300);
        } else {
            $(this).find('i.fa').removeClass('fa-plus').addClass('fa-minus');
            parent_accordion.addClass('current').children('.accordion-content').slideDown(300);
        }
        var siblings = parent_accordion.siblings('.accordion');
        siblings.find('i.fa').removeClass('fa-minus').addClass('fa-plus');
        siblings.removeClass('current').children('.accordion-content').slideUp(300);
    });

    /*-----------------------------------------------------------------------------------*/
    /* Scroll to Top
    /*-----------------------------------------------------------------------------------*/
    $(function () {
        $(window).scroll(function () {
            if (!$('body').hasClass('probably-mobile')) {
                if ($(this).scrollTop() > 250) {
                    $('a#scroll-top').fadeIn();
                } else {
                    $('a#scroll-top').fadeOut();
                }
            }
            else {
                $('a#scroll-top').fadeOut();
            }
        });

        $('a#scroll-top').on('click', function (event) {
            event.preventDefault();
            $('html, body').velocity("scroll", {duration: 750, easing: "swing"});
        });
    });

    /*-----------------------------------------------------------------*/
    /* Swipe Box
    /*-----------------------------------------------------------------*/
    if (jQuery().swipebox) {
        // Initialize the Lightbox automatically for any links to images with extensions .jpg, .jpeg, .png or .gif
        $("a[href$='.jpg'], a[href$='.png'], a[href$='.jpeg'], a[href$='.gif']").swipebox();
    }

    /*-----------------------------------------------------------------*/
    /* Date Picker
    /*-----------------------------------------------------------------*/
    if (jQuery().datepicker) {
        $("#datepicker").datepicker();
        $("#appointment-modal-form-datepicker").datepicker();
    }

    /*-----------------------------------------------------------------*/
    /* Message
    /*-----------------------------------------------------------------*/
    $('.message .close').click(function (e) {
        $(this).closest('.message').slideUp(300);
    });

    /*-----------------------------------------------------------------*/
    /* Animations Effects
    /*-----------------------------------------------------------------*/
    $('.animated').appear();

    $(document.body).on('appear', '.fade', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-fade');
        });
    });
    $(document.body).on('appear', '.slide-animate', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-slide-animate');
        });
    });
    $(document.body).on('appear', '.hatch', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-hatch');
        });
    });
    $(document.body).on('appear', '.entrance', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-entrance');
        });
    });
    $(document.body).on('appear', '.tada', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-tada');
        });
    });
    $(document.body).on('appear', '.rotate-up', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-rotate-up');
        });
    });
    $(document.body).on('appear', '.rotate-down', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-rotate-down');
        });
    });
    $(document.body).on('appear', '.fadeInDown', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-fadeInDown');
        });
    });
    $(document.body).on('appear', '.fadeInUp', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-fadeInUp');
        });
    });
    $(document.body).on('appear', '.fadeInLeft', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-fadeInLeft');
        });
    });
    $(document.body).on('appear', '.fadeInRight', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-fadeInRight');
        });
    });
    $(document.body).on('appear', '.fadeInDownBig', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-fadeInDownBig');
        });
    });
    $(document.body).on('appear', '.fadeInUpBig', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-fadeInUpBig');
        });
    });
    $(document.body).on('appear', '.fadeInLeftBig', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-fadeInLeftBig');
        });
    });
    $(document.body).on('appear', '.fadeInRightBig', function () {
        $(this).each(function () {
            $(this).addClass('ae-animation-fadeInRightBig');
        });
    });


    if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
        // Yep, it's Safari =)
        $('body').addClass('safari');
    }

    /*----------------------------------------------------------------------------------*/
    /* Contact Form AJAX validation and submission
    /* Validation Plugin : http://bassistance.de/jquery-plugins/jquery-plugin-validation/
    /* Form Ajax Plugin : http://www.malsup.com/jquery/form/
    /*---------------------------------------------------------------------------------- */
    if (jQuery().validate && jQuery().ajaxSubmit) {

        jQuery.validator.addMethod("phoneNumber", function(value, element) {
            return this.optional(element) || /^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/.test(value);
        }, "Please specify the correct phone number");

        /* Contact Form Handler */
        var contact_loader = $('#contact-loader'),
            response_container = $('#response-container'),
            error_container = $("#error-container"),
            submit_button = $('#contact-form-submit'),
            contact_form = $('#contact_form');

        contact_loader.fadeOut('fast');

        var contact_options = {
            beforeSubmit: function () {
                contact_loader.fadeIn('fast');
                response_container.fadeOut('fast');
                submit_button.attr('disabled', 'disabled');
                contact_loader.fadeOut('fast');
            },
            success: function (ajax_response, statusText, xhr, $form) {
                var response = $.parseJSON(ajax_response);
                contact_loader.fadeOut('fast');
                submit_button.removeAttr('disabled');
                if (response.success) {
                    $form.resetForm();
                    response_container.html(response.message).fadeIn('fast');
                } else {
                    error_container.html(response.message).fadeIn('fast');
                }
            }
        };

        contact_form.validate({
            errorLabelContainer: error_container,
            submitHandler: function (form) {
                $(form).ajaxSubmit(contact_options);
            }
        });


       /* Modal Appointment form handler */
        var modal_appointment_form = $('#appointment_modal_form'),
            modal_appointment_loader = modal_appointment_form.find('#appointment-loader'),
            modal_appointment_message_container = modal_appointment_form.find('#message-sent'),
            modal_appointment_error_container =  modal_appointment_form.find('#error-container'),
            modal_appointment_form_options = {
            beforeSubmit: function () {
                modal_appointment_loader.fadeIn('fast');
                modal_appointment_message_container.fadeOut('fast');
                modal_appointment_form.find('.btn').attr('disabled', 'disabled');
            },
            success: function (ajax_response, statusText, xhr, $form) {
                var response = $.parseJSON(ajax_response);
                modal_appointment_loader.hide();
                modal_appointment_form.find('.btn').removeAttr('disabled');
                if (response.success) {
                    $form.resetForm();
                    modal_appointment_message_container.html(response.message).fadeIn('fast');
                    if (typeof response.redirect != 'undefined' && response.redirect) {
                        window.location.href = response.redirect;
                    }
                } else {
                    modal_appointment_error_container.html(response.message).fadeIn('fast');
                }
            }
        };

        modal_appointment_form.validate({
            errorLabelContainer: modal_appointment_error_container,
            submitHandler: function (form) {
                $(form).ajaxSubmit(modal_appointment_form_options);
            }
        });

        /* 1st Appointment form handler */
        var appointment_loader = $('#appointment-loader'),
            message_container = $('#message-sent'),
            appointment_form_one = $('#appointment_form_one');

        var appointment_options = {
            beforeSubmit: function () {
                appointment_loader.fadeIn('fast');
                message_container.fadeOut('fast');
                appointment_form_one.find('.btn').attr('disabled', 'disabled');
            },
            success: function (ajax_response, statusText, xhr, $form) {
                var response = $.parseJSON(ajax_response);
                appointment_loader.hide();
                appointment_form_one.find('.btn').removeAttr('disabled');
                if (response.success) {
                    $form.resetForm();
                    if (typeof response.redirect != 'undefined' && response.redirect) {
                        window.location.href = response.redirect;
                    }
                }
                message_container.html(response.message).fadeIn('fast');
            }
        };

        appointment_form_one.validate({
            submitHandler: function (form) {
                $(form).ajaxSubmit(appointment_options);
            }
        });


        /* 2nd Appointment form handler */
        var appointment_form_two = $('#appointment_form_two');
        var appointment_options_two = {
            beforeSubmit: function () {
                appointment_loader.fadeIn('fast');
                message_container.fadeOut('fast');
                appointment_form_two.find('.btn').attr('disabled', 'disabled');
            },
            success: function (ajax_response, statusText, xhr, $form) {
                var response = $.parseJSON(ajax_response);
                appointment_loader.hide();
                appointment_form_two.find('.btn').removeAttr('disabled');
                if (response.success) {
                    $form.resetForm();
                    if (typeof response.redirect != 'undefined' && response.redirect) {
                        window.location.href = response.redirect;
                    }
                }
                message_container.html(response.message).fadeIn('fast');
            }
        };

        appointment_form_two.validate({
            submitHandler: function (form) {
                $(form).ajaxSubmit(appointment_options_two);
            }
        });


        /* 3rd Appointment form handler */
        var appointment_form_three = $('#appointment_form_three');
        var appointment_options_three = {
            beforeSubmit: function () {
                appointment_loader.fadeIn('fast');
                message_container.fadeOut('fast');
                contact_loader.fadeOut('fast');
                appointment_form_two.find('.btn').attr('disabled', 'disabled');
            },
            success: function (ajax_response, statusText, xhr, $form) {
                var response = $.parseJSON(ajax_response);
                appointment_loader.hide();
                appointment_form_two.find('.btn').removeAttr('disabled');
                if (response.success) {
                    $form.resetForm();
                    message_container.html(response.message).fadeIn('fast');
                    if (typeof response.redirect != 'undefined' && response.redirect) {
                        window.location.href = response.redirect;
                    }
                } else {
                    error_container.html(response.message).fadeIn('fast');
                }
            }
        };

        appointment_form_three.validate({
            errorLabelContainer: error_container,
            submitHandler: function (form) {
                $(form).ajaxSubmit(appointment_options_three);
            }
        });

        /* Main Appointment form handler */
        var appointment_form_main = $('#appointment_form_main');
        var appointment_options_main = {
            beforeSubmit: function () {
                appointment_loader.fadeIn('fast');
                message_container.fadeOut('fast');
                contact_loader.fadeOut('fast');
            },
            success: function (ajax_response, statusText, xhr, $form) {
                var response = $.parseJSON(ajax_response);
                appointment_loader.hide();
                if (response.success) {
                    $form.resetForm();
                    message_container.html(response.message).fadeIn('fast');
                    if (typeof response.redirect != 'undefined' && response.redirect) {
                        window.location.href = response.redirect;
                    }
                } else {
                    error_container.html(response.message).fadeIn('fast');
                }
            }
        };

        appointment_form_main.validate({
            errorLabelContainer: error_container,
            submitHandler: function (form) {
                $(form).ajaxSubmit(appointment_options_main);
            }
        });
    }
})(jQuery);