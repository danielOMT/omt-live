if ($('.ebooks-filter-dropdown').length > 0) {
    $(".ebooks-filter-dropdown").on('change', function () {
        event.preventDefault();

        $content = $('.content-flat');
        $selected = $('.ebooks-filter-dropdown option:selected').val();
        $wrapperstart = '<section class="omt-row wrap grid-wrap layout-flat color-area-kein" style="margin-left:auto;margin-right:auto;"><div class="color-area-inner"></div><div class="omt-module artikel-wrap teaser-modul" style="margin-left:auto;margin-right:auto;">';
        $wrapperend = '</div></section>';
        $.ajax({
            url: ebfiljamz.ajax_url,
            data: {
                action: 'do_filter_ebooks',
                category: $selected,
                nonce: ebfiljamz.nonce
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
    });
}