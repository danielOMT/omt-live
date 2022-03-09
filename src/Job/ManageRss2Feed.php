<?php

namespace OMT\Job;

use OMT\Enum\Magazines;
use OMT\Model\Datahost\Article;
use OMT\View\Rss2FeedView;
use WP_Post;

/**
 * Display "Magazin / Themenwelten" posts for RSS Feed
 * To improve performance pull additional articles data from artikel.json
 */
class ManageRss2Feed extends Job
{
    public function __construct()
    {
        $this->useCustomRss2FeedTemplate();
        $this->registerFilters();
    }

    protected function useCustomRss2FeedTemplate()
    {
        remove_all_actions('do_feed_rss2');

        add_action('do_feed_rss2', function ($for_comments) {
            if ($for_comments) {
                load_template(ABSPATH . WPINC . '/feed-rss2-comments.php');
            } else {
                echo Rss2FeedView::loadTemplate();
            }
        });
    }

    protected function registerFilters()
    {
        add_filter('request', [$this, 'postTypes']);
        add_filter('the_author', [$this, 'author']);
        add_filter('get_the_excerpt', [$this, 'excerpt'], 9, 2);
    }

    /**
     * Use "Magazin / Themenwelten" posts types for RSS Feed
     * Applies if post_type isn't specified in request
     */
    public function postTypes($query)
    {
        if (array_key_exists('feed', (array) $query) && !array_key_exists('post_type', (array) $query)) {
            $query['post_type'] = Magazines::keys();
        }

        return $query;
    }

    /**
     * Pull the author name from .json in RSS feed
     */
    public function author($name)
    {
        $post = get_post();

        if ($this->applyFilters($post)) {
            $name = '';
            $authors = $this->getArticleAuthors($post);

            foreach ($authors as $key => $author) {
                if (($key + 1) > 1 && ($key + 1) != count($authors)) {
                    $name .= ', ';
                }

                if (($key + 1) > 1 && ($key + 1) == count($authors)) {
                    $name .= ' & ';
                }

                $name .= $author;
            }

            $name = $name . ' (OMT-Magazin)';
        }

        return $name;
    }

    /**
     * Pull the excerpt from .json in RSS feed
     */
    public function excerpt($text = '', $post = null)
    {
        $post = $post ?: get_post();

        if ($this->applyFilters($post)) {
            $text = $this->getArticleExcerpt($post);
        }

        return $text;
    }

    /**
     * Get authors as array of names
     */
    protected function getArticleAuthors(WP_Post $post)
    {
        $articles = $this->getJsonArticles();

        return array_key_exists($post->ID, $articles)
            ? array_map(fn ($author) => $author->name, $articles[$post->ID]->experts)
            : [];
    }

    protected function getArticleExcerpt(WP_Post $post)
    {
        $articles = $this->getJsonArticles();

        return array_key_exists($post->ID, $articles) ? $articles[$post->ID]->preview_text : '';
    }

    protected function getJsonArticles()
    {
        static $articles = null;

        if (is_null($articles)) {
            if (USE_JSON_POSTS_SYNC) {
                $articles = [];
                $url = get_template_directory() . '/library/json/artikel.json';
                $json = json_decode(file_get_contents($url), true);

                foreach ((array) $json as $article) {
                    $authors = [];
                    for ($i = 1; $i <= 5; $i++) {
                        if (!empty($article['$speaker' . $i . '_name'])) {
                            $authors[] = (object) [
                                'name' => $article['$speaker' . $i . '_name'],
                                'url' => $article['$speaker' . $i . '_url'],
                            ];
                        }
                    }

                    $articles[$article['ID']] = (object) [
                        'preview_text' => $article['$vorschautext'],
                        'experts' => $authors
                    ];
                }
            } else {
                $articles = Article::init()->activeItems([], [
                    'order' => 'post_date',
                    'order_dir' => 'DESC',
                    'with' => ['experts']
                ], OBJECT_K);
            }
        }

        return $articles;
    }

    protected function applyFilters(WP_Post $post)
    {
        return !is_admin() && is_feed() && in_array($post->post_type, Magazines::keys());
    }
}
