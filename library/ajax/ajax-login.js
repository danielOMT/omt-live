jQuery(document).ready(function ($) {
    // Display form from link inside a popup
    $('#pop_login, #pop_signup').on('click', function (e) {
        formToFadeOut = $('form#register');
        formtoFadeIn = $('form#login');
        if ($(this).attr('id') == 'pop_signup') {
            formToFadeOut = $('form#login');
            formtoFadeIn = $('form#register');
        }
        formToFadeOut.fadeOut(500, function () {
            formtoFadeIn.fadeIn();
        })
        return false;
    });
    // Close popup
    $(document).on('click', '.login_overlay, .close', function () {
        $('form#login, form#register').fadeOut(500, function () {
            $('.login_overlay').remove();
        });
        return false;
    });

    // Show the login/signup popup on click
    $('#show_login, #show_signup').on('click', function (e) {
        if ($(this).attr('id') == 'show_login')
            $('form#login').fadeIn(500);
        else
            $('form#register').fadeIn(500);
        e.preventDefault();
    });

    // Perform AJAX login/register on form submit
    $('form#login, form#register').on('submit', function (e) {
        if (!$(this).valid()) return false;
        $('p.status', this).show().text(ajax_auth_object.loadingmessage);
        action = 'ajaxlogin';
        username = 	$('form#login #username').val();
        password = $('form#login #password').val();
        email = '';
        security = $('form#login #security').val();
        if ($(this).attr('id') == 'register') {
            action = 'ajaxregister';
            username = $('#signonname').val();
            password = $('#signonpassword').val();
            email = $('#email').val();
            security = $('#signonsecurity').val();
        }
        ctrl = $(this);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_auth_object.ajaxurl,
            data: {
                'action': action,
                'username': username,
                'password': password,
                'email': email,
                'security': security
            },
            success: function (data) {
                $('p.status', ctrl).text(data.message);

                if (data.loggedin == true) {
                    // Redirect to Resume page if it's set
                    if (ajax_auth_object.redirecturl.includes('/account/resume')) {
                        document.location.href = ajax_auth_object.redirecturl;
                    } else {
                        // Remove changing page title event handler
                        if (typeof changePageTitle == 'function') {
                            $(window).off("blur focus", changePageTitle);
                        }
    
                        $('p.status').css('display','block');
                        $('p.status').text('Login Erfolgreich. Willkommen zurück!');
    
                        setTimeout(function() {
                            $('.header').removeClass('login-open');
                            $('#login-area').removeClass('open');
                            $('#login-area').addClass('hidden');
                            $('#login-area').css('display', 'none');
                            $('.button-login span').html('<a href="/logout/">Logout</a>');
                            $('.button-login').removeClass('button-login');
                            $('.button-login').addClass('button-logout');
                        }, 1000);
    
                        $(".player-wrap").each(function(){
                            var embedcode = $(this).attr("data-members")
                            $(this).html('<div class="video-wrap player-wrap"><script src="//fast.wistia.com/embed/medias/'+embedcode+'.jsonp" async></script><script src="//fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding"><div class="wistia_responsive_wrapper"><div class="wistia_embed wistia_async_'+embedcode+'">&nbsp;</div></div></div></div>');
                        });
                    }
                }
            }
        });

        e.preventDefault();
    });

    // Client side form validation
    if (jQuery("#register").length)
        jQuery("#register").validate(
            {
                rules:{
                    password2:{ equalTo:'#signonpassword'
                    }
                }}
        );
    else if (jQuery("#login").length)
        jQuery("#login").validate();
});