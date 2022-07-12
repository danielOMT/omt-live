// if ('ontouchstart' in document.documentElement) {
//     document.addEventListener('touchstart', onTouchStart, {passive: true});
// }
// IE8 ployfill for GetComputed Style (for Responsive Script below)
if (!window.getComputedStyle) {
    window.getComputedStyle = function(el, pseudo) {
        this.el = el;
        this.getPropertyValue = function(prop) {
            var re = /(\-([a-z]){1})/g;
            if (prop == 'float') {
                prop = 'styleFloat';
            }
            if (re.test(prop)) {
                prop = prop.replace(re, function () {
                    return arguments[2].toUpperCase();
                });
            }
            return el.currentStyle[prop] ? el.currentStyle[prop] : null;
        }
        return this;
    }
}


function smoothscroll() {
    $('.wrapper a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 0);
                return false;
            }
        }
    });
}

function header_search_icon() {
    $(".header-search-icon").click(function () {
        $('.header-search-input').toggleClass('header-search-input-active');
        $(this).toggleClass('search-icon-active');
    });
}

function close_hero_countdown() {
    $(".close-countdown").click(function () {
       $('.hero-countdown-wrap').css('display', 'none');
    });
}

function accordion() {
    // Accordion
    var acc_item = $(".accordion-item");
    var acc_first = acc_item.eq(0);

    if (!$(".accordion-item").hasClass("initial-closed")) {
        acc_first.find(".accordion-title span").toggleClass("fa-plus").toggleClass("fa-minus");
        acc_first.find(".accordion-content").slideDown();
        acc_first.addClass("active");
    }

    $(".accordion-title").click(function () {
        $(this).parent().toggleClass("active");
        $("span", this).toggleClass("fa-plus").toggleClass("fa-minus");
        $(this).next().slideToggle();
    });

    //Accordion for Tools
    var acc_item = $(".tools-accordion-item");
    var acc_first = acc_item.eq(0);

    if (!$(".tools-accordion-item").hasClass("initial-closed")) {
        acc_first.find(".tools-accordion-title span").toggleClass("fa-plus").toggleClass("fa-minus");
        acc_first.find(".tools-accordion-content").slideDown();
        acc_first.addClass("active");
    }

    $(".tools-accordion-title").click(function () {
        $("span", this).toggleClass("fa-plus").toggleClass("fa-minus");
        $(this).next().toggleClass('semi-closed');
        $(this).parent().find('.button-weiterlesen').toggleClass('button-visible');
    });
    $('.tools-accordion-item .button-weiterlesen').click(function () {
        $(this).toggleClass('button-visible');
        $(this).parent().find('.tools-accordion-title .fa').toggleClass("fa-plus").toggleClass("fa-minus");
        $(this).parent().find('.tools-accordion-content').toggleClass('semi-closed');
    });
}

function checkbox() {
    // forms checkbox
    if (!$('body').hasClass('woocommerce-checkout')) {
        $("form #login input[type=checkbox]").not(".hidden").hide().after("<span class='checkbox'><i class='fa fa-check has-gradient'></i></span>");
        // $(".gform_wrapper form input[type=checkbox]").not(".hidden").hide().after("<span class='checkbox'><i class='fa fa-check has-gradient'></i></span>");
        $(".checkbox").closest("label").addClass("checkbox-label");
        $(".checkbox").click(function () {
            $(this).toggleClass("checked");
            $(this).closest("input[type=checkbox]").trigger("click");
        });

        $(".checkbox-label").click(function (e) {
            var checkbox = $(e.target).find(".checkbox");
            checkbox.toggleClass("checked");
            $(".checkbox", this).closest("input[type=checkbox]").trigger("click");
        });
    }
}
/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
/////////////////PROGRESSBAR////////////////////////////////////////////////////
function progressbar_init() {
    var numItems = $('.inhaltsverzeichnis-wrap').length;
    if (numItems > 0) {
        var winHeight = $(window).height(),
            docHeight = $(document).height(),
            progressBar = $('progress'),
            max, value;

        /* Set the max scrollable area */
        max = docHeight - winHeight;
        progressBar.attr('max', max);

        $(document).on('scroll', function(){
            value = $(window).scrollTop();
            progressBar.attr('value', value);
        });
    }
}

function progressbar_scroll() {
    value = $(window).scrollTop();
    progressBar.attr('value', value);
}
/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
/////////////////PROGRESSBAR END////////////////////////////////////////////////


/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
///////////AUTOMATIC INDEX GENERATOR////////////////////////////////////////////
function generate_index() {
    var numItems = $('.inhaltsverzeichnis-wrap').length;
    var numindex = $('.inhaltsverzeichnis-index').length;
    var numItems_shortcode = $('.inhaltsverzeichnis-shortcode').length;
    if (!numindex > 0) {
        if (numItems > 0 || numItems_shortcode > 0) {
            $(".ul.inhaltsverzeichnis").append('<p>Inhaltsverzeichnis:</p>');
            $(".entry-content h2, .omt-row h2").each(function (i) {
                if (!$(this).hasClass("no-ihv")) {
                    if ($(this).is(":visible")) {
                        var current = $(this);
                        var headline_name = $(this).text();
                        headline_name = headline_name.trim().replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '-').replace(/^(-)+|(-)+$/g, '').replace('-–-', '-').replace('-–', '-').toLowerCase();

                        $("<span class='anchor' id='" + headline_name + "'></span>").insertBefore(current);
                        $(".inhaltsverzeichnis").append("<li><a id='link" + i + "' href='#" +
                            headline_name + "' title='" + current.html() + "'>" +
                            current.html() + "</a></li>");
                    }
                }
            });
        }
    }
}

function regenerate_index() {
    $('.tabcontent .anchor').remove();
    $("ul.inhaltsverzeichnis").html('<p class="index_header">Inhaltsverzeichnis:</p>');
    $(".entry-content h2, .omt-row h2").each(function (i) {
        if (!$(this).hasClass("no-ihv")) {
            if ($(this).is(":visible")) {
                var current = $(this);

                $("<span class='anchor' id='title" + i + "'></span>").insertBefore(current);
                $('span.anchor').css('bottom', '370px');
                $('span#selected').css('bottom', '220px');
                $(".inhaltsverzeichnis").append("<li><a id='link" + i + "' href='#title" +
                    i + "' title='" + current.html() + "'>" +
                    current.html() + "</a></li>");
            }
        }
    });

    inhaltsverzeichnis_ac();
}

function inhaltsverzeichnis_ac() {
    var numItems = $('.inhaltsverzeichnis-wrap').length;
    var numItems_shortcode = $('.inhaltsverzeichnis-shortcode').length;
    if (numItems > 0 || numItems_shortcode > 0) {
        $('.index_header').click(function () {
            $(this).toggleClass("index_header-active");
            $('.inhaltsverzeichnis').toggleClass('inhaltsverzeichnis-active');
            /*$('.ac-headline').not($(this)).removeClass('active');
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
            if (!$(this).hasClass("active")) {
                this.nextElementSibling.style.maxHeight = null;
            }*/
        });
        $('.inhaltsverzeichnis-wrap  .inhaltsverzeichnis li a').click(function () {
            $('.inhaltsverzeichnis').removeClass("inhaltsverzeichnis-active");
            $('.index_header').removeClass("index_header-active");

            var href = $(this).attr('href');

            // Delay setting the location for one second
            var numItems = $('.module-tabs').length;
            if (numItems >0) { var timeout = 0; } else { var timeout = 1050; }
            setTimeout(function () {
                window.location = href
            }, timeout);
            return false;
        });
        $('.inhaltsverzeichnis-module  .inhaltsverzeichnis li a').click(function () {
            $('.inhaltsverzeichnis').removeClass("inhaltsverzeichnis-active");
            $('.index_header').removeClass("index_header-active");

            var href = $(this).attr('href');

            // Delay setting the location for one second
            var numItems = $('.module-tabs').length;
            if (numItems >0) { var timeout = 0; } else { var timeout = 1050; }
            setTimeout(function () {
                window.location = href
            }, timeout);
            return false;
        });
    }
}

function inhaltsverzeichnis_sticky() {
    var numItems = $('.module-tabs').length;
    if (numItems >0) {
        $('.inhaltsverzeichnis').css('transition', '0ms');

    } else { //dont make it sticky if tabs-module on page!
        var numItems = $('.inhaltsverzeichnis-wrap').length;
        var has_inhaltsmodule = $('.inhaltsverzeichnis-module').length;
        var hasinhaltsmodule = false;
        if (has_inhaltsmodule>0) { hasinhaltsmodule = true; }
        if (numItems > 0 && hasinhaltsmodule != true) {
            if ($(window).scrollTop() >= 650) {
                $('.inhaltsverzeichnis-wrap').addClass('inhaltsverzeichnis-sticky');
                $('.inhaltsverzeichnis-wrap').addClass('inhaltsverzeichnis-show');

            }
            $(window).scroll(function () {
                if ($(window).scrollTop() >= 385) {
                    $('.inhaltsverzeichnis-wrap').addClass('inhaltsverzeichnis-sticky');
                } else {
                    $('.inhaltsverzeichnis-wrap').removeClass('inhaltsverzeichnis-sticky');
                }
                if ($(window).scrollTop() >= 385) {
                    $('.inhaltsverzeichnis-wrap').addClass('inhaltsverzeichnis-show');
                    $('.article-header').css("margin-top", "95px");
                } else {
                    $('.inhaltsverzeichnis-wrap').removeClass('inhaltsverzeichnis-show');
                    $('.article-header').css("margin-top", "30px");
                }
                var scroll = $(window).scrollTop(); // how many pixels you've scrolled
                var os = $('footer').offset().top; // pixels to the top of div1
                var ht = $('footer').height(); // height of div1 in pixels
                // if you've scrolled further than the top of div1 plus it's height
                // change the color. either by adding a class or setting a css property
                if (scroll > os - ht) {
                    $('.inhaltsverzeichnis-wrap').removeClass('inhaltsverzeichnis-show');
                    $('.article-header').css("margin-top", "30px");
                    $('.inhaltsverzeichnis-wrap').removeClass('inhaltsverzeichnis-sticky');
                }
            });
            //$('.inhaltsverzeichnis-wrap').stick_in_parent({offset_top: 53});
        }
    }
}
/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
///////////AUTOMATIC INDEX GENERATOR END////////////////////////////////////////////


/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
///////////VIDEO LIGHTBOX FUNCTIONS////////////////////////////////////////////

function toggle_video_area() {
    $(".open-video").click(function () {
        var vid_id = $(this).data("id");
        var vid_type = $(this).data("type");
        //console.log(vid_id);
        // console.log(vid_type);
        if (vid_type == "youtube") {
            var html_youtube = "<div class='vidembed_wrap'><div class='vidembed'><iframe title='YouTube video player' src='https://www.youtube.com/embed/" + vid_id + "'?enablejsapi=1' frameborder='0'  allowfullscreen width='730' height='400'></iframe></div></div>";
        }
        if (vid_type == "wistia") {
            var html_wistia = '<iframe src="//fast.wistia.net/embed/iframe/' +vid_id + '" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen width="730" height="400"></iframe><script src="//fast.wistia.net/assets/external/E-v1.js" async></script>';
            var html_vistia = '<script src="//fast.wistia.com/embed/medias/' + vid_id + '.jsonp" async></script><script src="//fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding"><div class="wistia_responsive_wrapper"><div class="wistia_embed wistia_async_' + vid_id + '">&nbsp;</div></div></div>';
        }

        if (vid_type == "youtube") {
            $("#lightbox-area #login-cnt").html(html_youtube);
            $("#lightbox-area #login-cnt").addClass('lightbox-video');
        }
        if (vid_type == "wistia") {
            $("#lightbox-area #login-cnt").html(html_wistia);
            $("#lightbox-area #login-cnt").addClass('lightbox-video');
        }
        $("#lightbox-area").fadeIn().addClass("open");
        return false;
    });
}

///////////END OF VIDEO LIGHTBOX FUNCTIONS////////////////////////////////////////////

/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
///////////LOGIN FUNCTIONS////////////////////////////////////////////
// Toggle Login area
function toggle_login_area() {
    $(".button-login").click(function () {
        if ( $(this).hasClass('button-login')) {
//            $("#login-area").slideToggle().toggleClass("open").toggleClass("hidden");
            //$("header").toggleClass("login-open");
            $("#login-area").fadeIn().addClass("open");
            return false;
        }
    });
}

// Login Area checkbox keep-logged-in
function login_area_checkbox() {
    $("#keep-logged-in").click(function () {
        $(this).toggleClass("checked");
        $("input[name=keeploggedin]").trigger("click");
        return false;
    });
}
/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
///////////LOGIN FUNCTIONS END////////////////////////////////////////////

/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
///////////DROPDOWN MENU / SUB-MENU STYLES////////////////////////////////////////////
// Mega dropnav
var megaDropNavClosingHandler = null;

function megaDropNavClose() {
    clearTimeout(megaDropNavClosingHandler);

    megaDropNavClosingHandler = setTimeout(() => {
        $("#mega-dropnav").slideUp();
    }, 100);  
}

function mega_dropnav() {
    $(".nav > ul > li.menu-item-has-children:not('.toggle-mobile-nav') > a").hoverIntent(
        function() {
            var that = $("ul", $(this).parent());

            $("#mega-dropnav").slideUp(300, function() {
                $("#mega-dropnav > .container").empty();
                that.clone().appendTo("#mega-dropnav > .container");
                $(this).hide().removeClass("hidden").slideDown();
            });
        },
        function() {}
    );

    $(".nav > ul > li:not(.menu-item-has-children) > a").mouseenter(() => megaDropNavClose());
    $("#mega-dropnav, .nav > ul").mouseleave(() => megaDropNavClose());
    $("#mega-dropnav").mouseenter(() => clearTimeout(megaDropNavClosingHandler));
}

/******************************************************************************/
/******************************************************************************/
/******************************************************************************/
///////////DROPDOWN MENU / SUB-MENU STYLES END////////////////////////////////////////////


// lightbox
function login_lightbox() {
    $(document).click(function (e) {
        if (!$(e.target).is("#login-cnt,#login-cnt div, #login-cnt form, #login-cnt a, #login-cnt p, #login-cnt input, #login-cnt .contact-lightbox, .lightbox .contact-lightbox, .lightbox .contact-lightbox .gform_wrapper, .lightbox.contact-lightbox .ginput_container, ul, li, ul li, select, label, span, option, textarea, .gform_wrapper")) {
            if ($("#lightbox-area #login-cnt").hasClass('lightbox-video')) {
                $('#lightbox-area #login-cnt').html("");
            }
            if($(e.target).parents('.gform_wrapper').length > 0) {

            } else {
                $(".lightbox").fadeOut(function () {
                    $(this).removeClass("open");
                });
            }
        }
    });
}

// match height
function matchheight() {
    $(".teaser").matchHeight();
}

//activate forms with the corresponding button (fadein/lightbox):
function activate_form() {
    $(".activate-form").click(function (event) {
        event.preventDefault();

        let effect = $(this).data("effect");

        if ("fadein" == effect) {
            $('.contact-fade').css('max-height', '10000px');
        }

        if (effect == "lightbox") {
            let formId = $(this).data("id");
            let lightboxForm = $("#lightbox-area > .contact-lightbox");
            let setNewForm = true;

            if (lightboxForm.length) {
                if (lightboxForm.attr('id') == formId) {
                    setNewForm = false;
                } else {
                    // Move the previous form if exist to the triggered button
                    lightboxForm.hide();
                    $('a[data-id="' + lightboxForm.attr('id') + '"]').after(lightboxForm);
                }
            }

            if (setNewForm) {
                $("#lightbox-area").html($("#" + formId));
            }
            
            $("#lightbox-area #" + formId).css('display','block');
            $("#lightbox-area").fadeIn().addClass("open");

            return false;
        }
    });

    let urlParams = new URLSearchParams(window.location.search);
    let triggeredFormId = urlParams.get('gf-form');

    if (triggeredFormId) {
        $(".activate-form[data-id='form-" + triggeredFormId + "']").trigger("click");
    }
}

function terminbutton_sticky() {
    /*    var numItems = $('.button-termine').length;
        if (numItems > 0) {
            if ($(window).scrollTop() >= 650) {
                $('.button-termine').addClass('termine-sticky');
                $('.button-termine').addClass('termine-show');

            }
            $(window).scroll(function () {
                if ($(window).scrollTop() >= 385) {
                    $('.button-termine').addClass('termine-sticky');
                    $('.article-header').css("margin-top", "65px");
                }
                else {
                    $('.button-termine').removeClass('termine-sticky');
                    $('.article-header').css("margin-top", "0px");
                }
                if ($(window).scrollTop() >= 385) {
                    $('.button-termine').addClass('termine-show');
                }
                else {
                    $('.button-termine').removeClass('termine-show');
                }
                var scroll = $(window).scrollTop(); // how many pixels you've scrolled
                var os = $('footer').offset().top; // pixels to the top of div1
                var ht = $('footer').height(); // height of div1 in pixels
                // if you've scrolled further than the top of div1 plus it's height
                // change the color. either by adding a class or setting a css property
                if(scroll > os-ht){
                    $('.button-termine').removeClass('termine-show');
                    $('.article-header').css("margin-top", "0px");
                    $('.button-termine').removeClass('termine-sticky');
                }
            });
            //$('.inhaltsverzeichnis-wrap').stick_in_parent({offset_top: 53});
        }*/
}

function initStickyToHeader() {
    var numItems = $('.button-termine').length;
    var numcountdown = $('.countdown').length;
    var numtabs = $('.tab-buttons').length;
    var numherocountdown = $('.hero-countdown-wrap').length;
    var numberthemenwelt = $('.header-themenwelt-flat').length;
    var numinhaltsmodule = $('.inhaltsverzeichnis-module').length;
    var numterminesticky = $('.termine-sticky').length;
    var numjobbutton = $('.header-jobs-button').length;
    var auswahlboxen = $('.auswahlboxen-wrap').length;
//    var seminaresidebar = $('.single-seminare .widget-shortinfo').length;
    if (numItems > 0 && numcountdown < 1) {
        var ht = $('header').height(); // height of div1 in pixels
        elementOffset = $('.button-termine').offset().top;
        $(window).on('scroll', function () {
            var scrollTop     = $(window).scrollTop();
            var distance      = (elementOffset - scrollTop - ht);
            if (distance < 10) {
                $('.button-termine').addClass('termine-sticky');
                $('.article-header').css("margin-top", "65px");
            }
            else {
                $('.button-termine').removeClass('termine-sticky');
                $('.article-header').css("margin-top", "0px");
            }
            if (distance < 10) {
                $('.button-termine').addClass('termine-show');
            }
            else {
                $('.button-termine').removeClass('termine-show');
            }
        });
    }
    if (numcountdown > 0 ) {
        var ht = $('header').height(); // height of div1 in pixels
        elementOffset = $('.countdown').offset().top;
        timeroffset = 0 - $('.countdown-grid-timer').offset().top + elementOffset + ht;
        $(window).on('scroll', function () {
            var scrollTop     = $(window).scrollTop();
            var distance      = (elementOffset - scrollTop - ht);
            if (distance < 10) {
                $('.countdown').addClass('countdown-sticky');
                $('.countdown').css('top', timeroffset);
                $('.article-header').css("margin-top", "65px");
            }
            else {
                $('.countdown').removeClass('countdown-sticky');
                $('.article-header').css("margin-top", "0px");
            }
            if (distance < 10) {
                $('.countdown').addClass('termine-show');
            }
            else {
                $('.countdown').removeClass('termine-show');
            }
        });
    }

    if (numherocountdown > 0 ) {
        var ht = $('header').height(); // height of div1 in pixels
        elementOffset = $('.hero-countdown-wrap').offset().top;
        $(window).on('scroll', function () {
            var scrollTop     = $(window).scrollTop();
            var distance      = (elementOffset - scrollTop - ht);
            if (distance < 10) {
                $('.hero-countdown-wrap').addClass('element-sticky');
                $('.article-header').css("margin-top", "115px");
            } else {
                $('.hero-countdown-wrap').removeClass('element-sticky');
                $('.article-header').css("margin-top", "0px");
            }
        });
    }

    if (numberthemenwelt > 0 ) {
        var ht = $('header').height(); // height of div1 in pixels
        themenweltelementOffset = $('.header-themenwelt-flat').offset().top;
        $(window).on('scroll', function () {
            var scrollTop     = $(window).scrollTop();
            var distance      = (themenweltelementOffset - scrollTop - ht);
            if (distance < 10) {
                $('.header-themenwelt-flat').addClass('element-sticky');
                $('.article-header').css("margin-top", "115px");
            } else {
                $('.header-themenwelt-flat').removeClass('element-sticky');
                $('.article-header').css("margin-top", "30px");
            }
        });
    }

    if (numjobbutton > 0 ) {
        var ht = $('header').height(); // height of div1 in pixels
        themenweltelementOffset = $('.header-jobs-button').offset().top;
        $(window).on('scroll', function () {
            var scrollTop     = $(window).scrollTop();
            var distance      = (themenweltelementOffset - scrollTop - ht);
            if (distance < 10) {
                $('.header-jobs-button').addClass('element-sticky');
            } else {
                $('.header-jobs-button').removeClass('element-sticky');
            }
        });
    }

    //seminar Einzelseite Flat Sticky
    if (numterminesticky > 0 ) {
        var ht = $('header').height(); // height of div1 in pixels
        seminarelementOffset = $('.termine-sticky').offset().top;
        $(window).on('scroll', function () {
            var scrollTop     = $(window).scrollTop();
            var distancenavi      = (seminarelementOffset - scrollTop - ht);
            if (distancenavi < 10) {
                $('.termine-sticky').addClass('element-sticky');
                $('.article-header').css("margin-top", "115px");
            } else {
                $('.termine-sticky').removeClass('element-sticky');
                $('.article-header').css("margin-top", "30px");
            }
        });
    }

    if ($('.downloads-sticky-buttons').length > 0 ) {
        var ht = $('header').height(); // height of div1 in pixels
        elementOffset = $('.downloads-sticky-buttons').offset().top;

        $(window).on('scroll', function () {
            var scrollTop = $(window).scrollTop();
            var distancenavi = (elementOffset - scrollTop - ht);
            if (distancenavi < 10) {
                $('.downloads-sticky-buttons').parent().addClass('x-mb-24');
                $('.downloads-sticky-buttons').children('.downloads-sticky-buttons-wrap').addClass('wrap')
                $('.downloads-sticky-buttons').addClass('element-sticky');
            } else {
                $('.downloads-sticky-buttons').parent().removeClass('x-mb-24');
                $('.downloads-sticky-buttons').children('.downloads-sticky-buttons-wrap').removeClass('wrap')
                $('.downloads-sticky-buttons').removeClass('element-sticky');
            }
        });
    }

    //seminar Einzelseite SIDEBAR Sticky
    // if (seminaresidebar > 0 ) {
    //     var ht = $('header').height(); // height of div1 in pixels
    //     sidebarelementOffset = $('.single-seminare .widget-shortinfo').offset().top;
    //     $(window).on('scroll', function () {
    //         var scrollTop     = $(window).scrollTop();
    //         var sidebardistance      = (sidebarelementOffset - scrollTop - ht);
    //         if (sidebardistance < 10) {
    //             $('.single-seminare .widget-shortinfo').addClass('sidebar-sticky');
    //         } else {
    //             $('.single-seminare .widget-shortinfo').removeClass('sidebar-sticky');
    //         }
    //     });
    // }

    //inhaltsverzeichnis MODULE sticky
    if (numinhaltsmodule > 0 ) {
        var num_themenwelt_alt_header = $('.header-themenwelt-flat').length;
        var singletool = $('.single-tool').length;
        if (num_themenwelt_alt_header < 1 && singletool < 1) {
            var ht = $('header').height(); // height of div1 in pixels
            elementOffset = $('.inhaltsverzeichnis-module').offset().top;
            var firstscroll = true;
            var scrollafterlazy = true;
            $(window).on('scroll', function () {
                if (scrollafterlazy != false) {
                    elementOffset = $('.inhaltsverzeichnis-module').offset().top;
                }
                var scrollTop = $(window).scrollTop();
                var distance = (elementOffset - scrollTop - ht);
                //console.log("scrolltop"+scrollTop+"element"+elementOffset+"distance"+distance);
                if (distance < 10) {
                    $('.inhaltsverzeichnis-module').addClass('termine-sticky');
                    if (true == firstscroll) {
                        scrollafterlazy = false;
                        firstscroll = false;
                        //   var moduleheight = $('.inhaltsverzeichnis-module').height();
                        //  var screenheight = $(window).height();
                        //   if (moduleheight > screenheight) { moduleheight = screenheight/3; }
                        $('.inhaltsverzeichnis-module .inhaltsverzeichnis').removeClass('inhaltsverzeichnis-active');
                        $('.inhaltsverzeichnis-module').removeClass('inhaltsverzeichnis-alternate');
                        $('.inhaltsverzeichnis-module .inhaltsverzeichnis .index_header').removeClass('index_header-active');
                        $('#content').css("margin-top", "150px");
                        // elementOffset += 150;
                    }
                } else {
                    $('.inhaltsverzeichnis-module').removeClass('termine-sticky');
                    $('#content').css("margin-top", "0px");
                    // $('.article-header').css("margin-top", "0px");
                }
            });
        }
    }

    if ($('.team-members-gallery-section').length > 0 && $(window).width() >= 768) {
        var ht = $('header').height()
        let elementOffset = $('.team-members-gallery-section').offset().top;
        let elementHeight = $('.team-members-gallery-section').height();

        $(window).on('scroll', function () {
            var distance = (elementOffset + elementHeight - $(window).scrollTop() - ht);

            if (distance < 0) {
                $('.team-members-gallery-section').prev().css({ 'margin-bottom': elementHeight + 100 });
                $('.team-members-gallery-section').addClass('element-sticky');
            } else {
                $('.team-members-gallery-section').prev().css({ 'margin-bottom': 0 });
                $('.team-members-gallery-section').removeClass('element-sticky');
            }
        });
    }

    if ($('.header-omt-filter').length > 0 ) {
        var ht = $('header').height()
        let elementOffset = $('.header-omt-filter').offset().top;
        let elementHeight = $('.header-omt-filter').height();

        $(window).on('scroll', function () {
            var distance = (elementOffset + elementHeight - $(window).scrollTop() - ht);

            if (distance < 0) {
                $('.header-omt-filter').css({ 'margin-bottom': elementHeight + 100 });
                $('.header-omt-filter').css({ 'padding': '5px' });
                $('.header-omt-filter').addClass('element-sticky');
            } else {
                $('.header-omt-filter').css({ 'margin-bottom': 0 });
                $('.header-omt-filter').css({ 'padding': '30px 0'});
                $('.header-omt-filter').removeClass('element-sticky');
            }
        });
    }

    if (auswahlboxen > 0 ) {
        var ht = $('header').height(); // height of div1 in pixels
        elementOffset = $('.auswahlboxen-wrap').offset().top;

        $(window).on('scroll', function () {
            var scrollTop = $(window).scrollTop();
            var distancenavi = (elementOffset - scrollTop - ht);
            if (distancenavi < 10) {
                $('.auswahlboxen-wrap').addClass('element-sticky');
                $('.auswahlboxen-wrap').addClass('auswahlboxen-sticky');
            } else {
                $('.auswahlboxen-wrap').removeClass('element-sticky');
                $('.auswahlboxen-wrap').removeClass('auswahlboxen-sticky');
            }
        });
    }
}

function konferenz_countdown() {
    var numItems = $('.countdown-grid-timer').length;
    if (numItems > 0) {
        var data_time = $('.countdown-grid-timer').attr('data-time');
        $('.countdown-grid-timer').countdown(data_time, function (event) {
            $(this).html(event.strftime(
                '<div class="countdown-grid-time  countdown-days"><p class="countdown-time days">%D</p><p class="countdown-unit">&nbsp;TAGE</p></div>'
                + '<div class="countdown-grid-time  countdown-hours"><p class="countdown-time hours">%H</p><p class="countdown-unit">&nbsp;STD</p></div>'
                + '<div class="countdown-grid-time  countdown-minutes"><p class="countdown-time minutes">%M</p><p class="countdown-unit">&nbsp;MIN</p></div>'
                + '<div class="countdown-grid-time  countdown-seconds"><p class="countdown-time seconds">%S</p><p class="countdown-unit">&nbsp;SEK</p></div>'));
        });
    }
}

function magnificpopup() {
    //for singles and articles:
    if ($("body").hasClass("single")) {
        $('a[href]').filter(function () {
            return /(jpg|gif|png)$/.test($(this).attr('href'))
        }).addClass('img-lightbox');
        $('.single .entry-content .img-lightbox').magnificPopup({
            type: 'image'
            // other options
        });


        $(".entry-content > img").click(function () {
            $.magnificPopup.open({
                items: {
                    src: "<img class='single-lightbox' src='" + $(this).attr('src') + "'/>"
                },
                type: 'inline'
            });
        });

        $(".entry-content > .wp-caption > img").click(function () {
            $.magnificPopup.open({
                items: {
                    src: "<img class='single-lightbox' src='" + $(this).attr('src') + "'/>"
                },
                type: 'inline'
            });
        });


        $(".seminare-content-wrap #ubersicht img").click(function () {
            $.magnificPopup.open({
                items: {
                    src: "<img class='single-lightbox' src='" + $(this).attr('src') + "'/>"
                },
                type: 'inline'
            });
        });
    }


    //for themenwelt templates:
    var numItems = $('.template-themenwelt').length;
    var numSingle = $('.single').length;
    if (numItems > 0 /*&& numSingle < 1*/) {
        if ($('.inhaltseditor p').has('img')) {
            if (!$('.inhaltseditor p img').hasClass('emoji')) {
                $('.inhaltseditor p').has('img').css('width', '100%');
                $('.inhaltseditor a[href]').filter(function () {
                    return /(jpg|gif|png)$/.test($(this).attr('href'))
                }).addClass('img-lightbox');
                $('.img-lightbox').magnificPopup({
                    type: 'image'
                    // other options
                });


                $(".inhaltseditor p > img").click(function () {
                    $.magnificPopup.open({
                        items: {
                            src: "<img class='single-lightbox' src='" + $(this).attr('src') + "'/>"
                        },
                        type: 'inline'
                    });
                });
                $(".inhaltseditor .wp-caption > img").click(function () {
                    $.magnificPopup.open({
                        items: {
                            src: "<img class='single-lightbox' src='" + $(this).attr('src') + "'/>"
                        },
                        type: 'inline'
                    });
                });
            }
        }
    }
    //AGENTURFINDER MODAL
    var numItems = $('#kontakt').length;
    var numItems_header = $('#kontakt-header').length;
    if (numItems > 0 || numItems_header > 0 /*&& numSingle < 1*/) {
        $('.contact-modal a').attr('data-effect', 'mfp-zoom-out'); //set data-effect attribute
        $('#content .omt-row .contact-modal a.agentursuche-button').click(function () {
            $('.contact-modal a').magnificPopup({
                removalDelay: 50, //delay removal by X to allow out-animation
                callbacks: {
                    beforeOpen: function () {
                        this.st.mainClass = this.st.el.attr('data-effect');
                    }
                },
                midClick: true//, // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
                // closeOnBgClick: false
            }).magnificPopup('open');
            event.preventDefault();
        });
    }
    if (numItems > 0 || numItems_header > 0 /*&& numSingle < 1*/) {
        $(".agenturfinder-dropdown").on('change', function() {
            var selected = $('.agenturfinder-dropdown option:selected').val();
            switch (selected) {
                case "affiliate-marketing": $('#gform_page_106_1 .gchoice_106_7_1 input').attr('checked', true); break;
                case "amazon-marketing": $('#gform_page_106_1 .gchoice_106_7_2 input').attr('checked', true); break;
                case "amazon-seo": $('#gform_page_106_1 .gchoice_106_7_3 input').attr('checked', true); break;
                case "contenterstellung": $('#gform_page_106_1 .gchoice_106_7_4 input').attr('checked', true); break;
                case "content-marketing": $('#gform_page_106_1 .gchoice_106_7_5 input').attr('checked', true); break;
                case "cro": $('#gform_page_106_1 .gchoice_106_7_6 input').attr('checked', true); break;
                case "direktmarketing": $('#gform_page_106_1 .gchoice_106_7_7 input').attr('checked', true); break;
                case "e-mail-marketing": $('#gform_page_106_1 .gchoice_106_7_8 input').attr('checked', true); break;
                case "facebook-ads": $('#gform_page_106_1 .gchoice_106_7_9 input').attr('checked', true); break;
                case "google-analytics": $('#gform_page_106_1 .gchoice_106_7_11 input').attr('checked', true); break;
                case "google-ads": $('#gform_page_106_1 .gchoice_106_7_12 input').attr('checked', true); break;
                case "gmb": $('#gform_page_106_1 .gchoice_106_7_13 input').attr('checked', true); break;
                case "growth-hacking": $('#gform_page_106_1 .gchoice_106_7_14 input').attr('checked', true); break;
                case "inbound": $('#gform_page_106_1 .gchoice_106_7_15 input').attr('checked', true); break;
                case "influencer-marketing": $('#gform_page_106_1 .gchoice_106_7_16 input').attr('checked', true); break;
                case "linkbuilding": $('#gform_page_106_1 .gchoice_106_7_17 input').attr('checked', true); break;
                case "local-seo": $('#gform_page_106_1 .gchoice_106_7_18 input').attr('checked', true); break;
                case "marketing": $('#gform_page_106_1 .gchoice_106_7_19 input').attr('checked', true); break;
                case "online-marketing": $('#gform_page_106_1 .gchoice_106_7_21 input').attr('checked', true); break;
                case "performance-marketing": $('#gform_page_106_1 .gchoice_106_7_22 input').attr('checked', true); break;
                case "pinterest-marketing": $('#gform_page_106_1 .gchoice_106_7_23 input').attr('checked', true); break;
                case "public-relations": $('#gform_page_106_1 .gchoice_106_7_24 input').attr('checked', true); break;
                case "social-media": $('#gform_page_106_1 .gchoice_106_7_25 input').attr('checked', true); break;
                case "sem": $('#gform_page_106_1 .gchoice_106_7_26 input').attr('checked', true); break;
                case "seo": $('#gform_page_106_1 .gchoice_106_7_27 input').attr('checked', true); break;
                case "tiktok": $('#gform_page_106_1 .gchoice_106_7_28 input').attr('checked', true); break;
                case "videoerstellung": $('#gform_page_106_1 .gchoice_106_7_29 input').attr('checked', true); break;
                case "webanalyse": $('#gform_page_106_1 .gchoice_106_7_31 input').attr('checked', true); break;
                case "webdesign": $('#gform_page_106_1 .gchoice_106_7_32 input').attr('checked', true); break;
                case "website-entwicklung": $('#gform_page_106_1 .gchoice_106_7_33 input').attr('checked', true); break;
                case "website-relaunch": $('#gform_page_106_1 .gchoice_106_7_34 input').attr('checked', true); break;
            }
            $('#content .search-header .wrap .agentursuche-button').click();
        });
    }

    var numItems = $('#kontakt-agentur').length;
    if (numItems > 0 /*&& numSingle < 1*/) {
        $('.contact-modal a').attr('data-effect', 'mfp-zoom-out'); //set data-effect attribute
        $('.contact-modal a.agentursuche-button').click(function() {
        });
        $('.contact-modal a').magnificPopup({
            removalDelay: 50, //delay removal by X to allow out-animation
            callbacks: {
                beforeOpen: function () {
                    this.st.mainClass = this.st.el.attr('data-effect');
                }
            },
            midClick: true//, // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
            // closeOnBgClick: false
        });
    }
    var numItems = $('.search-header').length;
    var isagentur = $('.single-agenturen ').length;
    if (numItems > 0 /*&& numSingle < 1*/) {
        if (isagentur < 1) {
            var ht = $('.search-header').height(); // height of div1 in pixels
            elementOffset = $('.search-header').offset().top;
            dropdownht = $('.agenturfinder-dropdown').height(); // height of div1 in pixels
            buttonht = $('.agentursuche-button').height(); // height of div1 in pixels
            contentOffset = $('#content').offset().top + ht + elementOffset + dropdownht;
            $(window).on('scroll', function () {
                var scrollTop = $(window).scrollTop();
                var distance = (scrollTop - elementOffset - ht + 150);
                /* console.log("distance:"+distance);
                 console.log("offset"+elementOffset);
                 console.log("ht"+ht);
                 console.log("scroll"+scrollTop);*/
                //console.log("elementOffset" + elementOffset);
                //console.log("scrollTop" + scrollTop);
                //console.log("distance" + distance);
                if (distance > 0) {
                    $('.search-header').addClass('agenturfinder-sticky');
                    //$('.search-header').css('top', -165);
                    $('#content').addClass("agenturheader-offset");
                    $('#content').css("margin-top", contentOffset);
                }
                else {
                    $('.search-header').removeClass('agenturfinder-sticky');
                    $('.search-header').css('top', -0);
                    $('#content').removeClass("agenturheader-offset");
                    $('#content').css("margin-top", "0px");
                }
            });
        }
    }
}

function initToTopButton() {
    $("#omt-to-top-button").mouseenter(function() {
        $(this).addClass('active')
    });

    $("#omt-to-top-button").mouseleave(function() {
        $(this).removeClass('active')
    });

    $("#omt-to-top-button").click(function() {
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: "smooth"
        });
    
        $(this).removeClass('active');
    });

    toggleToTopButton();
}

function toggleToTopButton() {
    let currentScroll = document.documentElement.scrollTop || document.body.scrollTop;

    if (currentScroll > 500) {
        $("#omt-to-top-button").addClass('visible');
    } else {
        $("#omt-to-top-button").removeClass('visible');
    }
}

// Shrink Navigation
function shrink_nav() {
    var header = $("header");
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();

        if (scroll >= 100) {
            header.addClass('sticky');
        } else {
            header.removeClass("sticky");
        }
    });
}


function prefetch_mouseover() {
    var links = document.querySelectorAll('header .nav ul li a, footer a');
    [].forEach.call(links, function(link) {
        link.addEventListener("mouseenter", function () {
            $("link[rel*='prerender']").remove();
            var newPreLoadLink = document.createElement('link');
            newPreLoadLink.rel = "prerender prefetch";
            newPreLoadLink.href = link.href;
            document.head.appendChild(newPreLoadLink);
        });
    });

    /*var relatedlinks = document.querySelectorAll('.related-posts a');
    [].forEach.call(relatedlinks, function(rellink) {
        var newPreLoadLink = document.createElement('link');
        newPreLoadLink.rel = "prefetch";
        newPreLoadLink.href = rellink.href;
        document.head.appendChild(newPreLoadLink);
    });*/
}
$.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();

    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
};

function lazy_youtube() {
    $(window).on('resize scroll load', function() {
        $('.lazy-youtube').each(function() {
            if ($(this).isInViewport()) {
                if (!$(this).hasClass('lazy-youtube-visible')) {
                    var youtube = document.querySelectorAll(".lazy-youtube");

                    for (var i = 0; i < youtube.length; i++) {
                        // thumbnail image source.
                        var source = "https://img.youtube.com/vi/" + youtube[i].dataset.embed + "/sddefault.jpg";
                        // Load the image asynchronously
                        var image = new Image();
                        image.src = source;
                        image.addEventListener("load", function () {
                            //  youtube[i].appendChild(image);
                        }(i));
                        //youtube[i].addEventListener("click", function () { //create youtube from screenshot on click - disabled this so the video is created when frame is visible
                        var iframe = document.createElement("iframe");

                        iframe.setAttribute("frameborder", "0");
                        iframe.setAttribute("allowfullscreen", "");
                        iframe.setAttribute("src", "https://www.youtube.com/embed/" + this.dataset.embed + "?rel=0&showinfo=0&autoplay=0");

                        this.innerHTML = "";
                        this.appendChild(iframe);
                        // });
                    }
                    $(this).addClass('lazy-youtube-visible');
                }
            }
        });
    });
}

function lazy_tiktok() {
    $(window).on('resize scroll load', function() {
        $('.tiktok-embed').each(function() {
            var object = $(this);
            if ($(this).isInViewport()) {
                if (!$(this).hasClass('lazy-tiktok-visible')) {
                    object.addClass('lazy-tiktok-visible');
                    var url = $(this).data('url');
                    var finalurl = "https://www.tiktok.com/oembed?url=" + url;
                    $.getJSON(finalurl, function (data) {
                        $.each(data, function (key, val) {
                            if ("html" == key) {
                                jsonhtml = val;
                                object.html(jsonhtml);
                            }
                        });
                    });
                }
            }
        });
    });
}

function totalpollpro_toggler() {
    $('.totalpoll-choice-content').click(function() {
        //alert($(this).find('.vote-wrap').html());
        if ($(this).hasClass("expanded")) {
            $(this).find('.vote-wrap').css('max-height', '0px');
            $(this).find('.vote-wrap').css('overflow', 'hidden');
            $(this).removeClass("expanded");
        }
        else {
            $(this).find('.vote-wrap').css('max-height', '100%');
            $(this).find('.vote-wrap').css('overflow', 'visible');
            $(this).addClass("expanded");
            //$(this).find('.vote-wrap').toggleClass( 'vote-wrap-visible' );
        }
    });
    //$(".totalpoll-field-wrapper").attr('id', 'poll-anchor');
    $(".totalpoll-button-vote").click(function() {
        $('html, body').animate({
            scrollTop: $("#totalpoll-id-76a970e19557b7ec2226b0a737139b07").offset().top
        }, 1000);
    });
}


function club_readmore() {
    $(".club-more").click(function() {
        $(this).parent().css('max-height', '10000px');
    });
}

function popup_modal() {
    $('[data-popup-open]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);

        e.preventDefault();
    });

    //----- CLOSE
    $('[data-popup-close]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

        e.preventDefault();
    });
    $('.close-layer').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

        e.preventDefault();
    });
}

function openTab(evt, tabName) {
    // Declare all variables
    $('.tabcontent').not('.tab-termine').removeClass('untabbed');
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    /* document.getElementById(tabName).css('margin-top', '0px');*/
    evt.currentTarget.className += " active";
    regenerate_index();
    $('html,body').animate({ scrollTop: $("#selected").offset().top }, 'slow');
}

function stickysidebar() {
    if ($('.seminar-single .seminare-content-wrap #seminar-sidebar').length) {
        if ($.isFunction($.fn.stick_in_parent)) {
            $('.seminar-single .seminare-content-wrap #seminar-sidebar').stick_in_parent({
                parent: ".seminare-content-wrap", // Note: we must now manually provide the parent when set "spacer"
                spacer: ".seminar-sidebar-spacer",
                offset_top: 165
            });
        }
    }
}

function blog_sidescroll_socials() { //modified to run on all pages*/
    var numItems = $('.socials-floatbar-left').length;
    //console.log(numItems);
    if (numItems > 0 /*&& numSingle < 1*/) {
        var os_social = $('.socials-floatbar-left').offset().top; // pixels to the top of div1
//        console.log(os_social);
        $(window).scroll(function () {
            var scroll = $(window).scrollTop(); // how many pixels you've scrolled
            //var os = $('.entry-content .shariff').offset().top; // pixels to the top of div1
            //var ht = $('.entry-content .shariff').height(); // height of div1 in pixels
            // if you've scrolled further than the top of div1 plus it's height
            // change the color. either by adding a class or setting a css property
            //if(scroll > os + ht){
            if ($(window).scrollTop() >= 400) {
                $('.socials-floatbar-left .shariff').css('opacity', 1);
                $('.socials-floatbar-mobile').css('bottom', 0);
            }
            else {
                $('.socials-floatbar-left .shariff').css('opacity', 0);
                $('.socials-floatbar-mobile').css('bottom', -40);
                // $('.top-header .logo').attr('src','/wp-content/uploads/2017/11/Logo_EM_RGB_M-e1510047371811.png');
            }
        });
    }
}

function kapitelnavigation() {
    if ( $.isFunction($.fn.stick_in_parent) ) {
        $('.kapitelnavigation').stick_in_parent({
            offset_top: 165
        });
    }

    $(window).on('resize scroll', function() {
        $('.kapitel').each(function() {
            var activeArea = "#"+$(this).find("span.anchor").attr('id');
            if ($(this).find('h2').length) {
                if ($(this).find("h2").isInViewport()) {
                    $('a.navigation').each(function () {
                        var href = $(this).attr('href');
                        if (activeArea == href) {
                            $(this).addClass('active');
                        }
                        else {
                            $(this).removeClass('active');
                        }
                    });
                }
            }
            if ($(this).find("p").isInViewport()) {
                $('a.navigation').each(function () {
                    var href = $(this).attr('href');
                    if ((!$(".active").length) && (!$('.parent-active').length)) { //only activate if every other section is deactivated!
                        if (activeArea == href) {
                            $(this).addClass('active');
                        }
                    }
                });
            } else if ($(this).isInViewport()) {
                $('a.navigation').each(function () {
                    var href = $(this).attr('href');
                    if ((!$(".active").length) && (!$('.parent-active').length)) { //only activate if every other section is deactivated!
                        if (activeArea == href) {
                            $(this).addClass('active');
                        }
                    }
                });
            } else { //remove activity class when element leaves viewport!
                $('a.navigation').each(function () {
                    var href = $(this).attr('href');
                    if (activeArea == href) {
                        $(this).removeClass('active');
                        $(this).removeClass('parent-active');
                        $(this).parent().find('.navigation-unterkapitel-wrap').removeClass('navigation-unterkapitel-active');
                    }
                });
            }
            /////////////////////////check if unterkapitel is in viewport and activate it!
            if ($(this).find(".unterkapitel-wrap").length ) {
                if ($(this).find(".unterkapitel-wrap").isInViewport()) {
                    $('.unterkapitel').each(function () {
                        var activeArea = "#" + $(this).find("span.anchor").attr('id');
                        if ( $(this).isInViewport() ){
                            $('a.navigation-unterkapitel').each(function () {
                                var href = $(this).attr('href');
                                /*  if ((!$(".active").length) && (!$('.parent-active').length)) { *///only activate if every other section is deactivated!
                                if (!$(".unterkapitel-active").length) { //only activate if every other unterkapitel is deactivated!
                                    if (activeArea == href) {
                                        $(this).addClass('unterkapitel-active');
                                        $(this).parent().addClass('navigation-unterkapitel-active');
                                        $(this).parent().parent().find("a.navigation-main").addClass("parent-active");
                                    }
                                }
                                // }
                            });
                        } else { //remove activity class when element leaves viewport!
                            $('a.navigation-unterkapitel').each(function () {
                                var href = $(this).attr('href');
                                if (activeArea == href) {
                                    $(this).removeClass('unterkapitel-active');
                                }
                            });
                        }

                    });
                }
            }

            if (! $( ".unterkapitel-active" ).length ) {  ///remove Parent-is-active Class if Unterkapitel is no more in Viewport!
                $("a.navigation-main").removeClass("parent-active");
                $(".navigation-unterkapitel-wrap").removeClass("navigation-unterkapitel-active");
            }
        });
    });
}

function reposition_kapitelmodul() {
    var numItems = $('.kapitel-wrap').length;
    if (numItems > 0) {
        if ($(window).width() > 1450) {
            var gotinhaltsverzeichnis = $('.inhaltsverzeichnis-wrap .inhaltsverzeichnis').length;
            var gotplaceholder = $('.inhaltsverzeichnis-wrap .placeholder-730').length;
            var gotmodule = $('.inhaltsverzeichnis-module .inhaltsverzeichnis').length;

            if (gotinhaltsverzeichnis > 0) {
                var posinhalt = $('.inhaltsverzeichnis-wrap .inhaltsverzeichnis').offset();
                posinhaltlen = $('.inhaltsverzeichnis-wrap .inhaltsverzeichnis').length;
            }
            if (gotplaceholder > 0) {
                var posinhalt = $('.inhaltsverzeichnis-wrap .placeholder-730').offset();
                posinhaltlen = $('.inhaltsverzeichnis-wrap .placeholder-730').length;
            }
            if (gotmodule > 0) {
                var posinhalt = $('.inhaltsverzeichnis-module .inhaltsverzeichnis').offset();
                posinhaltlen = $('.inhaltsverzeichnis-module .inhaltsverzeichnis').length;
            }
            var poskapitel = $('.kapitel-wrap').offset();
            if (posinhaltlen < 1) {posinhalt = 0;}
            var leftdiff = poskapitel.left - posinhalt.left;
            $('.kapitel-wrap').css('left', leftdiff);
        } else {
            $('.kapitel-wrap').css('left', 0);
        }
    }
}


function reposition_toolindex() {
    var numItems = $('.toolindex-filter-wrap').length;
    if (numItems > 0) {
        windowwidth = $(window).width();
        $(window).resize(function() {
            windowwidth = $(window).width();
            if (windowwidth < 1600) {
                //$('.toolindex-wrap').css('left', 0);
                $('.toolindex-filter-wrap .filter-headline').click(function () {
                    $(this).parent().parent().toggleClass('filter-active');
                });
                $('.toolindex-filter-wrap .filter').click(function () {
                    $(this).parent().parent().parent().removeClass('filter-active');
                });
            } else {
                var gotinhaltsverzeichnis = $('.inhaltsverzeichnis-wrap .inhaltsverzeichnis').length;
                var gotplaceholder = $('.inhaltsverzeichnis-wrap .placeholder-730').length;
                var gotmodule = $('.inhaltsverzeichnis-module .inhaltsverzeichnis').length;

                if (gotinhaltsverzeichnis > 0) {
                    var posinhalt = $('.inhaltsverzeichnis-wrap .inhaltsverzeichnis').offset();
                    posinhaltlen = $('.inhaltsverzeichnis-wrap .inhaltsverzeichnis').length;
                }
                if (gotplaceholder > 0) {
                    var posinhalt = $('.inhaltsverzeichnis-wrap .placeholder-730').offset();
                    posinhaltlen = $('.inhaltsverzeichnis-wrap .placeholder-730').length;
                }
                if (gotmodule > 0) {
                    var posinhalt = $('.inhaltsverzeichnis-module .inhaltsverzeichnis').offset();
                    posinhaltlen = $('.inhaltsverzeichnis-module .inhaltsverzeichnis').length;
                }
                var poskapitel = $('.toolindex-column-wrap').offset();
                var leftdiff = poskapitel.left - posinhalt.left;
                //$('.toolindex-wrap').css('left', leftdiff);
                //$('.toolindex-shortcode-wrap .toolindex-wrap').css('left', 0);
                $('.toolindex-shortcode-wrap').css('left', 0);
            }
        });
        $(window).scroll(function () {
            windowwidth = $(window).width();
        });
        if (windowwidth > 1599) {
            if ( $.isFunction($.fn.stick_in_parent) ) {
                $('.toolindex-filter').stick_in_parent({
                    offset_top: 165
                });
            }
            var gotinhaltsverzeichnis = $('.inhaltsverzeichnis-wrap .inhaltsverzeichnis').length;
            var gotplaceholder = $('.inhaltsverzeichnis-wrap .placeholder-730').length;
            var gotmodule = $('.inhaltsverzeichnis-module .inhaltsverzeichnis').length;
            var posinhaltlen = 0;

            if (gotinhaltsverzeichnis > 0) {
                var posinhalt = $('.inhaltsverzeichnis-wrap .inhaltsverzeichnis').offset();
                posinhaltlen = $('.inhaltsverzeichnis-wrap .inhaltsverzeichnis').length;
            }
            if (gotplaceholder > 0) {
                var posinhalt = $('.inhaltsverzeichnis-wrap .placeholder-730').offset();
                posinhaltlen = $('.inhaltsverzeichnis-wrap .placeholder-730').length;
            }
            if (gotmodule > 0) {
                var posinhalt = $('.inhaltsverzeichnis-module .inhaltsverzeichnis').offset();
                posinhaltlen = $('.inhaltsverzeichnis-module .inhaltsverzeichnis').length;
            }
            var poskapitel = $('.toolindex-column-wrap').offset();
            if (posinhaltlen < 1) {posinhalt = 0; posinhalt.left = 0; }
            var leftdiff = poskapitel.left - posinhalt.left;
            //$('.toolindex-wrap').css('left', leftdiff);
            //$('.toolindex-shortcode-wrap .toolindex-wrap').css('left', 0);
            $('.toolindex-shortcode-wrap').css('left', 0);
        } else {
            //$('.toolindex-wrap').css('left', 0);
            $('.toolindex-filter-wrap .filter-headline').click(function () {
                $(this).parent().parent().toggleClass('filter-active');
            });
            $('.toolindex-filter-wrap .filter').click(function () {
                $(this).parent().parent().parent().removeClass('filter-active');
            });
        }
    }
}

function tool_header_sticky() {
    if ($('.single-tool').length > 0 && $('.tool-header').length > 0) {
        if ($(window).scrollTop() > 0) {
            $('#toolskontakt').addClass('dein-tool-scrolled');
            $('.tool-header').addClass('tool-scrolled');
        } else {
            $('.tool-header').removeClass('tool-scrolled');
            $('#content').removeClass('tool-content-scrolled');
        }

        lastScrollTop = 0;
        $(document).on('scroll', function() {
            value = $(window).scrollTop();
            if (value>0) {
                $('.tool-header').addClass('tool-scrolled');
                $('#toolskontakt').addClass('dein-tool-scrolled');
                $('#content').addClass('tool-content-scrolled');
                
                if (value > lastScrollTop){
                    // downscroll code
                    $('#toolskontakt').addClass('dein-tool-scrolled');
                    $('.tool-scrolled-links-wrap').addClass('display-none');
                    
                } else {
                    // upscroll code
                    $('.tool-scrolled-links-wrap').removeClass('display-none');
                }
                lastScrollTop = value;
            } else {
                $('#toolskontakt').removeClass('dein-tool-scrolled');
                $('.tool-header').removeClass('tool-scrolled');
                $('#content').removeClass('tool-content-scrolled');
                
            }
        });
    }
}

function seminar_sticky_buttons() {
    var numItems = $('.seminar-buttons-mobile').length;
    if (numItems > 0) {
        lastScrollTop = 0;
        $(document).on('scroll', function(){
            value = $(window).scrollTop();
            if (value>0) {
                if (value > lastScrollTop){
                    // downscroll code
                    $('.seminar-buttons-mobile').addClass('display-none');
                } else {
                    // upscroll code
                    $('.seminar-buttons-mobile').removeClass('display-none');
                }
                lastScrollTop = value;
            }
        });
    }
}

function mobile_hide_on_scroll() {
    var numItems = $('.mobile-hide-on-scroll').length;
    if (numItems > 0) {
        if ($(window).width() < 768) {
            $(document).on('scroll', function () {
                value = $(window).scrollTop();
                if (value > 0) {
                    // downscroll code
                    $('.mobile-hide-on-scroll').addClass('display-none');
                }
            });
        }
    }
}




function tool_ubersicht_more() {
    $('.tool-uebersicht .more-info').click(function () {
        $(this).parent().find('.info-container').toggleClass('half-reduced');
        if ($(this).text() == "Mehr Infos")
        {
            $(this).text('einklappen');
        } else { $(this).text('Mehr Infos'); }
    });
    $('.description-collapse-button').click(function () {
        $(this).parent().find('.tool-description').toggleClass('description-collapsed');
        if ($(this).find('.info-text').text() == "...mehr Infos") {
            $(this).find('.info-text').text("...weniger Infos");
        } else {
            $(this).find('.info-text').text("...mehr Infos");
        }
    });
}

function toolindex_collapse() {
    $('.tool-results-collapsed').each(function() {
        var t=$(this);
        t.css('max-height','none');
        t.data('height',t.height());
        t.css('max-height','');
        if ($(this).data('height')<4500) {
            $(this).parent().find('.tool-results-collapse-button').css('display', 'none');
        }
        else {
            $(this).parent().find('.tool-results-collapse-button').css('display', 'block');
        }
    });


    $('.tool-results-collapse-button').click(function () {
        $(this).parent().find('.tool-results').toggleClass('tool-results-collapsed');
        if ($(this).find('.info-text').text() == "...alle") {
            $(this).find('.info-text').text("...weniger");
        } else {
            $(this).find('.info-text').text("...alle");
        }
    });
}

function lazy_soundcloud() {
    var numItems = $('.lazy-soundcloud').length;
    if (numItems > 0) {
        $(window).on('resize scroll load', function () {
            $('.lazy-soundcloud').each(function () {
                if ($(this).isInViewport()) {
                    if (!$(this).hasClass('lazy-soundcloud-visible')) {
                        var youtube = document.querySelectorAll(".lazy-soundcloud");
                        for (var i = 0; i < youtube.length; i++) {
                            // add the code here
                        }
                        // loop
                        for (var i = 0; i < youtube.length; i++) {
                            //youtube[i].addEventListener("click", function () { //create youtube from screenshot on click - disabled this so the video is created when frame is visible
                            var iframe = document.createElement("iframe");
                            // return '<iframe widthsrc="' . $trackid . '"></iframe>';

                            iframe.setAttribute("scrolling", "no");
                            iframe.setAttribute("width", "100%");
                            iframe.setAttribute("height", "166");
                            iframe.setAttribute("frameborder", "no");
                            iframe.setAttribute("allow", "autoplay");
                            iframe.setAttribute("allowfullscreen", "");
                            iframe.setAttribute("src", "https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/" + this.dataset.track + "&color=%23ea506c&auto_play=false&hide_related=true&show_comments=true&show_user=true&show_reposts=false&show_teaser=true");

                            this.innerHTML = "";
                            this.appendChild(iframe);
                            // });
                        }
                        $(this).addClass('lazy-soundcloud-visible');
                        $(this).removeClass('lazy-soundcloud');
                    }
                }
            });
        });
    }
}

function lazy_spotify() {
    var numItems = $('.lazy-spotify').length;
    if (numItems > 0) {
        $(window).on('resize scroll load', function() {
            $('.lazy-spotify').each(function() {
                var object = $(this);
                if ($(this).isInViewport()) {
                    if (!$(this).hasClass('lazy-spotify-visible')) {
                        object.addClass('lazy-spotify-visible');
                        var trackid = $(this).data('track');
                        $(this).html('<iframe src="https://open.spotify.com/embed-podcast/episode/'+trackid+'/" width="100%" height="232" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>\n')
                    }
                }
            });
        });
    }
}

function tools_links_active() {
    $('.tool-header .tool-navigation-wrap ul li a').click(function() {
        $('.tool-header .tool-navigation-wrap ul li a').removeClass('active');
        $(this).addClass('active');
    });
}

function omt_vortrage_umfrage() {
    var numItems = $('.vortrag').length;
    var maxvotes = 7;
    if (numItems > 0) {
        $('.umfrage-kategorie .vortrag .voting-wrap').click(function () {
            if (!$(this).parent().parent().hasClass('vortrag-voted')) {
                var numvoted = $('.vortrag-voted').length + 1;
                if (numvoted > maxvotes) {
                    alert("Du hast bereits " + maxvotes + " Stimmen abgegeben.")
                } else {
                    $(this).children(".vortrag-voting").children("i").toggleClass('fa-square-o').toggleClass('fa-check-square-o');
                    $(this).parent().parent().toggleClass('vortrag-voted');
                    var vortrag = $(this).parent().parent().data('id');
                    var title = $(this).parent().children('.title').children('h3').html();
                    $('#results').append("<p id='" + vortrag + "'>" + title + "</p>");
                }
            } else {
                $(this).children(".vortrag-voting").children("i").toggleClass('fa-square-o').toggleClass('fa-check-square-o');
                $(this).parent().parent().toggleClass('vortrag-voted');
                var vortrag = ($(this).parent().parent().data('id'));
                $("#" + vortrag).remove();
            }
            var numvoted = $('.vortrag-voted').length;
            if (numvoted > 0 && $("#email").val().length > 0 && $("#code").val().length > 0) {
                $(".umfrage-submit").addClass("umfrage-submit-clickable");
            } else {
                $(".umfrage-submit").removeClass("umfrage-submit-clickable");
            }
        });
        $("input").change(function () {
            var numvoted = $('.vortrag-voted').length;
            if (numvoted > 0 && $("#email").val().length > 0 && $("#code").val().length > 0) {
                $(".umfrage-submit").addClass("umfrage-submit-clickable");
            } else {
                $(".umfrage-submit").removeClass("umfrage-submit-clickable");
            }
        });
        $('.umfrage-submit-clickable').click(function () {
            var numvoted = $('.vortrag-voted').length;
            if (numvoted < 1) {
                alert("Bitte wähle " + maxvotes + " Vorträge aus, für die Du stimmen möchtest!");
            }
            if ($("#email").val().length === 0) {
                alert("Bitte Namen eingeben");
            }
            if ($("#code").val().length === 0) {
                alert("Bitte Code eingeben");
            }
            if (numvoted > 0 && $("#email").val().length > 0 && $("#code").val().length > 0) {
                //alert ("success");
            }
        });
        $('.umfrage-kategorie .vortrag .collapse-button').click(function () {
            $(this).parent().parent().parent().toggleClass('vortrag-collapsed');
            $(this).children().children("i").toggleClass("fa-chevron-down").toggleClass("fa-chevron-up");
            var $caption = $(this).children().children("p").html();
            ;
            if ("mehr Infos" === $caption) {
                $(this).children().children("p").html("weniger Infos")
            } else {
                $(this).children().children("p").html("mehr Infos")
            }
        });

        var ht = $('header').height(); // height of div1 in pixels
        elementOffset = $('.umfrage-category-menu').offset().top;
        $(window).on('scroll', function () {
            var scrollTop = $(window).scrollTop();
            var distance = (elementOffset - scrollTop - ht);
            if (distance < 10) {
                $('.umfrage-category-menu').addClass('category-menu-sticky');
            } else {
                $('.umfrage-category-menu').removeClass('category-menu-sticky');
            }
        });
        $(".category-menu-label").click(function () {
            $(this).parent().toggleClass('category-menu-sticky-uncollapsed');
        });
        $(".umfrage-category-menu .menu-link").click(function () {
            console.log("test");
            $(this).parent().removeClass('category-menu-sticky-uncollapsed');
        });
    }
}

function themenwelt_sticky_mobile() {
    $('.header-themenwelt-flat').click(function () {
        $('.header-themenwelt-inner').addClass('header-themenwelt-inner-active');
    });
    $('.header-themenwelt-flat a').click(function () {
        $('.header-themenwelt-inner').removeClass('header-themenwelt-inner-active');
    });
}

function lazy_wistia() {
    $('.tool-wistia').click(function() {
        var embed_code = $(this).data('embed');
        parenthtml = '<script src="//fast.wistia.com/embed/medias/'+embed_code+'.jsonp" async></script>\n' +
            '    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>\n' +
            '    <div class="wistia_responsive_padding">\n' +
            '        <div class="wistia_responsive_wrapper">\n' +
            '        <div class="wistia_embed wistia_async_'+embed_code+' autoPlay=true">&nbsp;</div>\n' +
            '    </div>\n' +
            '    </div>';
        $(this).parent().html(parenthtml);
    });
        /*var html_wistia = '<iframe src="//fast.wistia.net/embed/iframe/' +vid_id + '" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen width="730" height="400"></iframe><script src="//fast.wistia.net/assets/external/E-v1.js" async></script>';
        var html_vistia = '<script src="//fast.wistia.com/embed/medias/' + vid_id + '.jsonp" async></script><script src="//fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding"><div class="wistia_responsive_wrapper"><div class="wistia_embed wistia_async_' + vid_id + '">&nbsp;</div></div></div>';
        $("#lightbox-area #login-cnt").html(html_wistia);
        $("#lightbox-area #login-cnt").addClass('lightbox-video');
*/
}

function lazy_tool_youtube() {
    $('.tool-youtube:not(.tool-youtube-visible)').click(function() {
        let iframe = document.createElement("iframe");

        iframe.setAttribute("frameborder", "0");
        iframe.setAttribute("allowfullscreen", "");
        iframe.setAttribute("src", "https://www.youtube.com/embed/" + this.dataset.embed + "?rel=0&showinfo=0&autoplay=1");
        iframe.setAttribute("allow", "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture");

        this.innerHTML = "";
        this.appendChild(iframe);
        this.classList.add('tool-youtube-visible');
    });
}

$(document).ready(function($) {
    close_hero_countdown();
    initMobileCardDataTables();
    initDownloadsPeopleCarousel();
    lazy_wistia();
    lazy_tool_youtube();
    omt_vortrage_umfrage();
    magnificpopup();
    blog_sidescroll_socials();
    club_readmore();
    initStickyToHeader();
    var map = null;
    konferenz_countdown();
    accordion();
    checkbox();
    progressbar_init();
    generate_index();
    inhaltsverzeichnis_sticky();
    inhaltsverzeichnis_ac();
    smoothscroll();
    toggle_login_area();
    login_lightbox();
    login_area_checkbox();
    mega_dropnav();
    shrink_nav();
    toggle_video_area();
    activate_form();
    initToTopButton();
    lazy_youtube();
    lazy_soundcloud();
    prefetch_mouseover();
    totalpollpro_toggler();
    popup_modal();
    $(".hidethis").closest(".omt-row").children("div").children("h2").css("display", "none");
    $(".hidefull").closest(".omt-row").css("display", "none");
    kapitelnavigation();
    tool_header_sticky();
    reposition_kapitelmodul();
    reposition_toolindex();
    tool_ubersicht_more();
    toolindex_collapse();
    lazy_tiktok();
    lazy_spotify();
    seminar_sticky_buttons();
    tools_links_active();
    header_search_icon();
    themenwelt_sticky_mobile();
    stickysidebar();
    mobile_hide_on_scroll();

    if ( $.isFunction($.fn.slick) ) {
        function slider_slick() {
            $('.slider').slick({
                slidesToShow: 3,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 5000,
                centerMode: true,
                centerPadding: '0px',
                responsive: [
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });

            $(".slick-arrow").hide();

            $(".slider").mouseenter(function () {
                $(".slick-arrow").show();
            });

            $(".slider").mouseleave(function () {
                $(".slick-arrow").hide();
            });
        }

        function testimonial_slider() {
            $('.testimonial-slider').slick({
                autoplay: true,
                autoplaySpeed: 9000,
                arrows: false,
                pauseOnFocus: false,
                pauseOnHover: false,
                centerMode: false
            });
        }

        function tool_slider() {
            $('.tool-slider').slick({
                lazyLoad: 'ondemand',
                autoplay: false,
                autoplaySpeed: 9000,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                asNavFor: '.tool-slider-nav'
            });
            $('.tool-slider-nav').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                asNavFor: '.tool-slider',
                arrows: false,
                dots: false,
                centerMode: false,
                centerPadding: "0px",
                focusOnSelect: true,
            });
        }
        tool_slider();
        slider_slick();
        testimonial_slider();
        changeTeaserHeaderSize();
    }
});

$(window).on("load", function (e) {
    inhaltsverzeichnis_sticky();
    smoothscroll();

//matchheight();
});

$(window).resize(function() {
    toolindex_collapse();
    changeTeaserHeaderSize();
});

// Catch scroll to top
$(window).scroll(function() {
    toggleToTopButton();
});

if ('ontouchstart' in document.documentElement) {
    document.addEventListener('touchstart', onTouchStart, {passive: true});
}

function navigateToTab(tab) {
    var btnElements = document.getElementsByClassName("navigation-tab");
    var contentElements = document.getElementsByClassName("navigation-tab-content");

    for (let i = 0; i < contentElements.length; i++) {
        let activeClass = btnElements[i].dataset.active ? btnElements[i].dataset.active : 'active';
        let inactiveClass = btnElements[i].dataset.inactive ? btnElements[i].dataset.inactive : '';

        if (contentElements[i].id === tab) {
            btnElements[i].classList.remove(inactiveClass);
            btnElements[i].classList.add(activeClass);

            contentElements[i].classList.add('active');
            contentElements[i].classList.remove('hidden');
        } else {
            btnElements[i].classList.remove(activeClass);
            btnElements[i].classList.add(inactiveClass);

            contentElements[i].classList.remove('active');
            contentElements[i].classList.add('hidden');
        }
    }
}

function scrollToCommentsSection() {
    let element = document.getElementById("comments");

    element.scrollIntoView({
        block: "center", 
        behavior: "smooth"
    });
}

function scrollToTeamMember(id) {
    let elementPosition = $(`#team-member-${id}`).offset().top;
    let offsetPosition = elementPosition - ($(window).width() >= 768 ? 350 : 180);

    window.scrollTo({
        top: offsetPosition,
        behavior: "smooth"
    });
}

function initMobileCardDataTables() {
    $(".card-data-table").each(function () {
        let header = [];

        $(this).find("tr").each(function (row) {
            $(this).children().each(function (column) {
                if (row === 0) {
                    header.push(this.innerText)
                } else {
                    $(this).prepend('<div class="card-data-table-header x-mb-4"><strong>' + header[column] + '</strong></div>');
                }
            });
        });
    });
}

function initDownloadsPeopleCarousel() {
    if ($.isFunction($.fn.slick) && $('.downloads-people-container').length) {
        $('.downloads-people-container').slick({
            slidesToShow: 4,
            autoplay: true,
            autoplaySpeed: 5000,
            arrows: true,
            responsive: [
                {
                    breakpoint: 961,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 601,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 482,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        $('.downloads-people-container .slick-arrow').hide();

        $('.downloads-people-container').mouseenter(function () {
            $('.slick-arrow').show();
        });

        $('.downloads-people-container').mouseleave(function () {
            $('.slick-arrow').hide();
        });
    }
}

function changeTeaserHeaderSize(){
    $('.omt-row .teaser-matchbuttons .article-title').each(function( i, el ){
        var el_title = $(el).find('a');
        var size = parseInt($(el_title).css('font-size'));
        while($(el_title).width() > $(el).width()){
            $(el_title).css( 'font-size', --size );
        }
    });
}
//changing article content
/*$('#article_select').change(function(){
    var value = $(this).val();
    if(value === 'schauen'){
        $("#art_content").hide();
        $("#soundcloud_content").hide();
        $("#webinar_content").show();
    }else if(value === 'horen'){
        $("#art_content").hide();
        $("#soundcloud_content").show();
        $("#webinar_content").hide();
    }else{
        $("#art_content").show();
        $("#soundcloud_content").hide();
        $("#webinar_content").hide();
    }
});*/ //deactivated to put the script inline in order to make it work on mobile phones

function omtLoadMore(){
    var element = document.getElementById('load_more_article');
    var dataFormat = element.getAttribute('data-format');
    var dataOffset = element.getAttribute('data-offset');
    var dataTypes = element.getAttribute('data-types');
    $("#load_more_article").hide();
    $( "#after_load" ).removeClass('hide_loading');
    //document.getElementById("loading-content").style.display = "block";
    
    var url = "/wp-admin/admin-ajax.php?action=omt_load_articles&format="+dataFormat+"&offset="+dataOffset+"&post_type[]="+dataTypes;
    $.ajax({
        type: "GET",
        url: url,
        dataType: 'json',
        success: function(data){
            //if request if made successfully then the response represent the data
            var result = data[Object.keys(data)[0]];
            //$("#loading-content").attr("class", "loader_spin_");
            $( "#after_load" ).addClass('hide_loading');
            $("#results").html(result.content);
        }
            
    });
}



//Vertical tabs
function openVertTab(evt, Services) {
  var i, tabcontent, tablinks, tabArrow;
  tabcontent = document.getElementsByClassName("tabcontent-omt");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks-omt");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(Services).style.display = "block";
  evt.currentTarget.className += " active";
}
//Check if vertical tab module exists and trigger click event
$( document ).ready(function() {
    if (document.querySelector('.tablinks-omt') !== null) {
    document.getElementById("defaultOpen").click();
    }
});



window.onload = function() {
    var numItems = $('input_24_31').length;
    if (numItems > 0) {
        $rand_id = Math.floor(100000 + Math.random() * 900000);
        document.getElementById("input_24_31").value = $rand_id;
        document.getElementById("billing_uniqe_id_for_job").value = $rand_id;
    }
}
//After gform success display checkout
$(document).on("gform_confirmation_loaded", function (e, form_id) {
  jQuery( ".checkout" ).addClass( "show_checkout" );
  jQuery( ".woocommerce-form-coupon-toggle" ).addClass( "show_checkout" );
});


//job filter show more button for categories
function show_cat(){
    event.preventDefault();
    $(".hide_cat").show();
    $(".hide_categories").show();
    $(".show_categories").hide();
    
}
function hide_cat(){
    event.preventDefault();
    $(".hide_cat").hide();
    $(".show_categories").show();
    $(".hide_categories").hide();
}

//job filter show more button for cities
function show_city(){
    event.preventDefault();
    $(".hide_city").show();
    $(".hide_cities").show();
    $(".show_cities").hide();
    
}
function hide_city(){
    event.preventDefault();
    $(".hide_city").hide();
    $(".show_cities").show();
    $(".hide_cities").hide();
}






function priceToggle(price){
    if(price === 'Monthly'){
        $('.quarterly').addClass('hide_product')
        $('.monthly').removeClass('hide_product')
        $('.halfyearly').addClass('hide_product')
        $('.yearly').addClass('hide_product')

        $('#quarterly').addClass('hide_product')
        $('#halfyearly').addClass('hide_product')
        $('#yearly').addClass('hide_product')

        $('.ann').removeClass('hide_product')
        


    }else if(price === 'Quarterly'){
        $('.quarterly').removeClass('hide_product')
        $('.monthly').addClass('hide_product')
        $('.halfyearly').addClass('hide_product')
        $('.yearly').addClass('hide_product')

        $('.quarterly_').removeClass('hide_product')
        $('.halfyearly_').addClass('hide_product')
        $('.yearly_').addClass('hide_product')
        $('.ann').addClass('hide_product')
    }else if(price === 'Halfyearly'){
        $('.quarterly').addClass('hide_product')
        $('.monthly').addClass('hide_product')
        $('.halfyearly').removeClass('hide_product')
        $('.yearly').addClass('hide_product')


        $('.quarterly_').addClass('hide_product')
        $('.halfyearly_').removeClass('hide_product')
        $('.yearly_').addClass('hide_product')
        $('.ann').addClass('hide_product')
    }else if(price === 'Yearly'){
        $('.quarterly').addClass('hide_product')
        $('.monthly').addClass('hide_product')
        $('.halfyearly').addClass('hide_product')
        $('.yearly').removeClass('hide_product')


        $('.quarterly_').addClass('hide_product')
        $('.halfyearly_').addClass('hide_product')
        $('.yearly_').removeClass('hide_product')
        $('.ann').addClass('hide_product')
    }
    
}



$( document ).ready(function() {
    $( ".annual" ).click(function() {
      
        $('.quarterly').addClass('hide_product')
        $('.monthly').addClass('hide_product')
        $('.halfyearly').addClass('hide_product')
        $('.yearly').removeClass('hide_product')


        $('.quarterly_').addClass('hide_product')
        $('.halfyearly_').addClass('hide_product')
        $('.yearly_').removeClass('hide_product')

        $('.ann').addClass('hide_product')

        $("#yr").prop("checked", true);
    });
});






/*excludes wprocket

wp-includes/js/dist/
wp-includes/js/tinymce/
/wp-content/themes/omt/library/js/scripts.js
/wp-content/themes/omt/library/js/libs/jquery-2.2.4.min.js
/wp-content/themes/omt/library/ajax/(.*).js
*/