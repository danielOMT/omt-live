<?php

add_submenu_page(
    'menu-downloads',
    'Instagram Templates',
    'Instagram Templates',
    'read',
    'edit.php?post_type=tmpl_instagram'
);

function tmpl_instagram()
{
    register_post_type('tmpl_instagram', [
        'labels' => [
            'name' => __('Instagram Templates', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Instagram Template', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle Instagram Templates', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neues Instagram Template', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neues Instagram Template hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __('Editieren', 'bonestheme'), /* Edit Dialog */
            'edit_item' => __('Instagram Template editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neues Instagram Template', 'bonestheme'), /* New Display Title */
            'view_item' => __('Instagram Template anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Instagram Template suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' => __('Keine Instagram Templates gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Instagram Templates im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ], /* end of arrays */
        'description' => __('Instagram Templates, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 2, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite' => ['slug' => 'downloads/templates/instagram-templates', 'with_front' => false], /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'show_in_menu' => ' ',
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky']
    ]);
}

add_action('init', 'tmpl_instagram');
