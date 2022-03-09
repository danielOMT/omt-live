export default () => {
  return {
    loading: false,
    showLoadMoreBtn: true,

    load() {
      this.showLoadMoreBtn = false;
      this.loading = true;

      jQuery
        .ajax({
          url: omt_load_articles.url,
          dataType: 'json',
          data: {
            action: 'omt_load_articles',
            nonce: omt_load_articles.nonce,
            format: this.$el.dataset.format,
            offset: this.$el.dataset.offset,
            post_type: this.$el.dataset.types
              ? JSON.parse(this.$el.dataset.types)
              : null
          }
        })
        .done((response) => {
          this.$refs.results.innerHTML = response.data.content;
        })
        .fail((jqXHR, textStatus, errorThrown) => {
          alert(jqXHR.responseJSON.response.message);
        })
        .always(() => {
          this.loading = false;
        });
    }
  };
};
