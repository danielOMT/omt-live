const alertStatus = (e) => {
    if (jQuery("#rec_vid").is(":checked")) {
        $.ajax({
            url: recvideo.ajax_url,
            data: {
                action: 'do_rec_video',
                video: 1,
                nonce: recvideo.nonce
            },
            type: 'post',
            dataType: 'json',
            success: function (data, textStatus, XMLHttpRequest) {  
                if (data.status === 200) {
                    jQuery('body').trigger('update_checkout');
                } 
            },     
        });
    }else{
        $.ajax({
            url: recvideo.ajax_url,
            data: {
                action: 'do_rec_video',
                video: 0,
                nonce: recvideo.nonce
            },
            type: 'post',
            dataType: 'json',
            success: function (data, textStatus, XMLHttpRequest) {  
                if (data.status === 200) {
                    jQuery('body').trigger('update_checkout');
                } 
            },     
        });
    }
}
jQuery(document).on("click", "#rec_vid", alertStatus);

alert();


