<?php

/**
 * Allow dashicons in frontend for administrators
 * Also allow it for "toolanbieter" page, because ACF styles require it
 * Remove in other cases
 */
add_action('wp_enqueue_scripts', function () {
    global $post;

    if (current_user_can('update_core') || $post->post_name === 'toolanbieter') {
        return;
    }

    wp_deregister_style('dashicons');
});
