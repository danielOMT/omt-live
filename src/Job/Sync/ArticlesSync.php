<?php

namespace OMT\Job\Sync;

use OMT\Job\Job;
use OMT\Model\Article;
use OMT\Model\Datahost\Article as DatahostArticle;
use OMT\Services\Roles;
use WP_Post;

class ArticlesSync extends Job
{
    public function __construct()
    {
        // Sync article when the corresponding post has been saved
        // Initialize hook later (priority = 15) to have all the actual data from other plugins like ACF
        add_action('save_post', [$this, 'save'], 15, 3);

        // Sync deletion (destroy) when the corresponding post has been deleted
        add_action('deleted_post', [$this, 'destroy'], 15, 2);

        // Sync all articles manually running /wp-admin/admin-ajax.php?action=sync_all_articles
        add_action('wp_ajax_sync_all_articles', [$this, 'saveAll']);
    }

    public function save($postId, WP_Post $post, bool $update)
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if (!in_array($post->post_type, Article::init()->getPostTypeName())) {
            return;
        }

        if (wp_is_post_revision($post)) {
            return;
        }

        if (isset($post->post_status) && $post->post_status == 'auto-draft') {
            return;
        }

        Article::init()->sync($post);
    }

    public function destroy($postid, WP_Post $post)
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if (!in_array($post->post_type, Article::init()->getPostTypeName())) {
            return;
        }

        DatahostArticle::init()->destroy($post->ID);
    }

    public function saveAll()
    {
        if (!Roles::isAdministrator()) {
            return false;
        }

        $model = Article::init();

        $posts = $model->items(['status' => [
            Article::POST_STATUS_PUBLISH,
            Article::POST_STATUS_DRAFT,
            Article::POST_STATUS_PRIVATE
        ]]);

        foreach ($posts as $post) {
            $model->sync($post);
        }

        echo 'Done!';
        exit;
    }
}
