<?php

function profile_admin_menu() {
    add_menu_page(
        'OMT Profile',
        'OMT Profile',
        'read',
        'profiles',
        '', // Callback, leave empty
        'dashicons-calendar',
        4 // Position
    );
}

add_action( 'admin_menu', 'profile_admin_menu' );


function omt_speaker() {
    register_post_type('speaker', array(
        'labels' => array(
            'name' => __('Experten', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Experte', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle Experten', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neuer Experte', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neuen Experten hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Experte editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neuer Experte', 'bonestheme'), /* New Display Title */
            'view_item' => __('Expertenprofil anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Experte suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Experten gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Expertenprofile im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Profil aller Experten - diese können eingesetzt werden für Webinare, Seminare und OMT Event', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'experte', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, //'speaker', /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        'show_in_menu' => 'profiles',
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));

   // register_taxonomy_for_object_type('category', 'speaker');
  //  register_taxonomy_for_object_type('post_tag', 'speaker');
}
add_action( 'init', 'omt_speaker');
