<?php

function omt_podcasts() {
    register_post_type('podcasts', array(
        'labels' => array(
            'name' => __('Podcasts', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Podcast', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle Podcasts', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neues Podcast', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neues Podcast hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Podcast editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neues Podcast', 'bonestheme'), /* New Display Title */
            'view_item' => __('Podcast anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Podcast suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Podcasts gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Podcasts im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Podcasts, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 4, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'podcast', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));

    register_taxonomy('podcastkategorie', array('podcasts'), array(
        'hierarchical' => true, /* if this is true, it acts like categories */
        'labels' => array(
            'name' => __('Podcastkategorien', 'bonestheme'), /* name of the custom taxonomy */
            'singular_name' => __('Podcastkategorie', 'bonestheme'), /* single taxonomy name */
            'search_items' =>  __('Podcastkategorien durchsuchen', 'bonestheme'), /* search title for taxomony */
            'all_items' => __('Alle Podcastkategorien', 'bonestheme'), /* all title for taxonomies */
            'parent_item' => __('Parent Custom Category', 'bonestheme'), /* parent title for taxonomy */
            'parent_item_colon' => __('Parent Custom Category:', 'bonestheme'), /* parent taxonomy title */
            'edit_item' => __('Podcastkategorie editieren', 'bonestheme'), /* edit custom taxonomy title */
            'update_item' => __('Podcastkategorie aktualisieren', 'bonestheme'), /* update title for taxonomy */
            'add_new_item' => __('Neue Podcastkategorie hinzufügen', 'bonestheme'), /* add new title for taxonomy */
            'new_item_name' => __('Neue Podcastkategorie hinzufügen', 'bonestheme'), /* name title for taxonomy */
            'menu_name' => __('Podcastkategorien', 'bonestheme'),
        ),
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'kategorie'),
    ));
}
add_action( 'init', 'omt_podcasts');