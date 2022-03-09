<?php
/**
 ****************************
Begin Fake Pages
 ****************************
 **/

use OMT\Model\Tool;

/** Functions.php Addition/Plugin Content  */

// Fake pages' permalinks and titles
$my_fake_pages = array(
    'alternativen' => 'Alternativen'
);

add_filter('rewrite_rules_array', 'fsp_insertrules');
add_filter('query_vars', 'fsp_insertqv');

// Adding fake pages' rewrite rules
function fsp_insertrules($rules)
{
    global $my_fake_pages;
    $newrules = array();
    foreach ($my_fake_pages as $slug => $title)
        $newrules['online-marketing-tools/([^/]+)/' . $slug . '/?$'] = 'index.php?tool=$matches[1]&fpage=' . $slug;

    return $newrules + $rules;
}

// Tell WordPress to accept our custom query variable
function fsp_insertqv($vars)
{
    array_push($vars, 'fpage');
    return $vars;
}

// Remove WordPress's default canonical handling function

//remove_filter('wp_head', 'rel_canonical');
//add_filter('wp_head', 'fsp_rel_canonical');
function fsp_rel_canonical()
{
    global $current_fp, $wp_the_query;

    if (!is_singular())
        return;

    if (!$id = $wp_the_query->get_queried_object_id())
        return;

    $link = trailingslashit(get_permalink($id));

    // Make sure fake pages' permalinks are canonical
    if (!empty($current_fp))
        $link .= user_trailingslashit($current_fp);

    echo '<link rel="canonical" href="'.$link.'" />';
}

//
///* Yoast Canonical Removal from Book pages */
//add_filter( 'wpseo_canonical', 'wpseo_canonical_exclude' );
//

function change_yoast_title_alternated($title)
{
    $tools = Tool::init()->alternatives(get_the_ID());

    return count($tools) . ' ' . get_the_title() . '-Alternativen im Vergleich | OMT';
}

function change_yoast_description_alternated($description)
{
    $tools = Tool::init()->alternatives(get_the_ID());

    return 'Detaillierte Informationen über ' . count($tools). ' ' . get_the_title() . '-Alternativen ✓ Rezensionen ✓ Preise ✓ Vor- und Nachteile ✓ USPs ✓ Erklärvideos ✓ Screenshot ✓';
}

function change_opengraph_image_url($url)
{
    $image = get_field('alternativseite_facebook_bild');

    return $image['url'];
}

function change_yoast_canonical_alternated($url)
{
    return get_the_permalink() . 'alternativen/';
}

function alternativseite_check(){
    $istools = strpos($_SERVER['REQUEST_URI'], '/online-marketing-tools/');
    $isalternative = strpos($_SERVER['REQUEST_URI'], '/alternativen/');
    if ( $isalternative!==false AND $istools!==false) {
        $requesturihttp = site_url() . $_SERVER['REQUEST_URI'];
        $id = url_to_postid($_SERVER['REQUEST_URI']);
        $new_url=get_the_permalink($id) . 'alternativen/';
        if ($requesturihttp != $new_url) {
            wp_safe_redirect($new_url);
        }
        $mypost_id = url_to_postid( $_SERVER['REQUEST_URI'] );
        $alternativseite_anzeigen = get_field('alternativseite_anzeigen', $mypost_id);
        if (1 == $alternativseite_anzeigen) {
            add_filter('wpseo_title', 'change_yoast_title_alternated');
            add_filter('wpseo_metadesc', 'change_yoast_description_alternated', 100, 1);
            add_filter('wpseo_canonical', 'change_yoast_canonical_alternated', 100, 1);
            add_filter('redirect_canonical', 'no_redirect_on_404'); //in functions.php
            add_filter( 'wpseo_opengraph_url', 'change_yoast_canonical_alternated' );
            add_filter( 'wpseo_opengraph_title', 'change_yoast_title_alternated' );
            add_filter( 'wpseo_opengraph_desc', 'change_yoast_description_alternated' );
            add_filter( 'wpseo_opengraph_image', 'change_opengraph_image_url' );
            add_filter( 'wpseo_twitter_title', 'change_yoast_title_alternated' );
            add_filter( 'wpseo_twitter_description', 'change_yoast_description_alternated' );
            add_filter( 'wpseo_twitter_image', 'change_opengraph_image_url' );
        } else {
            $redirect=substr($_SERVER['REQUEST_URI'], 0, -13);
            wp_redirect( $redirect, 301 ); exit;
        }
    }
}
add_action('init', 'alternativseite_check');



