<?php
//add_action( 'init', 'my_website_add_rewrite_tag' );
//function my_website_add_rewrite_tag() {
//// defines the rewrite structure for 'agenturen'
//// says that if the URL matches this rule, then it should display the 'agenturen' post whose post name matches the last slug set
//    // add_rewrite_rule( '^agentur-finden/([^/]*)/([^/]*)/?','index.php?agenturen=$matches[2]','top' );
//    // add_rewrite_rule( '^agentur-finden/([^/]*)/([^/]*)/?','index.php?af_seoagentur=$matches[2]','top' );
//    add_rewrite_rule( '^agentur-finden/seo-agentur/test','index.php?af_seoagentur=$matches[2]','top' );
//    //   add_rewrite_rule( '^agentur-finden/seo-agentur/([^/]*)/([^/]*)/?','index.php?agentur-finden=seo-agentur&chapters=$matches[1]','top' );
//    $args = array( //next seminare 1st
//        'posts_per_page' => -1,
//        'posts_status' => "publish",
//        'post_type' => "af_seoagentur",
//        'order' => 'DESC',
//        'orderby' => 'date',
//    );
//  /*  $loop = new WP_Query($args);
//    if (have_posts()) : while ($loop->have_posts()) : $loop->the_post();
//        global $post;
//        $post_slug = $post->post_name;
//        //print $post_slug . "<br/>";
//        add_rewrite_rule( '^agentur-finden/seo-agentur/' . $post_slug,'index.php?af_seoagentur=$matches[2]','top' );
//        //add_rewrite_rule( '^agentur-finden/' . $post_slug . '/([^/]*)/?','index.php?agentur-finden=' . $post_slug . '&books=$matches[1]','top' );
//    endwhile; endif;
//    wp_reset_postdata();*/
//}
//
//function prefix_register_query_var( $vars ) {
//    $vars[] = 'af_seoagentur';
//    $vars[] = 'seo-agentur';
//    return $vars;
//}
//
//function prefix_url_rewrite_templates() {
//
//    if ( get_query_var( 'af_seoagentur' ) && is_singular( 'agenturfinder' ) ) {
//        add_filter( 'template_include', function() {
//            return get_template_directory() . '/single-seo-agentur.php';
//        });
//    }
//
//    if ( get_query_var( 'seo-agentur' ) && is_singular( 'agenturfinder' ) ) {
//        add_filter( 'template_include', function() {
//            return get_template_directory() . '/single-seo-agentur.php';
//        });
//    }
//}
//
//add_action( 'template_redirect', 'prefix_url_rewrite_templates' );
//
//
//add_filter( 'query_vars', 'prefix_register_query_var' );
//
//// this filter runs whenever WordPress requests a post permalink, i.e. get_permalink(), etc.
//// we will return our custom permalink for 'agenturen'. 'agentur-finden' is already good to go since we defined its rewrite slug in the CPT definition.
//add_filter( 'post_type_link', 'my_website_filter_post_type_link', 1, 4 );
//function my_website_filter_post_type_link( $post_link, $post, $leavename, $sample ) {
//    switch( $post->post_type ) {
//        case 'agenturen':
//// I spoke with Dalton and he is using the CPT-onomies plugin to relate his custom post types so for this example, we are retrieving CPT-onomy information. this code can obviously be tweaked with whatever it takes to retrieve the desired information.
//// we need to find the agentur-finden post the agenturen post belongs to. using array_shift() makes sure only one author is allowed
//            if ( $agentur_finden = array_shift( wp_get_object_terms( $post->ID, 'agenturen' ) ) ) {
//                if ( isset( $agentur_finden->slug ) ) {
//// create the new permalink
//                    $post_link = home_url( user_trailingslashit( 'agentur-finden/' . $agentur_finden->slug . '/' . $agentur_finden->post_name ) );
//                }
//            }
//            break;
//        case 'af_seoagentur':
//// I spoke with Dalton and he is using the CPT-onomies plugin to relate his custom post types so for this example, we are retrieving CPT-onomy information. this code can obviously be tweaked with whatever it takes to retrieve the desired information.
//// we need to find the agentur-finden post the agenturen post belongs to. using array_shift() makes sure only one author is allowed
//            if ( $agentur_finden = array_shift( wp_get_object_terms( $post->ID, 'af_seoagentur' ) ) ) {
//                if ( isset( $agentur_finden->slug ) ) {
//// create the new permalink
//                    $post_link = home_url( user_trailingslashit( 'agentur-finden/' . $agentur_finden->slug . '/' . $agentur_finden->post_name ) );
//                }
//            }
//            break;
//    }
//    return $post_link;
//}

