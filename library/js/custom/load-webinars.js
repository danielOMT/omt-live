function xLoadWebinars() {
    return {
        load(e) {
            $(e.target).hide();
            $(".webinare-ajax-status").show();
            $(".teaser-loadmore").css("max-height", "none");

            $container = $(e.target).closest(".omt-row");
            $content = $container.find(".webinare-results");

            $.ajax({
                url: omt_load_webinars.ajax_url,
                type: "post",
                dataType: "json",
                data: {
                    action: "omt_load_webinars",
                    nonce: omt_load_webinars.nonce,
                    offset: e.target.dataset.offset,
                    categories: e.target.dataset.categories
                },
                success: function (response, textStatus, XMLHttpRequest) {
                    $content.html(response.data.content);
                },
                error: function (MLHttpRequest, textStatus, errorThrown) {
                    $content.html(textStatus);
                }
            });
        }
    };
}
