function xCreateToolProviderUser() {
    return {
        notice: false,
        noticeType: null,
        message: '',
        loading: false,
        website_url: '',
        prices_url: '',
        test_url: '',
        data: {
            first_name: '',
            last_name: '',
            email: '',
            password: '',
            firma: '',
            deposit: 0,
            activate_buttons: false
        },

        save() {
            let alertEl = this.$refs.alertContainer;

            this.notice = false;
            this.loading = true;

            let trackingLinks = [
                {
                    category_id: 0,
                    type: 'website',
                    url: this.website_url
                },
                {
                    category_id: 0,
                    type: 'price_overview',
                    url: this.prices_url
                },
                {
                    category_id: 0,
                    type: 'test',
                    url: this.test_url
                }
            ];

            $(this.$refs['tracking-links']).find('.acf-row:not(.acf-clone)').each((index, element) => {
                let categoryId = $(element).find('[data-name="kategorie"]').find('select').val();

                if (categoryId) {
                    trackingLinks.push({
                        category_id: categoryId,
                        type: 'website',
                        url: $(element).find('[data-name="kategorie_zur_website_link"]').find('input:text').val()
                    });

                    trackingLinks.push({
                        category_id: categoryId,
                        type: 'price_overview',
                        url: $(element).find('[data-name="kategorie_preisubersicht_link"]').find('input:text').val()
                    });

                    trackingLinks.push({
                        category_id: categoryId,
                        type: 'test',
                        url: $(element).find('[data-name="kategorie_tool_testen_link"]').find('input:text').val()
                    });
                }
            });

            $.ajax({
                url: omt_create_tool_provider_user.ajax_url,
                type: "post",
                dataType: "json",
                data: {
                    action: "omt_create_tool_provider_user",
                    nonce: omt_create_tool_provider_user.nonce,
                    ...this.data,
                    tools: $(this.$refs.tools).find('select').val(),
                    tracking_links: trackingLinks
                }
            }).done((data) => {
                this.notice = true;
                this.noticeType = 'success';
                this.message = data.response.message;
                alertEl.scrollIntoView({block: "center", behavior: "smooth"});

                // Reset fields
                this.data.first_name = '';
                this.data.last_name = '',
                this.data.email = '';
                this.data.password = '';
                this.data.firma = '';
                this.data.deposit = 0;
                this.data.website_url = '';
                this.data.prices_url = '';
                this.data.test_url = '';
                this.data.activate_buttons = false;
            }).fail((jqXHR, textStatus, errorThrown) => {
                this.notice = true;
                this.noticeType = 'error';
                this.message = jqXHR.responseJSON ? jqXHR.responseJSON.response.message : 'Undefined error';
                alertEl.scrollIntoView({block: "center", behavior: "smooth"});
            }).always(() => {
                this.loading = false;
            });
        }
    }
}
