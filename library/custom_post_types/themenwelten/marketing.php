<?php
add_submenu_page( 'themenwelten', 'Marketing', 'Marketing',
    'read', 'edit.php?post_type=marketing');
function marketing() {
    register_post_type('marketing', array(
        'labels' => array(
            'name' => __('Marketing', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Artikel', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle Artikel', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neuer Artikel', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neuen Artikel hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Artikel editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neuer Artikel', 'bonestheme'), /* New Display Title */
            'view_item' => __('Artikel anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Artikel suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Artikel gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Artikel im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Alle Artikel zur Themenwelt Marketing', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'marketing', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, //'suchmaschinenoptimierung', /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        'show_in_menu' => ' ',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));

    // register_taxonomy_for_object_type('category', 'suchmaschinenoptimierung');
    //  register_taxonomy_for_object_type('post_tag', 'suchmaschinenoptimierung');
}
add_action( 'init', 'marketing');
