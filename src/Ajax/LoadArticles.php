<?php

namespace OMT\Ajax;

use OMT\Enum\Magazines;
use OMT\Model\Datahost\Article;
use OMT\Services\Response;
use OMT\View\ArticleView;

class LoadArticles extends Ajax
{
    public function handle()
    {
        $filters = [];

        if (isset($_GET['post_type']) && $this->inArrayAll((array) $_GET['post_type'], Magazines::keys())) {
            $filters['postType'] = $_GET['post_type'];
        }

        $options = [
            'order' => 'post_date',
            'order_dir' => 'DESC',
            'offset' => (int) $_GET['offset'] ?? 0,
            'with' => ['experts']
        ];

        Response::json([
            'content' => $this->fixEncoding(ArticleView::loadTemplate('items', [
                'articles' => Article::init()->activeItems($filters, $options),
                'format' => $_GET['format'] ?: 'mixed'
            ]))
        ]);
    }

    public function enqueueScripts()
    {
        wp_enqueue_script('alpine-app', get_template_directory_uri() . '/library/js/app.js', [], 'c.1.0.4', true);
        wp_localize_script('alpine-app', $this->getAction(), [
            'nonce' => wp_create_nonce($this->getAction()),
            'url' => admin_url('admin-ajax.php')
        ]);
    }

    protected function fixEncoding(string $html)
    {
        return mb_convert_encoding($html, 'UTF-8', 'UTF-8');
    }

    protected function inArrayAll(array $needles, array $haystack)
    {
        return empty(array_diff($needles, $haystack));
    }

    protected function getAction()
    {
        return 'omt_load_articles';
    }
}
