$(".webinare-loadmore").click(function (event) {
    event.preventDefault();

    $('.teaser-loadmore').css('max-height', 'none');
    $(this).css('display','none');
    $this = $(this);
    $container = $(this).closest('.omt-row');

    // Run query
    get_posts_webinare();
});
////übergabe funktioniert nicht. neuen Ansatz ausprobieren: https://rudrastyh.com/wordpress/ajax-post-filters.html
//alter ansatz? https://www.bobz.co/filter-wordpress-posts-by-custom-taxonomy-term-with-ajax-and-pagination/
function get_posts_webinare() {
    $content   = $container.find('.webinare-results');
    $status    = $container.find('.status');
    $status.css('display', 'block');
    $category = $('.webinare-loadmore').data('cat');
    $anzahl = $('.webinare-loadmore').data('anzahl');

    $.ajax({
        url: webjamz.ajax_url,
        data: {
            action: 'do_filter_webinare',
            category: $category,
            anzahl: $anzahl,
            nonce: webjamz.nonce
        },
        type: 'post',
        dataType: 'json',
        success: function(data, textStatus, XMLHttpRequest) {
            if (data.status === 200) {
                $content.html(data.content);
            } else if (data.status === 201) {
                $content.html(data.message);
            } else {
                $status.html(data.message);
            }
        },
        error: function(MLHttpRequest, textStatus, errorThrown) {
            $status.html(textStatus);
        },
        complete: function(data, textStatus) {
            $status.text('');
        }
    });
    
    $('.teaser-loadmore').css('max-height', 'none');
}