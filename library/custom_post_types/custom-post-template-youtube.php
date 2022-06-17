<?php

add_submenu_page(
    'menu-downloads',
    'Youtube Templates',
    'Youtube Templates',
    'read',
    'edit.php?post_type=tmpl_youtube'
);

function tmpl_youtube()
{
    register_post_type('tmpl_youtube', [
        'labels' => [
            'name' => __('Youtube Templates', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Youtube Template', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle Youtube Templates', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neues Youtube Template', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neues Youtube Template hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __('Editieren', 'bonestheme'), /* Edit Dialog */
            'edit_item' => __('Youtube Template editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neues Youtube Template', 'bonestheme'), /* New Display Title */
            'view_item' => __('Youtube Template anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Youtube Template suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' => __('Keine Youtube Templates gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Youtube Templates im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ], /* end of arrays */
        'description' => __('Youtube Templates, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 2, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite' => ['slug' => 'downloads/templates/youtube', 'with_front' => false], /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'show_in_menu' => ' ',
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky']
    ]);
}

add_action('init', 'tmpl_youtube');
