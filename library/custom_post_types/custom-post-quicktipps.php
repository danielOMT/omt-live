<?php

add_action('init', function () {
    register_post_type('quicktipps', [
        'labels' => [
            'name' => __('Quicktipps', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Quicktip', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle Quicktipps', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neuer Quicktip', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neuen Quicktip hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __('Editieren', 'bonestheme'), /* Edit Dialog */
            'edit_item' => __('Quicktip editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neuer Quicktip', 'bonestheme'), /* New Display Title */
            'view_item' => __('Quicktip anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Quicktipps suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' => __('Keine Quicktip gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Quicktip im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ],
        'description' => __('Alle quicktipps', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite' => ['slug' => 'quicktipps', 'with_front' => false], /* you can specify its url slug */
        'has_archive' => false, //'suchmaschinenoptimierung', /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky']
    ]);
});
