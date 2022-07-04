<?php
function omt_wissenswertes() {
    register_post_type('wissenswertes', array(
        'labels' => array(
            'name' => __('Wissenswertes', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Wissenswertes', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Wissenswertes', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neuer Eintrag', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neuen Eintrag hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Eintrag editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neuer Eintrag', 'bonestheme'), /* New Display Title */
            'view_item' => __('Eintrag anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Eintrag suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Kein Eintrag gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Kein Eintrag im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('wissenswertes/Fragen und zugehörige Antworten, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'wissenswertes', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        'show_in_menu' => 'omt-seminare',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));

    //register_taxonomy_for_object_type('category', 'wissenswertes');
    //register_taxonomy_for_object_type('post_tag', 'wissenswertes');
}
add_action( 'init', 'omt_wissenswertes');
