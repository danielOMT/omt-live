<?php //agenturen (vip)
function agentur() {
    register_post_type('agentur', array(
        'labels' => array(
            'name' => __('Agenturen', 'bonestheme'), /* This is the Title of the Group */
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
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Agenturen, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 3, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'agentur', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        //'show_in_menu' => 'jobs',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));
  //  register_taxonomy_for_object_type('category', 'omt_jobs');
  //  register_taxonomy_for_object_type('post_tag', 'omt_jobs');
}
add_action( 'init', 'agentur');
