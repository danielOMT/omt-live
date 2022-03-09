$(".umfrage-submit").click(function (event) {
if ($(this).hasClass('umfrage-submit-clickable')) {
    event.preventDefault();
    //$('.teaser-loadmore').css('max-height', 'none');
    // $(this).css('display','none');
    $this = $(this);
    $container = $(this).parent();


    // Run query
    bearbeite_umfrage_eingaben();
}
});

function umfrageremoveinputonsuccess() {
    var numItems = $('.status-success').length;
    if (numItems > 0) {
        $('#email').remove();
        $('#code').remove();
        $('#name').remove();
        $('.umfrage-submit').remove();
        $('.early-bird-submit h3').remove();
    }
}
////übergabe funktioniert nicht. neuen Ansatz ausprobieren: https://rudrastyh.com/wordpress/ajax-post-filters.html
//alter ansatz? https://www.bobz.co/filter-wordpress-posts-by-custom-taxonomy-term-with-ajax-and-pagination/
function bearbeite_umfrage_eingaben() {
    $content   = $container.find('.results');
    $status    = $container.find('.status');
    $status.css('display', 'flex');
    var $array = [];
    $('.vortrag-voted').each(function(){
        var id = $(this).data('id');
        $array.push(id);
    });
    $votes = $array.join(", ");
    $name = $('#name').val();
    $email = $('#email').val();
    $code = $('#code').val();
    $umfrageid = $this.parent().data('umfrageid');

    $.ajax({
        url: umfragejamz.ajax_url,
        data: {
            action: 'do_check_umfrage',
            votes: $votes,
            name: $name,
            email: $email,
            code: $code,
            umfrageid: $umfrageid,
            nonce: umfragejamz.nonce
        },
        type: 'post',
        dataType: 'json',
        success: function(data, textStatus, XMLHttpRequest) {

            if (data.status === 200) {
                $content.html(data.content);
                umfrageremoveinputonsuccess();
            }
            else if (data.status === 201) {
                $content.html(data.message);
                umfrageremoveinputonsuccess();
            }
            else {
             //   $status.html(data.message);
                $status.css('display', 'none');
                umfrageremoveinputonsuccess();
            }
        },
        error: function(MLHttpRequest, textStatus, errorThrown) {

     //       $status.html(textStatus);
            $status.css('display', 'none');
            console.log(MLHttpRequest);
             console.log(textStatus);
             console.log(errorThrown);
        },
        complete: function(data, textStatus) {

            msg = textStatus;

            if (textStatus === 'success') {
                msg = data.responseJSON.found;
            }

         //   $status.text('');
            $status.css('display', 'none');

            console.log(data);
            console.log(textStatus);
        }
    });
    $('.teaser-loadmore').css('max-height', 'none');
}