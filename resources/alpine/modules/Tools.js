export default () => {
  return {
    loading: false,
    order: 'sponsored',
    filter: {
      price: '0',
      review: false
    },

    init() {
      this.$watch('filter.price', () => {
        this.fetch();
      });

      this.$watch('filter.review', () => {
        this.fetch();
      });
    },

    fetch() {
      this.loading = true;
      this.$refs.tools.innerHTML = '';

      $.ajax({
        url: omt_load_tools.url,
        dataType: 'json',
        data: {
          action: 'omt_load_tools',
          nonce: omt_load_tools.nonce,
          type: this.$refs.tools.dataset.type,
          table: this.$refs.tools.dataset.table,
          category: this.$refs.tools.dataset.category,
          order: this.order,
          filter: {
            price: this.filter.price,
            review: this.filter.review ? 1 : 0
          }
        }
      })
        .done((response) => {
          this.$refs.tools.innerHTML = response.data.content;
          tool_ubersicht_more();

          $('html, body').animate({
            scrollTop: ($(this.$refs.tools).offset().top - 280)
          }, 400);
        })
        .fail((jqXHR, textStatus, errorThrown) => {
          this.$refs.tools.innerHTML = errorThrown;
        })
        .always(() => {
          this.loading = false;
        });
    }
  };
};
