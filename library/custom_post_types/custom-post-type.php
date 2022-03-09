<?php

function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}
add_action('after_switch_theme', 'bones_flush_rewrite_rules');



function custom_post_example() { 
	register_post_type('custom_type', array(
		'labels' => array(
			'name' => __('Custom Types', 'bonestheme'), /* This is the Title of the Group */
			'singular_name' => __('Custom Post', 'bonestheme'), /* This is the individual type */
			'all_items' => __('All Custom Posts', 'bonestheme'), /* the all items menu item */
			'add_new' => __('Add New', 'bonestheme'), /* The add new menu item */
			'add_new_item' => __('Add New Custom Type', 'bonestheme'), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __('Edit Post Types', 'bonestheme'), /* Edit Display Title */
			'new_item' => __('New Post Type', 'bonestheme'), /* New Display Title */
			'view_item' => __('View Post Type', 'bonestheme'), /* View Display Title */
			'search_items' => __('Search Post Type', 'bonestheme'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.', 'bonestheme'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
		), /* end of arrays */
		'description' => __('This is the example custom post type', 'bonestheme'), /* Custom Type Description */
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'query_var' => true,
		'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
		'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
		'rewrite'	=> array( 'slug' => 'custom_type', 'with_front' => false ), /* you can specify its url slug */
		'has_archive' => 'custom_type', /* you can rename the slug here */
		'capability_type' => 'post',
		'hierarchical' => false,
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	));

	register_taxonomy_for_object_type('category', 'custom_type');
	register_taxonomy_for_object_type('post_tag', 'custom_type');
}
add_action( 'init', 'custom_post_example');


register_taxonomy('custom_cat', array('custom_type'), array(
	'hierarchical' => true, /* if this is true, it acts like categories */             
	'labels' => array(
		'name' => __('Custom Categories', 'bonestheme'), /* name of the custom taxonomy */
		'singular_name' => __('Custom Category', 'bonestheme'), /* single taxonomy name */
		'search_items' =>  __('Search Custom Categories', 'bonestheme'), /* search title for taxomony */
		'all_items' => __('All Custom Categories', 'bonestheme'), /* all title for taxonomies */
		'parent_item' => __('Parent Custom Category', 'bonestheme'), /* parent title for taxonomy */
		'parent_item_colon' => __('Parent Custom Category:', 'bonestheme'), /* parent taxonomy title */
		'edit_item' => __('Edit Custom Category', 'bonestheme'), /* edit custom taxonomy title */
		'update_item' => __('Update Custom Category', 'bonestheme'), /* update title for taxonomy */
		'add_new_item' => __('Add New Custom Category', 'bonestheme'), /* add new title for taxonomy */
		'new_item_name' => __('New Custom Category Name', 'bonestheme') /* name title for taxonomy */
	),
	'show_admin_column' => true, 
	'show_ui' => true,
	'query_var' => true,
	'rewrite' => array('slug' => 'custom-slug'),
));


register_taxonomy('custom_tag', array('custom_type'), array(
	'hierarchical' => false, /* if this is false, it acts like tags */
	'labels' => array(
		'name' => __('Custom Tags', 'bonestheme'), /* name of the custom taxonomy */
		'singular_name' => __('Custom Tag', 'bonestheme'), /* single taxonomy name */
		'search_items' => __('Search Custom Tags', 'bonestheme'), /* search title for taxomony */
		'all_items' => __('All Custom Tags', 'bonestheme'), /* all title for taxonomies */
		'parent_item' => __('Parent Custom Tag', 'bonestheme'), /* parent title for taxonomy */
		'parent_item_colon' => __('Parent Custom Tag:', 'bonestheme'), /* parent taxonomy title */
		'edit_item' => __('Edit Custom Tag', 'bonestheme'), /* edit custom taxonomy title */
		'update_item' => __('Update Custom Tag', 'bonestheme'), /* update title for taxonomy */
		'add_new_item' => __('Add New Custom Tag', 'bonestheme'), /* add new title for taxonomy */
		'new_item_name' => __('New Custom Tag Name', 'bonestheme') /* name title for taxonomy */
	),
	'show_admin_column' => true,
	'show_ui' => true,
	'query_var' => true,
));