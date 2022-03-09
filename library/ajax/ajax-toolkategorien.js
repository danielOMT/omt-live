$(".tools-kategorien-teaser ul li").click(function (event) {
    $this = $(this);
    if (!$this.hasClass('button-wrap')) {
        $('.tools-kategorien-teaser ul li').removeClass('active');
        $(this).addClass('active');
        // Run query
        get_posts_toolkategorien();
    }
});
////übergabe funktioniert nicht. neuen Ansatz ausprobieren: https://rudrastyh.com/wordpress/ajax-post-filters.html
//alter ansatz? https://www.bobz.co/filter-wordpress-posts-by-custom-taxonomy-term-with-ajax-and-pagination/
function get_posts_toolkategorien() {
    $content   = $('#toolkategorie-results');
    $status    = $('#tools-status');
    // $status.css('display', 'block');
    $category = $this.data('cat');
    $link = $this.data('link');

    $.ajax({
        url: toolkajamz.ajax_url,
        data: {
            action: 'do_filter_toolkategorien',
            category: $category,
            catlink: $link,
            nonce: toolkajamz.nonce
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