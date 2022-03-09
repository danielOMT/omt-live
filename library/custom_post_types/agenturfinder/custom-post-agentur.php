<?php
add_submenu_page( 'agenturfinder', 'Agenturen', 'Agenturen',
    'read', 'edit.php?post_type=agenturen');
function agenturen() {
    register_post_type('agenturen', array(
        'labels' => array(
            'name' => __('Agenturen (Agenturfinder)', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Agentur', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Agenturen', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neue Agentur', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neue Agentur hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Agentur editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neue Agentur', 'bonestheme'), /* New Display Title */
            'view_item' => __('Agentur anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Agentur suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Agenturen gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Agenturen im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => 'agentur-finden'
        ), /* end of arrays */
        'description' => __('Alle Agenturen im Agenturfinder', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 1, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'agentur-finden/agentur', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, //'suchmaschinenoptimierung', /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => true,
        'show_in_menu' => ' ',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky', 'page-attributes')
    ));

    // register_taxonomy_for_object_type('category', 'suchmaschinenoptimierung');
    //  register_taxonomy_for_object_type('post_tag', 'suchmaschinenoptimierung');
}
add_action( 'init', 'agenturen');