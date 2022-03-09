<?php //tools
function tooltabellen() {
    register_post_type('tooltabelle', array(
        'labels' => array(
            'name' => __('Tooltabellen', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Tooltabelle', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Tooltabellen', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neue Tooltabelle', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neue Tooltabelle hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Tooltabelle editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neue Tooltabelle', 'bonestheme'), /* New Display Title */
            'view_item' => __('Tooltabelle anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Tooltabelle suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Tooltabellen gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Tooltabellen im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Tooltabellen, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 3, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'vergleichstabellen', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => true,
        //'show_in_menu' => 'jobs',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));
  //  register_taxonomy_for_object_type('category', 'omt_jobs');
  //  register_taxonomy_for_object_type('post_tag', 'omt_jobs');
}
add_action( 'init', 'tooltabellen');

