/////CHANGE BIDS FOR CLICKS, BUDGETS COME BELOW
$(document).on('click', '.change-bid', function(e) {
    $(this).parent().html('<input style="width:100%;" type="number" step="0.01" min="2" max="25" placeholder="neues Gebot"><span class="go">bestätigen</span><span class="cancel">abbrechen</span>');
});

$(document).on('click', '.gebote-wrap tr td .cancel', function(e) {
    $oldbid = $(this).parent().data('bidprice');
    $tdvalue = $oldbid+' € / Klick <span class="change-bid">(ändern)</span>';
    $(this).parent().html($tdvalue);
});

$(document).on('click', '.gebote-wrap tr td .go', function(e) {
    // Run query
    $bid = parseFloat($(this).parent().children("input").val());
    $bid_id = $(this).parent().data('bid');
    $cat_id = $(this).parent().data('cat');
    $content = $(this).parent();

    if (isNaN($bid) || $bid < 2) {
        alert('Bitte geben Sie ein gültiges Gebot ein. Der Mindestwert beträgt 2€');
    } else {
        $.ajax({
            url: bidjamz.ajax_url,
            data: {
                action: 'do_perform_bid',
                cat_id: $cat_id,
                bid_id: $bid_id,
                bid: $bid,
                nonce: bidjamz.nonce
            },
            type: 'post',
            dataType: 'json',
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.status === 200) {
                    $content.replaceWith(data.content);
                } else {
                    alert(data.message);
                }
            }
        });
    }
});
//////////END OF CHANGE BIDS

////CHANGE BUDGETS
$(document).on('click', '.change-budget', function(e) {
    if (event.preventDefault) {
        event.preventDefault();
    }
    $this = $(this);
    $results_container = $(this).parent();
    $results_container.html('<input style="width:100%;" type="number" step="0.01" min="1" max="25" placeholder="neues Gebot"><span class="go">bestätigen</span><span class="cancel">abbrechen</span>');
});

$(document).on('click', '.budgets tr td .cancel', function(e) {
    $oldbudget = $(this).parent().data('budget');
    $tdvalue = $oldbudget+' € <span class="change-budget">(ändern)</span>';
    $(this).parent().html($tdvalue);
});

$(document).on('click', '.budgets tr td .go', function(e) {
    // Run query
    $bid = $(this).parent().children("input").val();
    $toolid = $(this).parent().data('tool');
    $content = $(this).parent();
    $.ajax({
        url: bidjamz.ajax_url,
        data: {
            action: 'do_perform_budget',
            toolid: $toolid,
            bid: $bid,
            nonce: bidjamz.nonce
        },
        type: 'post',
        dataType: 'json',
        success: function (data, textStatus, XMLHttpRequest) {
            if (data.status === 200) {
                $content.replaceWith(data.content);
            } else if (data.status === 201) {
                $content.replaceWith(data.message);
            } else {
                $status.replaceWith(data.message);
            }
        },
        error: function (MLHttpRequest, textStatus, errorThrown) {
            $status.html(textStatus);
        },
        complete: function (data, textStatus) {
            $status.text('');
        }
    });
});