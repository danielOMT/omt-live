subnavajax();
main_nav_ajax();
timerangeajax();
function main_nav_ajax() {
    $(document).on('click', '.backend-nav-button', function(e) {
        if (event.preventDefault) {
            event.preventDefault();
        }
        $this = $(this);
        $results_container = $('.module-backend-area');

        $('.toolanbieter-backend-navigation a').removeClass('active');
        $(this).addClass('active');

        $content = $('.backend-area-content');
        $subnav = $('.backend-area-subnav');
        $status = $('.toolanbieter-ajax-status');
        $status.css('display', 'block');
        $statushtml = '<i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Bereich wird geladen';
        $backendarea = $(this).data("backend");

        if ("toolanbieter-dashboard" == $backendarea) {
            $('.toolanbieter-subnav-wrap').addClass('display-none');
            $('.toolanbieter-main-content-wrap').addClass('fullwidth');
            $("#toolarea-headline").html('Dein Dashboard');
        }
        if ("toolanbieter-tools-bearbeiten" == $backendarea) {
            $('.toolanbieter-subnav-wrap').removeClass('display-none');
            $("#toolarea-headline").html('Deine Tools');
            $('.nav-tools').addClass('active');
        }
        if ("toolanbieter-bids" == $backendarea) {
            $('.toolanbieter-subnav-wrap').removeClass('display-none');
            $("#toolarea-headline").html('Deine Budgets & Preise');
        }
        if ("links" == $backendarea) {
            $('.toolanbieter-subnav-wrap').removeClass('display-none');
            $("#toolarea-headline").html('Deine Tracking-Links');
        }
        if ("toolanbieter-statistik" == $backendarea) {
            $('.toolanbieter-subnav-wrap').removeClass('display-none');
            $("#toolarea-headline").html('Deine Statistiken');
        }
        if ("toolanbieter-url-insights" == $backendarea) {
            $('.toolanbieter-subnav-wrap').removeClass('display-none');
            $("#toolarea-headline").html('Deine URL Insights');
        }
        if ("toolanbieter-stammdaten" == $backendarea) {
            $('.toolanbieter-subnav-wrap').addClass('display-none');
            $('.toolanbieter-main-content-wrap').addClass('fullwidth');
            $("#toolarea-headline").html('Deine Stammdaten');
            $('.nav-stammdaten').addClass('active');
        }

        $content.html("");
        $status.html($statushtml);
        $.ajax({
            url: tajamz.ajax_url,
            data: {
                action: 'do_show_backend',
                backendarea: $backendarea,
                nonce: tajamz.nonce
            },
            type: 'post',
            dataType: 'json',
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.status === 200) {
                    $content.html(data.content);
                    acf.do_action('append', $('.backend-area-content'));
                    $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                        $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                        $(this).find('.acf-taxonomy-field').html($newhtml);
                    });
                    timerangeajax();
                } else if (data.status === 201) {
                    $content.html(data.message);
                    acf.do_action('append', $('.backend-area-content'));
                    $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                        $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                        $(this).find('.acf-taxonomy-field').html($newhtml);
                    });
                } else {
                    $status.html(data.message);
                    acf.do_action('append', $('.backend-area-content'));
                    $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                        $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                        $(this).find('.acf-taxonomy-field').html($newhtml);
                    });
                }
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                $status.html(textStatus);
            },
            complete: function (data, textStatus) {

                msg = textStatus;

                if (textStatus === 'success') {
                    msg = data.responseJSON.found;
                }

                $status.text('');
            }
        });
        ////////////CONTENT FINISHED; NOW MAKING SUBNAV CALL FOR THE NEW BACKEND AREA
        $.ajax({
            url: tajamz.ajax_url,
            data: {
                action: 'do_show_subnav',
                backendarea: $backendarea,
                nonce: tajamz.nonce
            },
            type: 'post',
            dataType: 'json',
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.status === 200) {
                    $subnav.html(data.content);
                    acf.do_action('append', $('.backend-area-content'));
                    $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                        $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                        $(this).find('.acf-taxonomy-field').html($newhtml);
                        $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                            $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                            $(this).find('.acf-taxonomy-field').html($newhtml);
                        });
                    });
                } else if (data.status === 201) {
                    $subnav.html(data.message);
                    acf.do_action('append', $('.backend-area-content'));
                    $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                        $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                        $(this).find('.acf-taxonomy-field').html($newhtml);
                        $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                            $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                            $(this).find('.acf-taxonomy-field').html($newhtml);
                        });
                    });
                } else {
                    $subnav.html(data.message);
                    acf.do_action('append', $('.backend-area-content'));
                    $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                        $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                        $(this).find('.acf-taxonomy-field').html($newhtml);
                    });
                }
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                $status.html(textStatus);
            },
            complete: function (data, textStatus) {
                msg = textStatus;

                if (textStatus === 'success') {
                    msg = data.responseJSON.found;
                }

                $status.text('');
            }
        });
    });
}

///WHEN CLICKING ON MAIN NAV DONE => CLICKS ON SUBNAV AJAX BELOW
function subnavajax() {
    $('.toolanbieter-backend').on("click", ".toolanbieter-subnav-wrap .backend-area-subnav a", function () {
        if (event.preventDefault) {
            event.preventDefault();
        }
        $(this).parent().find('a').removeClass('active');
        $(this).addClass('active');
        $this = $(this);
        $results_container = $('.module-backend-area');

        $content = $('.backend-area-content');
        $subnav = $(this).parent();
        $status = $('.toolanbieter-ajax-status');
        $status.css('display', 'block');
        $statushtml = '<i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Bereich wird geladen';
        $backendarea = $(this).data("backend");
        $toolid = $(this).data("tool");
        $content.html("");
        $status.html($statushtml);

        let postData = {
            action: 'do_show_backend',
            backendarea: $backendarea,
            toolid: $toolid,
            nonce: tajamz.nonce
        };

        if ($backendarea == 'toolanbieter-url-insights') {
            postData.url = $(this).data("url");
            postData.page = $(this).data("page");
        }

        $.ajax({
            url: tajamz.ajax_url,
            data: postData,
            type: 'post',
            dataType: 'json',
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.status === 200) {
                    $content.html(data.content);
                    acf.do_action('append', $('.backend-area-content'));
                    $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                        $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                        $(this).find('.acf-taxonomy-field').html($newhtml);
                    });
                    timerangeajax();
                } else if (data.status === 201) {
                    $content.html(data.message);
                    acf.do_action('append', $('.backend-area-content'));
                    $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                        $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                        $(this).find('.acf-taxonomy-field').html($newhtml);
                    });
                } else {
                    $status.html(data.message);
                    acf.do_action('append', $('.backend-area-content'));
                    $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                        $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                        $(this).find('.acf-taxonomy-field').html($newhtml);
                    });
                }
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                $status.html(textStatus);
            },
            complete: function (data, textStatus) {
                msg = textStatus;

                if (textStatus === 'success') {
                    msg = data.responseJSON.found;
                }

                $status.text('');
            }
        });
    });
}

function timerangeajax() {
    $('#content #filter-daterange').click(function () {
        if (event.preventDefault) {
            event.preventDefault();
        }

        $this = $(this);
        $results_container = $('.module-backend-area');

        $content = $('.backend-area-content');
        $subnav = $('.backend-area-subnav');
        $status = $('.toolanbieter-ajax-status');
        $status.css('display', 'block');
        $statushtml = '<i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Bereich wird geladen';
        $backendarea = $(this).data("backend");
        $toolid = $(this).data("tool");
        $date_from = $("#rangefrom").val();
        $date_to = $("#rangeto").val();
        $content.html("");
        $status.html($statushtml);

        $.ajax({
            url: tajamz.ajax_url,
            data: {
                action: 'do_show_backend',
                backendarea: $backendarea,
                toolid: $toolid,
                date_from: $date_from,
                date_to: $date_to,
                nonce: tajamz.nonce
            },
            type: 'post',
            dataType: 'json',
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.status === 200) {
                    $content.html(data.content);
                    acf.do_action('append', $('.backend-area-content'));
                    $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                        $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                        $(this).find('.acf-taxonomy-field').html($newhtml);
                    });
                    timerangeajax();
                } else if (data.status === 201) {
                    $content.html(data.message);
                    acf.do_action('append', $('.backend-area-content'));
                    $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                        $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                        $(this).find('.acf-taxonomy-field').html($newhtml);
                    });
                } else {
                    $status.html(data.message);
                    acf.do_action('append', $('.backend-area-content'));
                    $('.acf-field-5eaaa1ca19efc .acf-row').each(function(){
                        $newhtml = $(this).find('.acf-taxonomy-field select option:selected').text();
                        $(this).find('.acf-taxonomy-field').html($newhtml);
                    });
                }
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {
                $status.html(textStatus);
            },
            complete: function (data, textStatus) {
                msg = textStatus;

                if (textStatus === 'success') {
                    msg = data.responseJSON.found;
                }

                $status.text('');
            }
        });
    });
}