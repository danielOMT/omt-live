<?php

function omt_webinare() {
    register_post_type('webinare', array(
        'labels' => array(
            'name' => __('Webinare', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Webinar', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle Webinare', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neues Webinar', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neues Webinar hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Webinar editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neues Webinar', 'bonestheme'), /* New Display Title */
            'view_item' => __('Webinar anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Webinar suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Webinare gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Webinare im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Webinare, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 4, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'webinare', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));

    register_taxonomy('kategorie', array('webinare'), array(
        'hierarchical' => true, /* if this is true, it acts like categories */
        'labels' => array(
            'name' => __('Webinarkategorien', 'bonestheme'), /* name of the custom taxonomy */
            'singular_name' => __('Webinarkategorie', 'bonestheme'), /* single taxonomy name */
            'search_items' =>  __('Webinarkategorien durchsuchen', 'bonestheme'), /* search title for taxomony */
            'all_items' => __('Alle Webinarkategorien', 'bonestheme'), /* all title for taxonomies */
            'parent_item' => __('Parent Custom Category', 'bonestheme'), /* parent title for taxonomy */
            'parent_item_colon' => __('Parent Custom Category:', 'bonestheme'), /* parent taxonomy title */
            'edit_item' => __('Webinarkategorie editieren', 'bonestheme'), /* edit custom taxonomy title */
            'update_item' => __('Webinarkategorie aktualisieren', 'bonestheme'), /* update title for taxonomy */
            'add_new_item' => __('Neue Webinarkategorie hinzufügen', 'bonestheme'), /* add new title for taxonomy */
            'new_item_name' => __('Neue Webinarkategorie hinzufügen', 'bonestheme'), /* name title for taxonomy */
            'menu_name' => __('Webinarkategorien', 'bonestheme'),
        ),
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'kategorie'),
    ));
}
add_action( 'init', 'omt_webinare');