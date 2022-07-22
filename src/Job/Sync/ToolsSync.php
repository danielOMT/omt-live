<?php

namespace OMT\Job\Sync;

use OMT\Job\Job;
use OMT\Model\Datahost\MarketingTool;
use OMT\Model\Tool;
use OMT\Services\Roles;
use WP_Post;

class ToolsSync extends Job
{
    public function __construct()
    {
        // Sync tool when the corresponding post has been saved
        // Initialize hook later (priority = 15) to have all the actual data from other plugins like ACF
        add_action('save_post', [$this, 'save'], 15, 3);

        add_action('acf/save_post' , [$this, 'save_acfn'], 10, 1 );

        // Sync deletion (destroy) when the corresponding post has been deleted
        add_action('deleted_post', [$this, 'destroy'], 15, 2);

        // Sync all tools manually running /wp-admin/admin-ajax.php?action=sync_all_tools
        add_action('wp_ajax_sync_all_tools', [$this, 'saveAll']);
    }

    function save_acf($postId, WP_Post $post, bool $update)
    {
//do action if acf_form is saved to update some fields so we can save category changes into the database!
        // bail early if not a contact_form post
        // bail early if editing in admin
        if( is_admin() ) {
            return;
        }

        Tool::init()->sync($post);
        // get custom fields (field group exists for content_form)
        $name = "OMT saving post!";
        $email = "info@omt.de";
        $to = 'daniel.voelskow@reachx.de';
        $headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
        $subject = "post was saved!";
        $body = "some body content" . $postId;
        // send email
        wp_mail($to, $subject, $body, $headers );
    }

    public function save($postId, WP_Post $post, bool $update)
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if ($post->post_type !== Tool::init()->getPostTypeName()) {
            return;
        }

        if (wp_is_post_revision($post)) {
            return;
        }

        if (isset($post->post_status) && $post->post_status == 'auto-draft') {
            return;
        }

        // Tool 191511 has been excluded from sync, logic is taken from JSON solution
        if ($post->ID == 191511) {
            return;
        }

        Tool::init()->sync($post);
    }

    public function destroy($postid, WP_Post $post)
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if ($post->post_type !== Tool::init()->getPostTypeName()) {
            return;
        }

        MarketingTool::init()->destroy($post->ID);
    }

    public function saveAll()
    {
        if (!Roles::isAdministrator()) {
            return false;
        }

        $model = Tool::init();

        $posts = $model->items(['status' => [
            Tool::POST_STATUS_PUBLISH,
            Tool::POST_STATUS_DRAFT,
            Tool::POST_STATUS_PRIVATE
        ]]);

        foreach ($posts as $post) {
            // Tool 191511 has been excluded from sync, logic is taken from JSON solution
            if ($post->ID == 191511) {
                continue;
            }

            $model->sync($post);
        }

        echo 'Done!';
        exit;
    }
}
