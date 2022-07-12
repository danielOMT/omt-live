$(document).ready(function($) {
    setBannersPosition();
});

$(window).resize(function() {
    setBannersPosition();
});

function setBannersPosition() {
    if ($('.tool-info-image').length > 0) {
        let widestSection = _getBannerWidestSection();

        $('.tool-info-image').css('left', widestSection.offset().left + widestSection.width() + 30);

        _setBannerTopPosition('.tool-info-image');
    }

    if ($('.top-left-banner-section').length > 0) {
        if ($(window).width() >= 1400) {
            let widestSection = _getBannerWidestSection();
    
            $('.top-left-banner-section').css('left', widestSection.offset().left - $('.top-left-banner-section').width() - 30).show();

            // Init set of top position if it's a Page
            if ($('.top-left-banner-section').hasClass('page-top-left-banner')) {
                _setBannerTopPosition('.top-left-banner-section');
            }
        } else {
            $('.top-left-banner-section').hide();
        }
    }
}

function _setBannerTopPosition(selector) {
    let offsetTop = _getBannerTopSection().offset().top;
    if (offsetTop > 492) {
        offsetTop = 492;
    }

    let scrollTop = $(window).scrollTop();
    if (scrollTop > 365) {
        scrollTop = 365;
    }

    let posTop = offsetTop - scrollTop;

    if ($('.header-themenwelt-sticky').length > 0) {
        if (posTop < 215) {
            posTop = 215;
        }

        $(selector).css('top', posTop);

        _initBannerPositioningOnScroll(selector, offsetTop, 215);
    } else {
        if (posTop < 100) {
            posTop = 100;
        }

        $(selector).css('top', posTop);

        _initBannerPositioningOnScroll(selector, offsetTop, 100);
    }
}

function _initBannerPositioningOnScroll(selector, offsetTop, posTopLimit) {
    $(document).on('scroll', function () {
        let scrollTop = $(window).scrollTop();

        if (scrollTop > 365) {
            scrollTop = 365;
        }

        let posTop = offsetTop - scrollTop;

        if (posTop < posTopLimit) {
            posTop = posTopLimit;
        }

        $(selector).css('top', posTop);
    });
}

function _getBannerTopSection() {
    let section = $('h2');

    if ($('.layout-730').length > 0) {
        section = $('.layout-730');

        if (('.page').length > 0) {
            section = $('.inhaltsverzeichnis-wrap .placeholder-730');

            if ($('.inhaltsverzeichnis-wrap .inhaltsverzeichnis').length > 0) {
                section = $('.inhaltsverzeichnis-wrap .inhaltsverzeichnis');
            }
        }
    }

    return section;
}

function _getBannerWidestSection() {
    let section = _getBannerTopSection();

    // Class "template-themenwelt layout-flat" at the time refactoring banner position is applied only for Magazin/Themenwelt pages
    // Get first-child wrapper element to be able to obtain content width (~1110) and positions
    if ($('.template-themenwelt.layout-flat').length > 0) {
        section = $('.template-themenwelt.layout-flat > .wrap');
    }
  
    return section;
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



$( document ).ready(function() {
    $(".checkbox-rec_vid").append("<span onclick='call_rec_video_modal()' class='rec_video_modal_icon'> &#8505;</span>");
});
function call_rec_video_modal(e){
  $(".rec_video_link").trigger("click");  
}
