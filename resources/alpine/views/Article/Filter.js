export default () => {
  return {
    post_type: 0,

    fetch() {
      jQuery
        .ajax({
          url: omt_filter_articles.url,
          dataType: 'json',
          data: {
            action: 'omt_filter_articles',
            nonce: omt_filter_articles.nonce,
            post_type: this.post_type
          }
        })
        .done((response) => {
          $('.content-flat').html(response.data.content);
        })
        .fail((jqXHR, textStatus, errorThrown) => {
          alert(jqXHR.responseJSON.response.message);
        });
    }
  };
};
