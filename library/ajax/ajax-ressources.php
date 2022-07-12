<?php
require_once('ajax-login.php');
require_once ('ajax-trends.php');
require_once ('ajax-tool-alternatives.php');
require_once ('ajax-magazin-checkout.php');
require_once ('ajax-ebooksfilter.php');
require_once ('ajax-webinarefilter.php');
require_once ('ajax-podcasts.php');
require_once ('ajax-umfrage.php');
require_once ('ajax-job-filter.php');
require_once ('ajax-rec-video.php');
require_once ('ajax-toolkategorien.php');
require_once('ajax-toolanbieter/ajax-toolanbieter.php');
require_once('ajax-toolanbieter/ajax-subnav.php');
require_once('ajax-toolanbieter/ajax-submit-bid.php');
require_once('ajax-toolanbieter/ajax-change-budget.php');
///Botschafter Ajax
require_once('ajax-botschafter/ajax-botschafter.php');
/////NOTIZ: DIE Subnav(?)RESSOURCEN MÜSSEN DYNAMISCH GECALLED WERDEN DA ES SONST EINEN FEHLER IN ANDEREN TEMPLATES GIBT! ABFRAGE GEHT SCHEINBAR ABER NOCH NICHT RICHTIG

function assets() {
    wp_enqueue_script('ajax-trends', get_stylesheet_directory_uri() . '/library/ajax/ajax-trends.js', ['jquery'], null, true);
    wp_localize_script('ajax-trends', 'jamz', array(
        'nonce' => wp_create_nonce('jamz'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assets', 100);

if (USE_JSON_POSTS_SYNC) {
    require_once ('ajax-webinare.php');
    require_once ('ajax-artikel.php');
    require_once ('ajax-magazinfilter.php');
    
    function assets_webinarajax() {
        wp_enqueue_script('ajax-webinare', get_stylesheet_directory_uri() . '/library/ajax/ajax-webinare.js', ['jquery'], null, true);
        wp_localize_script('ajax-webinare', 'webjamz', array(
            'nonce' => wp_create_nonce('webjamz'),
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
    add_action('wp_enqueue_scripts', 'assets_webinarajax', 100);


    function assets_magfilterajax() {
        wp_enqueue_script('ajax-magfilter', get_stylesheet_directory_uri() . '/library/ajax/ajax-magazinfilter.js', ['jquery'], null, true);
        wp_localize_script('ajax-magfilter', 'magfijamz', array(
            'nonce' => wp_create_nonce('magfijamz'),
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
    add_action('wp_enqueue_scripts', 'assets_magfilterajax', 100);

    function assets_artikelajax() {
        wp_enqueue_script('ajax-artikel', get_stylesheet_directory_uri() . '/library/ajax/ajax-artikel.js', ['jquery'], null, true);
        wp_localize_script('ajax-artikel', 'artikeljamz', array(
            'nonce' => wp_create_nonce('artikeljamz'),
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
    add_action('wp_enqueue_scripts', 'assets_artikelajax', 100);
}

require_once ('ajax-toolindex.php');
function assets_toolindexajax() {
    wp_enqueue_script('ajax-toolindex', get_stylesheet_directory_uri() . '/library/ajax/ajax-toolindex.js', ['jquery'], null, true);
    wp_localize_script('ajax-toolindex', 'toolindexjamz', array(
        'nonce' => wp_create_nonce('toolindexjamz'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assets_toolindexajax', 100);


function assetsToolAlternativesAjax() {
    wp_enqueue_script('ajax-tool-alternatives', get_stylesheet_directory_uri() . '/library/ajax/ajax-tool-alternatives.js', ['jquery'], null, true);
    wp_localize_script('ajax-tool-alternatives', 'toolalternjamz', array(
        'nonce' => wp_create_nonce('toolalternjamz'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assetsToolAlternativesAjax', 100);

function assets_podcastajax() {
    wp_enqueue_script('ajax-podcasts', get_stylesheet_directory_uri() . '/library/ajax/ajax-podcasts.js', ['jquery'], null, true);
    wp_localize_script('ajax-podcasts', 'podjamz', array(
        'nonce' => wp_create_nonce('podjamz'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assets_podcastajax', 100);

function assets_toolanbieterajax() {
    wp_enqueue_script('ajax-toolanbieter', get_stylesheet_directory_uri() . '/library/ajax/ajax-toolanbieter/ajax-toolanbieter.js', ['jquery'], null, true);
    wp_localize_script('ajax-toolanbieter', 'tajamz', array(
        'nonce' => wp_create_nonce('tajamz'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assets_toolanbieterajax', 100);

function assets_biddings() {
    wp_enqueue_script('ajax-biddings', get_stylesheet_directory_uri() . '/library/ajax/ajax-toolanbieter/ajax-change-bid.js', ['jquery'], null, true);
    wp_localize_script('ajax-biddings', 'bidjamz', array(
        'nonce' => wp_create_nonce('bidjamz'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assets_biddings', 100);

function assets_umfrageajax() {
    wp_enqueue_script('ajax-umfrage', get_stylesheet_directory_uri() . '/library/ajax/ajax-umfrage.js', ['jquery'], null, true);
    wp_localize_script('ajax-umfrage', 'umfragejamz', array(
        'nonce' => wp_create_nonce('umfragejamz'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assets_umfrageajax', 100);

function assets_botschafterrajax() {
    wp_enqueue_script('ajax-botschafter', get_stylesheet_directory_uri() . '/library/ajax/ajax-botschafter/ajax-botschafter.js', ['jquery'], null, true);
    wp_localize_script('ajax-botschafter', 'botschjamz', array(
        'nonce' => wp_create_nonce('botschjamz'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assets_botschafterrajax', 100);

function assetsEbooksFilterAjax() {
    wp_enqueue_script('ajax-ebooksfilter', get_stylesheet_directory_uri() . '/library/ajax/ajax-ebooksfilter.js', ['jquery'], null, true);
    wp_localize_script('ajax-ebooksfilter', 'ebfiljamz', array(
        'nonce' => wp_create_nonce('ebfiljamz'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assetsEbooksFilterAjax', 100);

function assetsWebinareFilterAjax() {
    wp_enqueue_script('ajax-webinarefilter', get_stylesheet_directory_uri() . '/library/ajax/ajax-webinarefilter.js', ['jquery'], null, true);
    wp_localize_script('ajax-webinarefilter', 'wbfiljamz', array(
        'nonce' => wp_create_nonce('wbfiljamz'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assetsWebinareFilterAjax', 100);


function assetsMagazinCheckoutAjax() {
    wp_enqueue_script('ajax-magazin-checkout', get_stylesheet_directory_uri() . '/library/ajax/ajax-magazin-checkout.js', ['jquery'], null, true);
    wp_localize_script('ajax-magazin-checkout', 'magchekjamz', array(
        'nonce' => wp_create_nonce('magchekjamz'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assetsMagazinCheckoutAjax', 100);

function assets_toolkategorienajax() {
    wp_enqueue_script('ajax-toolkafilter', get_stylesheet_directory_uri() . '/library/ajax/ajax-toolkategorien.js', ['jquery'], null, true);
    wp_localize_script('ajax-toolkafilter', 'toolkajamz', array(
        'nonce' => wp_create_nonce('toolkajamz'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assets_toolkategorienajax', 100);

function assets_jobFilterajax() {
    wp_enqueue_script('ajax-job-filter', get_stylesheet_directory_uri() . '/library/ajax/ajax-job-filter.js', ['jquery'], null, true);
    wp_localize_script('ajax-job-filter', 'jobfilter', array(
        'nonce' => wp_create_nonce('jobfilter'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assets_jobFilterajax', 100);

function assets_recVideoajax() {
    wp_enqueue_script('ajax-rec-video', get_stylesheet_directory_uri() . '/library/ajax/ajax-rec-video.js', ['jquery'], null, true);
    wp_localize_script('ajax-rec-video', 'recvideo', array(
        'nonce' => wp_create_nonce('recvideo'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'assets_recVideoajax', 100);
