<?php

add_submenu_page( 'menu-downloads', 'OMT Magazin', 'OMT Magazin',
    'read', 'edit.php?post_type=omt_magazin');

function omt_magazin() {
    register_post_type('omt_magazin', array(
        'labels' => array(
            'name' => __('Magazine', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Magazin', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle Magazine', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neues Magazin', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neue Magazin hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Magazin editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neues Magazin', 'bonestheme'), /* New Display Title */
            'view_item' => __('Magazin anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Magazin suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Magazine gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Magazine im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Magazine, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 2, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'downloads/magazin', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'show_in_menu' => ' ',
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));

    register_taxonomy('magazin-category', ['omt_magazin'], [
        'hierarchical' => true, /* if this is true, it acts like categories */
        'labels' => [
            'name' => __('Magazin-Kategorien', 'bonestheme'), /* name of the custom taxonomy */
            'singular_name' => __('Magazin-Kategorie', 'bonestheme'), /* single taxonomy name */
            'search_items' => __('Magazin-Kategorien durchsuchen', 'bonestheme'), /* search title for taxomony */
            'all_items' => __('Alle Magazin-Kategorien', 'bonestheme'), /* all title for taxonomies */
            'parent_item' => __('Parent Custom Category', 'bonestheme'), /* parent title for taxonomy */
            'parent_item_colon' => __('Parent Custom Category:', 'bonestheme'), /* parent taxonomy title */
            'edit_item' => __('Magazin-Kategorie editieren', 'bonestheme'), /* edit custom taxonomy title */
            'update_item' => __('Magazin-Kategorie aktualisieren', 'bonestheme'), /* update title for taxonomy */
            'add_new_item' => __('Neue Magazin-Kategorie hinzufügen', 'bonestheme'), /* add new title for taxonomy */
            'new_item_name' => __('Neue Magazin-Kategorie hinzufügen', 'bonestheme'), /* name title for taxonomy */
            'menu_name' => __('Magazin-Kategorien', 'bonestheme'),
        ],
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'kategorie'],
    ]);
}

add_action( 'init', 'omt_magazin');
