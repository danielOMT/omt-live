<?php //tools
function tools() {
    register_post_type('tool', array(
        'labels' => array(
            'name' => __('Tools', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Tool', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Tools', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neues Tool', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neues Tool hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Tool editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neues Tool', 'bonestheme'), /* New Display Title */
            'view_item' => __('Tool anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Tool suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Tools gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Tools im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Tools, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 3, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'online-marketing-tools', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        //'show_in_menu' => 'jobs',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));
  //  register_taxonomy_for_object_type('category', 'omt_jobs');
  //  register_taxonomy_for_object_type('post_tag', 'omt_jobs');
}
add_action( 'init', 'tools');

register_taxonomy('tooltyp', array('tool'), array(
    'hierarchical' => true, /* if this is true, it acts like categories */
    'labels' => array(
        'name' => __('Toolkategorien', 'bonestheme'), /* name of the custom taxonomy */
        'singular_name' => __('Toolkategorie', 'bonestheme'), /* single taxonomy name */
        'search_items' =>  __('Toolkategorien durchsuchen', 'bonestheme'), /* search title for taxomony */
        'all_items' => __('Alle Toolkategorien', 'bonestheme'), /* all title for taxonomies */
        'parent_item' => __('Parent Custom Category', 'bonestheme'), /* parent title for taxonomy */
        'parent_item_colon' => __('Parent Custom Category:', 'bonestheme'), /* parent taxonomy title */
        'edit_item' => __('Toolkategorie editieren', 'bonestheme'), /* edit custom taxonomy title */
        'update_item' => __('Toolkategorie aktualisieren', 'bonestheme'), /* update title for taxonomy */
        'add_new_item' => __('Neue Toolkategorie hinzufügen', 'bonestheme'), /* add new title for taxonomy */
        'new_item_name' => __('Neue Toolkategorie hinzufügen', 'bonestheme') /* name title for taxonomy */
    ),
    'show_admin_column' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'tooltyp'),
));