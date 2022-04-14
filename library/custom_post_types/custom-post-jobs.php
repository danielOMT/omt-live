<?php //registering jobs, städte, berufe, wissenswertes - all about omt jobs!
/*function jobs_admin_menu() {
    add_menu_page(
        'OMT Jobs',
        'OMT Jobs',
        'read',
        'jobs',
        '', // Callback, leave empty
        'dashicons-calendar',
        4 // Position
    );
}

add_action( 'admin_menu', 'jobs_admin_menu' );*/


function jobs() {
    register_post_type('jobs', array(
        'labels' => array(
            'name' => __('Jobs', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Job', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Jobs', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neuer Job', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neuen Job hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Job editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neuer Job', 'bonestheme'), /* New Display Title */
            'view_item' => __('Job anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Job suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Jobs gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Jobs im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => '',
        ), /* end of arrays */
        'description' => __('Jobs, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 3, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'   => array( 'slug' => 'jobs/stellenanzeige', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        //'show_in_menu' => 'jobs',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky'),
        
    ));

  //  register_taxonomy_for_object_type('category', 'omt_jobs');
  //  register_taxonomy_for_object_type('post_tag', 'omt_jobs');
}
add_action( 'init', 'jobs');
//
register_taxonomy('jobs-categories', array('jobs'), array(
   'hierarchical' => true, /* if this is true, it acts like categories */
   'labels' => array(
       'name' => __('Job kategorien', 'bonestheme'), /* name of the custom taxonomy */
       'singular_name' => __('Job', 'bonestheme'), /* single taxonomy name */
       'search_items' =>  __('Jobs durchsuchen', 'bonestheme'), /* search title for taxomony */
       'all_items' => __('Alle Jobs', 'bonestheme'), /* all title for taxonomies */
       'parent_item' => __('Parent Custom Category', 'bonestheme'), /* parent title for taxonomy */
       'parent_item_colon' => __('Parent Custom Category:', 'bonestheme'), /* parent taxonomy title */
       'edit_item' => __('Job editieren', 'bonestheme'), /* edit custom taxonomy title */
       'update_item' => __('Job aktualisieren', 'bonestheme'), /* update title for taxonomy */
       'add_new_item' => __('Neue Job hinzufügen', 'bonestheme'), /* add new title for taxonomy */
       'new_item_name' => __('Neue Job hinzufügen', 'bonestheme') /* name title for taxonomy */
   ),
   'show_admin_column' => true,
   'show_ui' => true,
   'query_var' => true,
   'rewrite' => array('slug' => 'jobs-categories'),
));

//function omt_jobs_staedte() {
//    register_post_type('omt_jobs_staedte', array(
//        'labels' => array(
//            'name' => __('Städte', 'bonestheme'), /* This is the Title of the Group */
//            'singular_name' => __('Stadt', 'bonestheme'), /* This is the individual type */
//            'all_items' => __('Städte', 'bonestheme'), /* the all items menu item */
//            'add_new' => __('Neue Stadt', 'bonestheme'), /* The add new menu item */
//            'add_new_item' => __('Neue Stadt hinzufügen', 'bonestheme'), /* Add New Display Title */
//            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
//            'edit_item' => __('Stadt editieren', 'bonestheme'), /* Edit Display Title */
//            'new_item' => __('Neue Stadt', 'bonestheme'), /* New Display Title */
//            'view_item' => __('Stadt anschauen', 'bonestheme'), /* View Display Title */
//            'search_items' => __('Stadt suchen', 'bonestheme'), /* Search Custom Type Title */
//            'not_found' =>  __('Keine Stadt gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
//            'not_found_in_trash' => __('Keine Stadt im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
//            'parent_item_colon' => ''
//        ), /* end of arrays */
//        'description' => __('Stadt, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
//        'public' => true,
//        'publicly_queryable' => true,
//        'exclude_from_search' => false,
//        'show_ui' => true,
//        'query_var' => true,
//        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
//        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
//        'rewrite' => array( 'slug' => 'jobs', 'with_front' => false ), /* you can specify its url slug */
//        'has_archive' => false, /* you can rename the slug here */
//        'capability_type' => 'post',
//        'hierarchical' => false,
//        'show_in_menu' => 'jobs',
//        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
//    ));
//
// //   register_taxonomy_for_object_type('category', 'omt_jobs_staedte');
// //   register_taxonomy_for_object_type('post_tag', 'omt_jobs_staedte');
//}
//add_action( 'init', 'omt_jobs_staedte');
//
//function omt_jobs_berufe() {
//    register_post_type('omt_jobs_berufe', array(
//        'labels' => array(
//            'name' => __('Berufe', 'bonestheme'), /* This is the Title of the Group */
//            'singular_name' => __('Beruf', 'bonestheme'), /* This is the individual type */
//            'all_items' => __('Berufe', 'bonestheme'), /* the all items menu item */
//            'add_new' => __('Neuer Beruf', 'bonestheme'), /* The add new menu item */
//            'add_new_item' => __('Neuen Beruf hinzufügen', 'bonestheme'), /* Add New Display Title */
//            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
//            'edit_item' => __('Beruf editieren', 'bonestheme'), /* Edit Display Title */
//            'new_item' => __('Neuer Beruf', 'bonestheme'), /* New Display Title */
//            'view_item' => __('Beruf anschauen', 'bonestheme'), /* View Display Title */
//            'search_items' => __('Beruf suchen', 'bonestheme'), /* Search Custom Type Title */
//            'not_found' =>  __('Keinen Beruf gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
//            'not_found_in_trash' => __('Keine Berufe im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
//            'parent_item_colon' => ''
//        ), /* end of arrays */
//        'description' => __('Berufe, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
//        'public' => true,
//        'publicly_queryable' => true,
//        'exclude_from_search' => false,
//        'show_ui' => true,
//        'query_var' => true,
//        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
//        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
//        'rewrite' => array( 'slug' => 'jobs', 'with_front' => false ), /* you can specify its url slug */
//        'has_archive' => false, /* you can rename the slug here */
//        'capability_type' => 'post',
//        'hierarchical' => false,
//        'show_in_menu' => 'jobs',
//        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
//    ));
//
// //   register_taxonomy_for_object_type('category', 'omt_jobs_berufe');
// //   register_taxonomy_for_object_type('post_tag', 'omt_jobs_berufe');
//}
//add_action( 'init', 'omt_jobs_berufe');
//
//
//function omt_jobs_wi() {
//    register_post_type('omt_jobs_wi', array(
//        'labels' => array(
//            'name' => __('Wissenswertes', 'bonestheme'), /* This is the Title of the Group */
//            'singular_name' => __('Wissenswertes', 'bonestheme'), /* This is the individual type */
//            'all_items' => __('Wissenswertes', 'bonestheme'), /* the all items menu item */
//            'add_new' => __('Neuer Eintrag', 'bonestheme'), /* The add new menu item */
//            'add_new_item' => __('Neuen Eintrag hinzufügen', 'bonestheme'), /* Add New Display Title */
//            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
//            'edit_item' => __('Eintrag editieren', 'bonestheme'), /* Edit Display Title */
//            'new_item' => __('Neuer Eintrag', 'bonestheme'), /* New Display Title */
//            'view_item' => __('Eintrag anschauen', 'bonestheme'), /* View Display Title */
//            'search_items' => __('Eintrag suchen', 'bonestheme'), /* Search Custom Type Title */
//            'not_found' =>  __('Kein Eintrag gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
//            'not_found_in_trash' => __('Kein Eintrag im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
//            'parent_item_colon' => ''
//        ), /* end of arrays */
//        'description' => __('Wissenswertes zu OMT Jobs, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
//        'public' => true,
//        'publicly_queryable' => true,
//        'exclude_from_search' => false,
//        'show_ui' => true,
//        'query_var' => true,
//        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
//        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
//        'rewrite' => array( 'slug' => 'jobs', 'with_front' => false ), /* you can specify its url slug */
//        'has_archive' => false, /* you can rename the slug here */
//        'capability_type' => 'post',
//        'hierarchical' => false,
//        'show_in_menu' => 'jobs',
//        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
//    ));
//
//  //  register_taxonomy_for_object_type('category', 'omt_jobs_wi');
//  //  register_taxonomy_for_object_type('post_tag', 'omt_jobs_wi');
//}
//add_action( 'init', 'omt_jobs_wi');