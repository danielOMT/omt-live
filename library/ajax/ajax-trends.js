//array für alle terms des filters deklarieren
var all_terms = new Array();

$('.trends-abschnitt').on('click', 'a[data-filter], .pagination a', function(event) {
    $container = $(this).closest('.trends-abschnitt');
    $dataset = $(this).closest('.trends-abschnitt').data('dataset');
    console.log($dataset);
    if(event.preventDefault) { event.preventDefault(); }

    $this = $(this);

    if ($this.data('filter')) {
        /**
         * Click on tag cloud
         */
        //falls auf alle anzeigen geklickt wird, alle anderen deaktivieren, ansonsten Button vom "alle anzeigen deaktivieren
        if ("all-terms" == $this.data('term')) {
            $this.closest('ul').find('.active').removeClass('active');
            all_terms.length=0;
        }
        else {
            $this.closest('ul').find('.alle-anzeigen').removeClass('active');
            //remove "alle-anzeigen" from our filtering array!
            var removeItem = "all-terms";

            all_terms = jQuery.grep(all_terms, function(value) {
                return value != removeItem;
            });
        }

        //wenn man auf ein aktives feld klickt, deaktivieren, ansonsten aktivieren
        if ($this.parent('li').hasClass('active')) {
           // $this.parent('li').removeClass('active');
            //remove term from our filtering array!
            var removeItem = $this.closest('a').data('term');

            all_terms = jQuery.grep(all_terms, function(value) {
                return value != removeItem;
            });
        }
        else {
            $this.closest('ul').find('.active').removeClass('active');
            $this.parent('li').addClass('active');
            //array befüllen mit allen terms, welche aktiv geschaltet wurden
            //alert($this.closest('a').data('term'));
            all_terms.length=0;
            all_terms.push($this.closest('a').data('term'));
        }
       // $page = $this.data('page');
    }
    else {
        /**
         * Click on pagination
         */
      //  $page = parseInt($this.attr('href').replace(/\D/g,''));
        $this = $('.nav-filter .active a');
    }

    $params    = {
      //  'page' : $page,
        'tax'  : $this.data('filter'),
        'term' : $this.data('term'),
      //  'qty'  : $this.closest('#container-async').data('paged'),
        'all_terms'  : all_terms, //array mit allen angeklickten Werten übergeben,
        'dataset' : $dataset, //dataset mit IDs aller ursprünglichen in diesem Container vorhandenen Trend IDs
    };

    // Run query
    get_posts_trends($params);


    var newHTML = [];
    $.each(all_terms, function(index, value) {
        newHTML.push('<h5>' + value + '</h5>');
    });
   // $(".sidebar").html(newHTML.join(""));
    //$(".sidebar").html($params['term']);

});
////übergabe funktioniert nicht. neuen Ansatz ausprobieren: https://rudrastyh.com/wordpress/ajax-post-filters.html
//alter ansatz? https://www.bobz.co/filter-wordpress-posts-by-custom-taxonomy-term-with-ajax-and-pagination/
function get_posts_trends($params) {

    //$container = $('.trends-abschnitt');
    $content   = $container.find('.results-content');
    $status    = $container.find('.status');

    $status.text('Trends werden geladen ...');

    $.ajax({
        url: jamz.ajax_url,
        data: {
            action: 'do_filter_trends',
            nonce: jamz.nonce,
            params: $params
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
}