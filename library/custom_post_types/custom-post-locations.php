<?php
function omt_locations() {
    register_post_type('locations', array(
        'labels' => array(
            'name' => __('Locations', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Location', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Locations', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neue Location', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neue Location hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Location editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neue Location', 'bonestheme'), /* New Display Title */
            'view_item' => __('Location anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Location suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Location gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Location im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Locations/Städte, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'locations', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        'show_in_menu' => 'omt-seminare',
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));

    //register_taxonomy_for_object_type('category', 'locations');
    //register_taxonomy_for_object_type('post_tag', 'locations');
}
add_action( 'init', 'omt_locations');
