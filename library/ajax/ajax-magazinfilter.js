if ($('.magazin-filter-dropdown ').length > 0) {
    $(".magazin-filter-dropdown").on('change', function () {
        event.preventDefault();
        $this = $(this);
        // Run query
        get_posts_magfilter();
    });
    ////übergabe funktioniert nicht. neuen Ansatz ausprobieren: https://rudrastyh.com/wordpress/ajax-post-filters.html
    //alter ansatz? https://www.bobz.co/filter-wordpress-posts-by-custom-taxonomy-term-with-ajax-and-pagination/
    function get_posts_magfilter() {
        $content = $('.content-flat');
        $selected = $('.magazin-filter-dropdown option:selected').val();
        $wrapperstart = '<section id="abschnitt-1" class="omt-row wrap grid-wrap  layout-flat color-area-kein " style="margin-left:auto;margin-right:auto;"><div class="color-area-inner"></div><div class="omt-module artikel-wrap teaser-modul "  style="margin-left:auto;margin-right:auto;">';
        $wrapperend = '</div></section>';
        $.ajax({
            url: magfijamz.ajax_url,
            data: {
                action: 'do_filter_magfilter',
                category: $selected,
                nonce: magfijamz.nonce
            },
            type: 'post',
            dataType: 'json',
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.status === 200) {
                    $content.html($wrapperstart+data.content+$wrapperend);
                } else if (data.status === 201) {
                    $content.html(data.message);
                }
            },
            complete: function (data, textStatus) {
                msg = textStatus;
                if (textStatus === 'success') {
                    msg = data.responseJSON.found;
                }
            }
        });
    }
}