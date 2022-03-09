$('#tool-alternatives-sort-options').change(function () {
    $container = $(this).closest('.omt-row');
    $content = $container.find('.tool-results');
    $status = $container.find('#tool-alternatives-ajax-status');
    
    $content.html("");
    $status.html('<i class="fa fa-circle-o-notch fa-spin fa-fw" style="vertical-align:middle;"></i>Tools werden geladen');
    $status.css('display', 'block');

    $.ajax({
        url: toolalternjamz.ajax_url,
        type: 'post',
        dataType: 'json',
        data: {
            action: 'do_sort_tool_alternatives',
            sort: $(this).val(),
            pageid: $content.data('pageid'),
            nonce: toolalternjamz.nonce
        },
        success: function(data, textStatus, XMLHttpRequest) {
            if (data.status === 200) {
                $content.html(data.content);
            } else if (data.status === 201) {
                $content.html(data.message);
            } else {
                $status.html(data.message);
            }

            tool_ubersicht_more();
        },
        error: function(MLHttpRequest, textStatus, errorThrown) {
            $status.html(textStatus);
        },
        complete: function(data, textStatus) {
            $status.text('');
        }
    });
});
