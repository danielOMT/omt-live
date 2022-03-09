//subnavajax();
main_nav_ajax();
function main_nav_ajax() {
    $(document).on('click', '.botschafter-nav-button', function(e) {
        if (event.preventDefault) {
            event.preventDefault();
        }
        $this = $(this);
        $results_container = $('.module-backend-area');

        $('.botschafter-backend-navigation a').removeClass('active');
        $(this).addClass('active');
        $content = $('.backend-area-content');
        $status = $('.botschafter-ajax-status');
        $status.css('display', 'block');
        $statushtml = '<i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Bereich wird geladen';
        $backendarea = $(this).data("backend");

        if ("botschafter-dashboard" == $backendarea) {
            $("#botschafter-headline").html('Dein Dashboard');
        }
        if ("botschafter-marketing" == $backendarea) {
            $("#botschafter-headline").html('Marketing Materialien');
        }
        //console.log($backendarea);
        $content.html("");
        $status.html($statushtml);
        $.ajax({
            url: botschjamz.ajax_url,
            data: {
                action: 'do_show_botschafter',
                backendarea: $backendarea,
                nonce: botschjamz.nonce
            },
            type: 'post',
            dataType: 'json',
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.status === 200) {
                    $content.html(data.content);
                } else if (data.status === 201) {
                    $content.html(data.message);
                } else {
                    $status.html(data.message);
                }
            },
            error: function (MLHttpRequest, textStatus, errorThrown) {

                $status.html(textStatus);

                console.log(MLHttpRequest);
                console.log(textStatus);
                console.log(errorThrown);
            },
            complete: function (data, textStatus) {

                msg = textStatus;

                if (textStatus === 'success') {
                    msg = data.responseJSON.found;
                }

                $status.text('');

                /* console.log(data);
                 console.log(textStatus);*/
            }
        });
    });
}