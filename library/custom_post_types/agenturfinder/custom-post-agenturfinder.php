<?php
add_submenu_page( 'agenturfinder', 'Agenturfinder Seiten', 'Agenturfinder Seiten',
    'read', 'edit.php?post_type=agenturfinder');
/*-------------------------------------------------
 Sart Artikels Post Type
------------------------------------------------- */
if(!function_exists('my_acticle_post_type_func')){
    function my_acticle_post_type_func()
    {
        $labels = array(
            'name' => __( 'Agenturfinder Artikel', 'mrwebsolution' ),
            'singular_name' => __( 'Artikel', 'mrwebsolution' ),
            'add_new' => __( 'Neuer Artikel', 'mrwebsolution' ),
            'add_new_item' => __( 'Neuer Artikel', 'mrwebsolution' ),
            'edit_item' => __( 'Artikel Editieren', 'mrwebsolution' ),
            'new_item' => __( 'Neuer Artikel', 'mrwebsolution' ),
            'view_item' => __( 'Artikel anschauen', 'mrwebsolution' ),
            'search_items' => __( 'Artikel suchen', 'mrwebsolution' ),
            'not_found' => __( 'keine Artikel gefunden', 'mrwebsolution' ),
            'not_found_in_trash' => __( 'Keine Artikel in Papierkorb', 'mrwebsolution' ),
            'parent_item_colon' => 'agentur-finden',
        );
        $args = array(
            'labels' 			 => $labels,
            'menu_icon' 		 => 'dashicons-admin-post',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'query_var'          => true,
            'hierarchical'       => true,
            'has_archive'        => false,
            'menu_position'      => null,
            'show_in_menu' => ' ',
            'capability_type' => 'page',
            'rewrite' => array( 'slug' => 'agentur-finden', 'with_front' => false ),
            'supports' => array( 'title', 'editor','thumbnail', 'comments', 'author', 'page-attributes')
        );
        register_post_type('agenturfinder', $args);
    }
}
add_action('init', 'my_acticle_post_type_func');
/*-------------------------------------------------
 End Artikels Post Type
------------------------------------------------- */
//
///*-------------------------------------------------
// Start Artikel Taxonomy
//------------------------------------------------- */
//// hook into the init action and call create_my_article_taxonomies when it fires
//add_action( 'init', 'create_my_article_taxonomies', 0 );
//if(!function_exists('create_my_article_taxonomies'))
//{
//    function create_my_article_taxonomies() {
//        $labels = array(
//            'name' 				=> __('Artikel Categories', 'mrwebsolution'),
//            'singular_name' 	=> __('Artikel', 'mrwebsolution'),
//            'search_items'  	=>  __('Search Categories', 'mrwebsolution'),
//            'all_items' 		=> __('All Categories', 'mrwebsolution'),
//            'parent_item' 		=> __('Parent', 'mrwebsolution'),
//            'parent_item_colon' => __('Parent:', 'mrwebsolution'),
//            'edit_item' 		=> __('Edit Category', 'mrwebsolution'),
//            'update_item' 		=> __('Update Category', 'mrwebsolution'),
//            'add_new_item' 		=> __('Add New Category', 'mrwebsolution'),
//            'new_item_name' 	=> __('New Category', 'mrwebsolution'),
//            'menu_name' 		=> __('Categories', 'mrwebsolution'),
//        );
//        $args = array(
//            'hierarchical'      => true,
//            'labels'            => $labels,
//            'show_ui'           => true,
//            'show_admin_column' => true,
//            'query_var'         => true,
//            'rewrite' => array( 'slug' => 'agentur-finden', 'with_front' => false ),
//        );
//        register_taxonomy( 'af_kat', 'agenturfinder', $args );
//    }
//}
///*-------------------------------------------------
// End Artikels Taxonomy
//------------------------------------------------- */
//
///*-------------------------------------------------
// Start custom permalink
//------------------------------------------------- */
//function create_custom_permalinks( $post_link, $post ){
//    if ( is_object( $post ) && $post->post_type == 'agenturfinder' ){
//        $terms = wp_get_object_terms( $post->ID, 'af_kat' );
//        if( $terms ){
//            return str_replace( '%af_kat%' , $terms[0]->slug , $post_link );
//        }
//    }
//    return $post_link;
//}
//add_filter( 'post_type_link', 'create_custom_permalinks', 1, 2 );
///*-------------------------------------------------
// End custom permalink
//------------------------------------------------- */

