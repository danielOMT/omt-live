function xUpdateToolTrackingLink(initUrl) {
    return {
        error: false,
        message: '',
        loading: false,
        url: initUrl,

        save(toolId, categoryId, type) {
            this.error = false;
            this.loading = true;

            $.ajax({
                url: omt_update_tool_tracking_link.ajax_url,
                type: "post",
                dataType: "json",
                data: {
                    action: "omt_update_tool_tracking_link",
                    nonce: omt_update_tool_tracking_link.nonce,
                    tool_id: toolId,
                    category_id: categoryId,
                    type: type,
                    url: this.url
                }
            }).done((data) => {
                if (data.error) {
                    this.error = true;
                    this.message = data.message;
                } else {
                    $('[data-type=' + type + '][data-category=' + categoryId + ']').html(this.url);
                    this.$el.dispatchEvent(new CustomEvent('close-modal', { bubbles: true }));
                }
            }).fail((jqXHR, textStatus, errorThrown) => {
                this.error = true;
                this.message = errorThrown;
            }).always(() => {
                this.loading = false;
            });
        }
    }
}
