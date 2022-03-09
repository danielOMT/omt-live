<?php

function omt_downloads_magazin() {
    register_post_type('dl_magazin', array(
        'labels' => array(
            'name' => __('Magazin Downloads', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Download', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle Downloads', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neuer Download', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neuen Download hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Download editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neuer Download', 'bonestheme'), /* New Display Title */
            'view_item' => __('Download anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Download suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Downloads gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Downloads im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Downloads, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 4, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'downloads/magazin', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));
}
add_action( 'init', 'omt_downloads_magazin');


/////add rewrite actions for the magazin categories: