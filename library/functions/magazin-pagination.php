<?php
////(re-)enable subpages bzw. pagination on /magazin/
function rewrite_magazin_pagination() {
    add_rewrite_tag('%mpage%', '([0-9]+)');
    add_rewrite_rule('^magazin/([0-9]+)/?', 'index.php?page_id=211070&mpage=$matches[1]', 'top');
}
add_action('init', 'rewrite_magazin_pagination');

function change_yoast_title_paginated($title) {
    global $page;
    $id = $post->ID;
    global $wp;
    $mpage = $wp->query_vars['mpage'];
    //$title = YoastSEO()->meta->for_post($id)->title;
    if ($mpage >= 2) {
        $title = "OMT - " . get_the_title($post->ID) . " | Seite " . $mpage;
    }
    return $title;
}


function change_yoast_canonical_paginated($url)
{
    global $page;
    $id = $post->ID;
    global $wp;
    $mpage = $wp->query_vars['mpage'];
    //$page = $wp_query->query_vars['mpage'];
    $new_url = get_the_permalink($id);
    if ($mpage >= 2) {
        $new_url = get_the_permalink($id) . $mpage . "/";
    }
    return $new_url;
}


function change_yoast_description_paginated($description)
{
    //https://developer.yoast.com/customization/apis/surfaces-api/
    global $page;
    $id = $post->ID;
    global $wp;
    $mpage = $wp->query_vars['mpage'];
    $new_description = YoastSEO()->meta->for_post($id)->description;
    if ($mpage >= 2) {
        $new_description = "OMT - " . get_the_title($id) . ' | Seite ' . $mpage;
    }
    return $new_description;
}





function magazin_pagination_meta()
{
    //OG Daten: https://gist.github.com/igorbenic/eb97eb252a72c81b0f463b49ec5d1539
    $istmagazin = strpos($_SERVER['REQUEST_URI'], 'magazin');
    if (false != $istmagazin) {
        add_filter('wpseo_title', 'change_yoast_title_paginated');
        add_filter('wpseo_metadesc', 'change_yoast_description_paginated', 100, 1);
        add_filter('wpseo_canonical', 'change_yoast_canonical_paginated', 100, 1);
        add_filter('redirect_canonical', 'no_redirect_on_404'); //in functions.php
        add_filter( 'wpseo_opengraph_url', 'change_yoast_canonical_paginated' );
        add_filter( 'wpseo_opengraph_title', 'change_yoast_title_paginated' );
        add_filter( 'wpseo_opengraph_desc', 'change_yoast_description_paginated' );
    }
}
add_action('init', 'magazin_pagination_meta');

