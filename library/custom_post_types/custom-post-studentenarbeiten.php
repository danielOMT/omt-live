<?php

add_submenu_page( 'menu-downloads', 'Studentenarbeiten', 'Studentenarbeiten',
    'read', 'edit.php?post_type=omt_student');

function omt_student() {
    register_post_type('omt_student', array(
        'labels' => array(
            'name' => __('Studentenarbeiten', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Studentenarbeit', 'bonestheme'), /* This is the individual type */
            'all_items' => __('Alle Studentenarbeiten', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Neue Studentenarbeit', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Neue Studentenarbeit hinzufügen', 'bonestheme'), /* Add New Display Title */
            'edit' => __( 'Editieren', 'bonestheme' ), /* Edit Dialog */
            'edit_item' => __('Studentenarbeit editieren', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('Neue Studentenarbeit', 'bonestheme'), /* New Display Title */
            'view_item' => __('Studentenarbeit anschauen', 'bonestheme'), /* View Display Title */
            'search_items' => __('Studentenarbeit suchen', 'bonestheme'), /* Search Custom Type Title */
            'not_found' =>  __('Keine Studentenarbeiten gefunden.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Keine Studentenarbeiten im Papierkorb', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
        'description' => __('Studentenarbeiten, welche in den entsprechenden Abschnitten ausgegeben werden', 'bonestheme'), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 2, /* this is what order you want it to appear in on the left hand side menu */
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'downloads/studentenarbeiten', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => false, /* you can rename the slug here */
        'show_in_menu' => ' ',
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ));

    register_taxonomy('student-category', ['omt_student'], [
        'hierarchical' => true, /* if this is true, it acts like categories */
        'labels' => [
            'name' => __('Studentenarbeiten-Kategorien', 'bonestheme'), /* name of the custom taxonomy */
            'singular_name' => __('Studentenarbeiten-Kategorie', 'bonestheme'), /* single taxonomy name */
            'search_items' => __('Studentenarbeiten-Kategorien durchsuchen', 'bonestheme'), /* search title for taxomony */
            'all_items' => __('Alle Studentenarbeiten-Kategorien', 'bonestheme'), /* all title for taxonomies */
            'parent_item' => __('Parent Custom Category', 'bonestheme'), /* parent title for taxonomy */
            'parent_item_colon' => __('Parent Custom Category:', 'bonestheme'), /* parent taxonomy title */
            'edit_item' => __('Studentenarbeiten-Kategorie editieren', 'bonestheme'), /* edit custom taxonomy title */
            'update_item' => __('Studentenarbeiten-Kategorie aktualisieren', 'bonestheme'), /* update title for taxonomy */
            'add_new_item' => __('Neue Studentenarbeiten-Kategorie hinzufügen', 'bonestheme'), /* add new title for taxonomy */
            'new_item_name' => __('Neue Studentenarbeiten-Kategorie hinzufügen', 'bonestheme'), /* name title for taxonomy */
            'menu_name' => __('Studentenarbeiten-Kategorien', 'bonestheme'),
        ],
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'kategorie'],
    ]);
}

add_action( 'init', 'omt_student');
