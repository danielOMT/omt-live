<?php

namespace OMT\Ajax;

use OMT\Enum\Magazines;
use OMT\Model\Datahost\Article;
use OMT\Services\Response;
use OMT\View\ArticleView;

class FilterArticles extends Ajax
{
    public function handle()
    {
        if (!in_array($_GET['post_type'], Magazines::keys())) {
            Response::jsonError('Bitte wählen Sie den richtigen Magazintyp aus');
        }

        $options = [
            'order' => 'post_date',
            'order_dir' => 'DESC',
            'with' => ['experts']
        ];

        Response::json([
            'content' => $this->fixEncoding(ArticleView::loadTemplate('ajax-items', [
                'articles' => Article::init()->activeItems(['postType' => $_GET['post_type']], $options)
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

    protected function getAction()
    {
        return 'omt_filter_articles';
    }
}
