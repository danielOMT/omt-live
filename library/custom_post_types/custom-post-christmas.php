<?php
function omt_christmas() {
    register_post_type('christmas', array(
        'labels' => array(
            'name' => __('Weihnachtsschnitzeljagd', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Weihnachtsschnitzeljagd', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle Artikel', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neuer Artikel', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neue Weihnachtsschnitzeljagd hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Weihnachtsschnitzeljagd editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neue Weihnachtsschnitzeljagd', 'bonestheme'), /* New Display Title */
            'view_item' => __('Weihnachtsschnitzeljagd anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Weihnachtsschnitzeljagd suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Weihnachtsschnitzeljagd gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Weihnachtsschnitzeljagd im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Weihnachtsschnitzeljagd', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'weihnachtsschnitzeljagd', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => 'false', /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
//        'show_in_menu' => 'omt-seminare',
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'sticky')
    ));
    
    //flush_rewrite_rules();
}
add_action( 'init', 'omt_christmas');