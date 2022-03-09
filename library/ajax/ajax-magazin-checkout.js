function hideMagazinCheckout() {
    jQuery("#omt-magazin-checkout").hide();
}

function addMagazinProductToCart(productId, type = "product") {
    jQuery("#omt-magazin-checkout").show();

    jQuery.ajax({
        url: magchekjamz.ajax_url,
        type: "post",
        dataType: "json",
        data: {
            action: "add_magazin_product_to_cart",
            nonce: magchekjamz.nonce,
            type: type,
            product_id: productId
        },
        success: function (data, textStatus, XMLHttpRequest) {
            jQuery(document.body).trigger("update_checkout");
        },
        error: function (MLHttpRequest, textStatus, errorThrown) {
            alert(textStatus);
        }
    });
}
