function xDeleteToolTrackingLink() {
    return {
        error: false,
        message: '',
        loading: false,

        destroy(toolId, categoryId, type) {
            this.error = false;
            this.loading = true;

            $.ajax({
                url: omt_delete_tool_tracking_link.ajax_url,
                type: "post",
                dataType: "json",
                data: {
                    action: "omt_delete_tool_tracking_link",
                    nonce: omt_delete_tool_tracking_link.nonce,
                    tool_id: toolId,
                    category_id: categoryId,
                    type: type
                }
            }).done((data) => {
                if (data.error) {
                    this.error = true;
                    this.message = data.message;
                } else {
                    $('[data-type=' + type + '][data-category=' + categoryId + ']').html('<span class="x-text-gray x-text-sm">Nicht definiert</span>');
                    this.$el.dispatchEvent(new CustomEvent('close-modal', { bubbles: true }));
                    $(this.$el).parents('.delete-tracking-link-container').remove();
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
