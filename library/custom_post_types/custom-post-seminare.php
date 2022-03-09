<?php

function seminare_admin_menu() {
    add_menu_page(
        'OMT Seminare',
        'OMT Seminare',
        'read',
        'omt-seminare',
        '', // Callback, leave empty
        'dashicons-calendar',
        2 // Position
    );
}
add_action( 'admin_menu', 'seminare_admin_menu' );


function omt_seminare() {
    register_post_type('seminare', array(
        'labels' => array(
            'name' => __('Seminare', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Seminar', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Seminare', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neues Seminar', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neues Seminar hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Seminar editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neues Seminar', 'bonestheme'), /* New Display Title */
            'view_item' => __('Seminar anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Seminar suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Seminare gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Seminare im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Seminare, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'seminare', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        'show_in_menu' => 'omt-seminare',
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));

    //register_taxonomy_for_object_type('category', 'seminare');
   // register_taxonomy_for_object_type('post_tag', 'seminare');
}
add_action( 'init', 'omt_seminare');

register_taxonomy('seminartyp', array('seminare'), array(
    'hierarchical' => true, /* if this is true, it acts like categories */
    'labels' => array(
        'name' => __('Seminarkategorien', 'bonestheme'), /* name of the custom taxonomy */
        'singular_name' => __('Seminarkategorie', 'bonestheme'), /* single taxonomy name */
        'search_items' =>  __('Seminarkategorien durchsuchen', 'bonestheme'), /* search title for taxomony */
        'all_items' => __('Alle Seminarkategorien', 'bonestheme'), /* all title for taxonomies */
        'parent_item' => __('Parent Custom Category', 'bonestheme'), /* parent title for taxonomy */
        'parent_item_colon' => __('Parent Custom Category:', 'bonestheme'), /* parent taxonomy title */
        'edit_item' => __('Seminarkategorie editieren', 'bonestheme'), /* edit custom taxonomy title */
        'update_item' => __('Seminarkategorie aktualisieren', 'bonestheme'), /* update title for taxonomy */
        'add_new_item' => __('Neue Seminarkategorie hinzufügen', 'bonestheme'), /* add new title for taxonomy */
        'new_item_name' => __('Neue Seminarkategorie hinzufügen', 'bonestheme') /* name title for taxonomy */
    ),
    'show_admin_column' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'seminartyp'),
));