$(".artikel-loadmore").click(function (event) {
    event.preventDefault();
    $('.teaser-loadmore').css('max-height', 'none');
    $(this).css('display','none');
    $this = $(this);
    $container = $(this).closest('.omt-row');
    // Run query
    get_posts_artikel();
});
////übergabe funktioniert nicht. neuen Ansatz ausprobieren: https://rudrastyh.com/wordpress/ajax-post-filters.html
//alter ansatz? https://www.bobz.co/filter-wordpress-posts-by-custom-taxonomy-term-with-ajax-and-pagination/
function get_posts_artikel() {
    $content   = $container.find('.artikel-results');
    $status    = $container.find('.status');
    $status.css('display', 'block');
    $category = $('.artikel-loadmore').data('cat');
    $anzahl = $('.artikel-loadmore').data('anzahl');
    $format = $('.artikel-loadmore').data('format');
    $.ajax({
        url: artikeljamz.ajax_url,
        data: {
            action: 'do_filter_artikel',
            category: $category,
            anzahl: $anzahl,
            format: $format,
            nonce: artikeljamz.nonce
        },
        type: 'post',
        dataType: 'json',
        success: function(data, textStatus, XMLHttpRequest) {
            if (data.status === 200) {
                $content.html(data.content);
            }
            else if (data.status === 201) {
                $content.html(data.message);
            }
            else {
                $status.html(data.message);
            }
        },
        error: function(MLHttpRequest, textStatus, errorThrown) {
            $status.html(textStatus);
            console.log(MLHttpRequest);
             console.log(textStatus);
             console.log(errorThrown);
        },
        complete: function(data, textStatus) {
            msg = textStatus;
            if (textStatus === 'success') {
                msg = data.responseJSON.found;
            }
            $status.text('');
            console.log(data);
            console.log(textStatus);
        }
    });
    $('.teaser-loadmore').css('max-height', 'none');
}