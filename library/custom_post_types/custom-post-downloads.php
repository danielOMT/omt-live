<?php
function menu_downloads() {
    add_menu_page(
        'Downloads',
        'Downloads',
        'read',
        'menu-downloads',
        '', // Callback, leave empty
        'dashicons-calendar',
        4 // Position
    );
}

add_action( 'admin_menu', 'menu_downloads' );

add_submenu_page( 'menu-downloads', 'Leadmagneten', 'Leadmagneten',
    'read', 'edit.php?post_type=omt_downloads');


function omt_downloads() {
    register_post_type('omt_downloads', array(
        'labels' => array(
            'name' => __('Leadmagneten', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Leadmagnet', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle Leadmagneten', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neuer Leadmagnet', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neuen Leadmagnet hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Leadmagnet editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neuer Leadmagnet', 'bonestheme'), /* New Display Title */
            'view_item' => __('Leadmagnet anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Leadmagnet suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Leadmagneten gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Leadmagneten im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Leadmagneten, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 1, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'downloads/leadmagneten', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'show_in_menu' => ' ',
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));

    register_taxonomy('download-category', ['omt_downloads'], [
        'hierarchical' => true, /* if this is true, it acts like categories */
        'labels' => [
            'name' => __('Leadmagneten-Kategorien', 'bonestheme'), /* name of the custom taxonomy */
            'singular_name' => __('Leadmagneten-Kategorie', 'bonestheme'), /* single taxonomy name */
            'search_items' => __('Leadmagneten-Kategorien durchsuchen', 'bonestheme'), /* search title for taxomony */
            'all_items' => __('Alle Leadmagneten-Kategorien', 'bonestheme'), /* all title for taxonomies */
            'parent_item' => __('Parent Custom Category', 'bonestheme'), /* parent title for taxonomy */
            'parent_item_colon' => __('Parent Custom Category:', 'bonestheme'), /* parent taxonomy title */
            'edit_item' => __('Leadmagneten-Kategorie editieren', 'bonestheme'), /* edit custom taxonomy title */
            'update_item' => __('Leadmagneten-Kategorie aktualisieren', 'bonestheme'), /* update title for taxonomy */
            'add_new_item' => __('Neue Leadmagneten-Kategorie hinzufügen', 'bonestheme'), /* add new title for taxonomy */
            'new_item_name' => __('Neue Leadmagneten-Kategorie hinzufügen', 'bonestheme'), /* name title for taxonomy */
            'menu_name' => __('Leadmagneten-Kategorien', 'bonestheme'),
        ],
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'kategorie'],
    ]);
}

add_action( 'init', 'omt_downloads');
//
//
///////add rewrite actions for the magazin categories:
//function change_link( $post_link, $id = 0 ) {
//    $post = get_post( $id );
//    if( $post->post_type == 'omt_downloads' )
//    {
//        if ( is_object( $post ) ) {
//            $terms = wp_get_object_terms( $post->ID, array('downloadkategorie') );
//            $post_slug = $post->post_name;
//            if ( $terms ) {
//                //return str_replace( '%cat%', $terms[0]->slug, $post_link );
//                $returnurl = "https://www.omt.de/downloads/" . $terms[0]->slug . "/" . $post_slug . "/";
//                return $returnurl;
//            }
//        }
//    }
//    return   $post_link ;
//}
//add_filter( 'post_type_link', 'change_link', 1, 3 );
//
////load the template on the new generated URL otherwise you will get 404's the page
//
//function generated_rewrite_rules() {
//    add_rewrite_rule(
//        '^downloads/magazin/([^/]*)/?',
//        'index.php?post_type=downloads&name=$matches[2]',
//        'top'
//    );
//
//    add_filter( 'query_vars', function( $query_vars ) {
//        $query_vars[] = 'downloads/magazin';
//        return $query_vars;
//    } );
//}
//add_action( 'init', 'generated_rewrite_rules' );
//
//add_action( 'template_include', function( $template ) {
//    if ( get_query_var( 'downloads/magazin' ) == false || get_query_var( 'downloads/magazin' ) == '' ) {
//        return $template;
//    }
//
//    return get_template_directory() . '/single-downloads.php';
//} );