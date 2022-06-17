<?php

add_submenu_page(
    'menu-downloads',
    'LinkedIn Templates',
    'LinkedIn Templates',
    'read',
    'edit.php?post_type=tmpl_linkedin'
);

function tmpl_linkedin()
{
    register_post_type('tmpl_linkedin', [
        'labels' => [
            'name' => __('LinkedIn Templates', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('LinkedIn Template', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle LinkedIn Templates', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neues LinkedIn Template', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neues LinkedIn Template hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __('Editieren', 'bonestheme'), /* Edit Dialog */
            'edit_item' => __('LinkedIn Template editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neues LinkedIn Template', 'bonestheme'), /* New Display Title */
            'view_item' => __('LinkedIn Template anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('LinkedIn Template suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' => __('Keine LinkedIn Templates gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine LinkedIn Templates im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ], /* end of arrays */
        'description' => __('LinkedIn Templates, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 2, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite' => ['slug' => 'downloads/templates/linkedin', 'with_front' => false], /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'show_in_menu' => ' ',
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky']
    ]);
}

add_action('init', 'tmpl_linkedin');
