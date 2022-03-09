<?php

function konferenzen_admin_menu() {
    add_menu_page(
        'Konferenzen',
        'Konferenzen',
        'read',
        'konferenzen',
        '', // Callback, leave empty
        'dashicons-calendar',
        4 // Position
    );
}
add_action( 'admin_menu', 'konferenzen_admin_menu' );


function omt_vortrage() {
    register_post_type('vortrag', array(
        'labels' => array(
            'name' => __('Vorträge', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Vortrag', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Vorträge', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neuer Vortrag', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neuer Vortrag hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Vortrag editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neuer Vortrag', 'bonestheme'), /* New Display Title */
            'view_item' => __('Vortrag anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Vortrag suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Vorträge gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Vorträge im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Vorträge, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'vortrag', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, //'alle-vortrage', /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        'show_in_menu' => 'konferenzen',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));

    register_taxonomy('vortragkategorie', array('vortrag'), array(
        'hierarchical' => true, /* if this is true, it acts like categories */
        'labels' => array(
            'name' => __('Vortragkategorien', 'bonestheme'), /* name of the custom taxonomy */
            'singular_name' => __('Vortragkategorie', 'bonestheme'), /* single taxonomy name */
            'search_items' =>  __('Vortragkategorien durchsuchen', 'bonestheme'), /* search title for taxomony */
            'all_items' => __('Alle Vortragkategorien', 'bonestheme'), /* all title for taxonomies */
            'parent_item' => __('Parent Custom Category', 'bonestheme'), /* parent title for taxonomy */
            'parent_item_colon' => __('Parent Custom Category:', 'bonestheme'), /* parent taxonomy title */
            'edit_item' => __('Vortragkategorie editieren', 'bonestheme'), /* edit custom taxonomy title */
            'update_item' => __('Vortragkategorie aktualisieren', 'bonestheme'), /* update title for taxonomy */
            'add_new_item' => __('Neue Vortragkategorie hinzufügen', 'bonestheme'), /* add new title for taxonomy */
            'new_item_name' => __('Neue Vortragkategorie hinzufügen', 'bonestheme'), /* name title for taxonomy */
            'menu_name' => __('Vortragkategorien', 'bonestheme'),
        ),
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'vortragkategorie'),
    ));

    //register_taxonomy_for_object_type('category', 'vortrage');
   // register_taxonomy_for_object_type('post_tag', 'vortrage');
}
add_action( 'init', 'omt_vortrage');