$('#tool-sort-options').change(function () {
    $sortoption = $(this). children("option:selected").val();
    $this = $(this);
    $container = $(this).closest('.omt-row');
    ////übergabe funktioniert nicht. neuen Ansatz ausprobieren: https://rudrastyh.com/wordpress/ajax-post-filters.html
    //alter ansatz? https://www.bobz.co/filter-wordpress-posts-by-custom-taxonomy-term-with-ajax-and-pagination/
    $content   = $container.find('.tool-results');
    $status    = $container.find('.toolindex-ajax-status');
    $status.css('display', 'block');
    $statushtml = '<i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Tools werden geladen';
    $filter_price = $('.filter-preis .radio-active').data('filter');
    $filter_testbericht = $('.filter-checkbox .filter-checkbox-active').data('filter');
    var numItems = $('.filter-checkbox .filter-checkbox-active').length;
    if (numItems > 0) {} else { $filter_testbericht=0; }
    var pageid = $content.data('pageid');
    var tabellenid = $content.data('tabelle');
    if (tabellenid.length<1) { tabellenid=0;}
    var indextype = $content.data('indextype');
    var index_taxonomy = $content.data('taxonomy');
    if (index_taxonomy.length<1) { index_taxonomy=0;}
    $content.html("");
    $status.html($statushtml);
    $.ajax({
        url: toolindexjamz.ajax_url,
        data: {
            action: 'do_sort_tools',
            sort_option: $sortoption,
            filter_price: $filter_price,
            filter_testbericht: $filter_testbericht,
            pageid: pageid,
            tabellenid: tabellenid,
            indextype: indextype,
            index_taxonomy: index_taxonomy,
            nonce: toolindexjamz.nonce
        },
        type: 'post',
        dataType: 'json',
        success: function(data, textStatus, XMLHttpRequest) {
            if (data.status === 200) {
                $content.html(data.content);
                tool_ubersicht_more();
            } else if (data.status === 201) {
                $content.html(data.message);
                tool_ubersicht_more();
            } else {
                $status.html(data.message);
                tool_ubersicht_more();
            }
        },
        error: function(MLHttpRequest, textStatus, errorThrown) {
            $status.html(textStatus);
        },
        complete: function(data, textStatus) {
            msg = textStatus;

            if (textStatus === 'success') {
                msg = data.responseJSON.found;
            }

            $status.text('');
        }
    });
});

$('.filter').click(function() {
    $this = $(this);
    $results_container = $(this).parent().parent().parent().parent();

    if ($(this).hasClass('filter-radio')) {
        $(this).closest('.filter-wrap').children('.filter').removeClass('radio-active');
        $(this).closest('.filter-wrap').children('.filter').children('.fa').removeClass('fa-check-circle').removeClass('fa-circle').addClass('fa-circle');
        $(this).children('.fa').removeClass('fa-circle').addClass('fa-check-circle');
        $(this).addClass('radio-active');
    }
    if ($(this).hasClass('filter-checkbox')) {
        $(this).toggleClass('filter-checkbox-active');
        $(this).children('.fa').toggleClass('fa-square').toggleClass('fa-check-square');
    }
    $container = $(this).closest('.omt-row');
    $content   = $container.find('.tool-results');
    $status    = $container.find('.toolindex-ajax-status');
    $status.css('display', 'block');
    $statushtml = '<i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Tools werden geladen';
    $filter_price = $('.filter-preis .radio-active').data('filter');
    $filter_testbericht = $('.filter-checkbox .filter-checkbox-active').data('filter');
    $sortoption = $('#tool-sort-options'). children("option:selected").val();
    var numItems = $('.filter-checkbox .filter-checkbox-active').length;
    if (numItems > 0) {} else { $filter_testbericht=0; }
    var pageid = $content.data('pageid');
    var tabellenid = $content.data('tabelle');
    if (tabellenid.length<1) { tabellenid=0;}
    var indextype = $content.data('indextype');
    var index_taxonomy = $content.data('taxonomy');
    if (index_taxonomy.length<1) { index_taxonomy=0;}
    $content.html("");
    $status.html($statushtml);
    $.ajax({
        url: toolindexjamz.ajax_url,
        data: {
            action: 'do_sort_tools',
            sort_option: $sortoption,
            filter_price: $filter_price,
            filter_testbericht: $filter_testbericht,
            pageid: pageid,
            tabellenid: tabellenid,
            indextype: indextype,
            index_taxonomy: index_taxonomy,
            nonce: toolindexjamz.nonce
        },
        type: 'post',
        dataType: 'json',
        success: function(data, textStatus, XMLHttpRequest) {
            if (data.status === 200) {
                $content.html(data.content);
                tool_ubersicht_more();
                $('html, body').animate({
                    scrollTop: $($results_container).offset().top
                }, 400);
                $('.index-collapse-button').removeClass('tool-results-collapse-button');
            } else if (data.status === 201) {
                $content.html(data.message);
                tool_ubersicht_more();
                $('html, body').animate({
                    scrollTop: $($results_container).offset().top
                }, 400);
            } else {
                $status.html(data.message);
                tool_ubersicht_more();
                $('html, body').animate({
                    scrollTop: $($results_container).offset().top
                }, 400);
            }
        },
        error: function(MLHttpRequest, textStatus, errorThrown) {
            $status.html(textStatus);
        },
        complete: function(data, textStatus) {

            msg = textStatus;

            if (textStatus === 'success') {
                msg = data.responseJSON.found;
            }

            $status.text('');
        }
    });
});
