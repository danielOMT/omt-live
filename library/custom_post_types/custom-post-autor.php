<?php

add_action( 'admin_menu', 'autor_admin_menu' );


function omt_autor() {
    register_post_type('autor', array(
        'labels' => array(
            'name' => __('Autor', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Autor', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle Autoren', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neuer Autor', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neuen Autor hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Autor editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neuer Autor', 'bonestheme'), /* New Display Title */
            'view_item' => __('Autorenprofil anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Autor suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Autoren gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Autorprofile im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Profil aller Autoren', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'autor', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false,// 'autor', /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        'show_in_menu' => 'profiles',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));

   // register_taxonomy_for_object_type('category', 'autor');
  //  register_taxonomy_for_object_type('post_tag', 'autor');
}
add_action( 'init', 'omt_autor');
