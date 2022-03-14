<?php

use OMT\Ajax\AjaxRequests;
use OMT\Crons\Crons;
use OMT\Enum\Magazines;
use OMT\Job\Admin\ExportUserProfiles;
use OMT\Job\Admin\OpenUserProfileResume;
use OMT\Job\AdvancedCacheFileRegeneration;
use OMT\Job\HideExtraFeedLink;
use OMT\Job\ManageRss2Feed;
use OMT\Job\ManageUserProfile;
use OMT\Job\SetPostsToNoIndex;
use OMT\Job\SetLangAttributeToGerman;
use OMT\Job\StringifyBrokenCommentUrls;
use OMT\Job\WooCommerce\CustomThankYouPage;
use OMT\Job\WooCommerce\NotifyAdminsAboutNewOrder;
use OMT\Services\PostsSynchronization;
use OMT\Shortcodes\Shortcodes;

require_once 'core/initialization.php';

require_once('library/wp-less/wp-less.php'); // keep this on top

require_once('library/bones.php');
require_once('library/admin.php');
require_once('library/theme-woocommerce.php');
require_once('library/functions/add-to-cart-shortcode.php');
require_once('library/functions/dynamic-gform.php');
require_once('library/functions/clickmeter-functions.php');
// require_once('library/theme-woocommerce-customfields.php');
// require_once('library/translation/translation.php'); // this comes turned off by default

require_once('library/custom_post_types/custom-post-downloads.php'); //leadmagneten umbenannt!
require_once('library/custom_post_types/custom-post-studentenarbeiten.php');
require_once('library/custom_post_types/custom-post-ebooks.php');
require_once('library/custom_post_types/custom-post-magazin.php');
//Download mit Kategorien:

require_once('library/custom_post_types/custom-post-webinare.php');
require_once('library/custom_post_types/custom-post-speaker.php');
require_once('library/custom_post_types/custom-post-botschafter.php');
require_once('library/custom_post_types/custom-post-seminare.php');
require_once('library/custom_post_types/custom-post-locations.php');
require_once('library/custom_post_types/custom-post-wissenswertes.php');
require_once('library/custom_post_types/custom-post-jobs.php');
require_once('library/custom_post_types/custom-post-trends.php');
require_once('library/custom_post_types/custom-post-vortraege.php');
require_once('library/custom_post_types/custom-post-umfrage.php');
require_once('library/custom_post_types/custom-post-tools.php');
require_once('library/custom_post_types/custom-post-toolrezensionen.php');
require_once('library/custom_post_types/custom-post-tools-tabellen.php');
//require_once('library/custom_post_types/custom-post-branchenbuch.php'); //seit Agenturfinder obsolete
//require_once('library/custom_post_types/custom-post-agentur.php'); //seit Agenturfinder obsolete
require_once('library/custom_post_types/custom-post-expertenstimme.php');
require_once('library/custom_post_types/custom-post-podcast.php');
require_once('library/custom_post_types/custom-post-quicktipps.php');
//get themenwelten Menu + CPT for each Themenwelt
require_once('library/custom_post_types/themenwelten/themenwelten-menu.php');
//require_once('library/custom_post_types/themenwelten/custom-post-magazin.php');
require_once('library/custom_post_types/themenwelten/affiliate-marketing.php');
require_once('library/custom_post_types/themenwelten/amazon-marketing.php');
require_once('library/custom_post_types/themenwelten/amazon-seo.php');
require_once('library/custom_post_types/themenwelten/content-marketing.php');
require_once('library/custom_post_types/themenwelten/conversion-optimierung.php');
require_once('library/custom_post_types/themenwelten/direktmarketing.php');
require_once('library/custom_post_types/themenwelten/e-commerce.php');
require_once('library/custom_post_types/themenwelten/email-marketing.php');
require_once('library/custom_post_types/themenwelten/facebook-ads.php');
require_once('library/custom_post_types/themenwelten/google-adwords-sea.php');
require_once('library/custom_post_types/themenwelten/google-analytics.php');
require_once('library/custom_post_types/themenwelten/google-my-business.php');
require_once('library/custom_post_types/themenwelten/growth-hacking.php');
require_once('library/custom_post_types/themenwelten/inbound-marketing.php');
require_once('library/custom_post_types/themenwelten/influencer-marketing.php');
require_once('library/custom_post_types/themenwelten/linkbuilding.php');
require_once('library/custom_post_types/themenwelten/local-seo.php');
require_once('library/custom_post_types/themenwelten/marketing.php');
require_once('library/custom_post_types/themenwelten/online-marketing.php');
require_once('library/custom_post_types/themenwelten/performance-marketing.php');
require_once('library/custom_post_types/themenwelten/pinterest-marketing.php');
require_once('library/custom_post_types/themenwelten/pr.php');
require_once('library/custom_post_types/themenwelten/social-media-marketing.php');
require_once('library/custom_post_types/themenwelten/suchmaschinenmarketing.php');
require_once('library/custom_post_types/themenwelten/suchmaschinenoptimierung.php');
require_once('library/custom_post_types/themenwelten/tiktok-marketing.php');
require_once('library/custom_post_types/themenwelten/video-marketing.php');
require_once('library/custom_post_types/themenwelten/webanalyse.php');
require_once('library/custom_post_types/themenwelten/webdesign.php');
require_once('library/custom_post_types/themenwelten/wordpress.php');

//Agenturfinder Menu and Custom Post Types
require_once('library/custom_post_types/agenturfinder/agenturfinder-menu.php');
//require_once('library/custom_post_types/agenturfinder/agenturfinder-slugfix.php');
//require_once('library/custom_post_types/agenturfinder/custom-post-agenturfinder.php');
require_once('library/custom_post_types/agenturfinder/custom-post-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-affiliate-marketing-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-content-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-content-marketing-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-digitalagentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-google-ads-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-inboundagentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-internet-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-linkbuilding-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-online-marketing-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-sea-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-seo-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-social-media-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-web-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-webanalyse-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-webdesign-agentur.php');
require_once('library/custom_post_types/agenturfinder/custom-post-wordpress-agentur.php');

//Lexikon
require_once('library/custom_post_types/custom-post-lexikon.php');

//Weihnachtsschnitzeljagd
require_once('library/custom_post_types/custom-post-christmas.php');

//shortcodes
require_once('library/shortcodes/shortcode-3button.php');
require_once('library/shortcodes/shortcode-button.php');
require_once('library/shortcodes/shortcode-kontakt.php');
require_once('library/shortcodes/shortcode-titlebox.php');
require_once('library/shortcodes/shortcode-webinar.php');
require_once('library/shortcodes/shortcode-inhaltsverzeichnis.php');
require_once('library/shortcodes/shortcode-inhaltsverzeichnis-sidebar.php');
require_once('library/shortcodes/shortcode-ctawidget.php');
require_once('library/shortcodes/shortcode-zitat.php');
require_once('library/shortcodes/shortcode-youtube.php');
require_once('library/shortcodes/shortcode-webinarcount.php');
require_once('library/shortcodes/shortcode-podcast.php');
//require_once('library/shortcodes/shortcode-podigee.php');
require_once('library/shortcodes/shortcode-spotify.php');
require_once('library/shortcodes/shortcode-toolindex.php');
require_once('library/shortcodes/shortcode-tiktok.php');
require_once('library/shortcodes/shortcode-bewertungen.php');
require_once('library/shortcodes/shortcode-magazin.php');
require_once('library/shortcodes/shortcode-ebook.php');
require_once('library/shortcodes/shortcode-ebook-teaser.php');
require_once('library/shortcodes/shortcode-optionebooks.php');

//ajax ressources
require_once('library/ajax/ajax-ressources.php');

// Other functions
require_once('library/functions/show-readmore-acf.php');

//Adding Shortcodes to Tinymce
require_once('library/functions/add_shortcodes_to_editor.php');

//JSON Functions
/*
require_once('library/json/json_seminare.php');
require_once('library/json/json_podcasts.php');
require_once('library/json/json_magazinartikel.php');
*/

//adding some oremore security snippets
require_once('library/functions/security.php');

//improve pagespeed functions come here:
require_once ('library/functions/pagespeed-functions.php');

//adding tool "fake pages" to make "/online-marketing-tools/toolxyz/alternativen/ possible
require_once ('library/functions/tools-subpages.php');

//random pagination after pagse stopped on wordpress core 5.5.x
//enable pagination on /magazin/ page
require_once('library/functions/magazin-pagination.php');

////////////////**********************************************************************************************///////////
////////////////**********************************************************************************************///////////
////////////////**********************************************************************************************///////////
////////////////**********************************************************************************************///////////
////run tooljobs cronjob:
require_once('library/tools/cronjobs/run-cronjob-toolfunctions.php');
function add_cron_schedules($schedules){ //add intervals to cronscheduling so we can call the function in the given interval
    if(!isset($schedules["5min"])){
        $schedules["5min"] = array(
            'interval' => 5*60,
            'display' => __('Once every 5 minutes'));
    }
    if(!isset($schedules["30min"])){
        $schedules["30min"] = array(
            'interval' => 30*60,
            'display' => __('Once every 30 minutes'));
    }
    return $schedules;
}
add_filter('cron_schedules','add_cron_schedules');

//wp_schedule_event(time(), '5min', 'run_cronjob_toolfunctions', $args);

function add_tools_to_cron(){
    wp_schedule_event(time(), '5min', 'run_cronjob_toolfunctions');
}
if(!wp_next_scheduled('run_cronjob_toolfunctions')){ //if tools are not scheduled in the cronjob, add them
    add_action('init', 'add_tools_to_cron');
}
////TESTING IF IT WORKS
add_action('run_cronjob_toolfunctions', 'run_cronjob_toolfunctions');
//add_action('run_cronjob_toolfunctions', 'cron_confirmation_mail');
//
//function cron_confirmation_mail() {
//    $to = 'daniel.voelskow@reachx.de';
//    $subject = 'Tool Cron has been run successfully';
//    $message = 'If you received this message, it means that your 5-minute cron job has worked! :) ';
//    wp_mail( $to, $subject, $message );
//}
////END OF run tooljobs cronjob:
////////////////**********************************************************************************************///////////
////////////////**********************************************************************************************///////////
////////////////**********************************************************************************************///////////
////////////////**********************************************************************************************///////////
////////////////**********************************************************************************************///////////

////////////////***********************************************************************///////////
////////////////***************************** Init Crons ******************************///////////
////////////////***********************************************************************///////////
Crons::init();

////////////////***********************************************************************///////////
////////////////************************** Init Shortcodes ****************************///////////
////////////////***********************************************************************///////////
Shortcodes::init();

// Thumbnail sizes
add_image_size( '140-72', 140, 72, array( 'center', 'top' ), true );
add_image_size( '730-380', 730, 380, array( 'center', 'top' ), true );
add_image_size( '350-180', 350, 180, array( 'center', 'top' ), true );
add_image_size( '550-290', 550, 290, array( 'center', 'top' ), true );
add_image_size( 'post-image', 888, 464, array( 'center', 'top' ), false );
add_image_size( '350-90', 350, 90, array( 'center', 'top' ), false );
add_image_size( '285-285', 285, 285, array( 'center', 'top' ), true );



function bones_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        '730-380' => __('730px by 380px', true),
        '350-180' => __('350px by 180px', true),
        '550-290' => __('550px by 290px', true),
        'post-image' => __('888px by 400px')
    ));
}
add_filter('image_size_names_choose', 'bones_custom_image_sizes');


function bones_register_sidebars() {
    register_sidebar(array(
        'id' => 'standard',
        'name' => __('Sidebar Standard', 'bonestheme'),
        'description' => __('Standard Sidebar', 'bonestheme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'id' => 'jobs',
        'name' => __('Sidebar Jobs', 'bonestheme'),
        'description' => __('Jobs Sidebar.', 'bonestheme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));


    register_sidebar( array(
        'name' => 'Footer Sidebar 1 (left)',
        'id' => 'footer-bottom-left',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<p class="widget-title">',
        'after_title' => '</p>',
    ) );
    register_sidebar( array(
        'name' => 'Footer Sidebar 2 (left middle)',
        'id' => 'footer-bottom-middle',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<p class="widget-title">',
        'after_title' => '</p>',
    ) );
    register_sidebar( array(
        'name' => 'Footer Sidebar 3 (right middle)',
        'id' => 'footer-bottom-right',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<p class="widget-title">',
        'after_title' => '</p>',
    ) );
    register_sidebar( array(
        'name' => 'Footer Sidebar 4 (right)',
        'id' => 'footer-bottom-outright',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<p class="widget-title">',
        'after_title' => '</p>',
    ) );
}

function rw_title($title, $sep, $seplocation) {
    global $page, $paged;
    if (is_feed()) {
        return $title;
    }
    if ('right' == $seplocation) {
        $title .= get_bloginfo('name');
    } else {
        $title = get_bloginfo('name') . $title;
    }
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && ( is_home() || is_front_page())) {
        $title .= " {$sep} {$site_description}";
    }
    if ($paged >= 2 || $page >= 2) {
        $title .= " {$sep} " . sprintf(__('Page %s', 'dbt'), max($paged, $page));
    }
    return $title;
}
add_filter('wp_title', 'rw_title', 10, 3);


function bones_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?>>
    <article id="comment-<?php comment_ID(); ?>" class="clearfix">
        <header class="comment-author vcard">
            <?php /*this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call: echo get_avatar($comment,$size='32',$default='<path_to_url>' ); */ ?>
            <?php
            $bgauthemail = get_comment_author_email();
            ?>
            <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
            <?php printf(__('<cite class="fn">%s</cite>', 'bonestheme'), get_comment_author_link()) ?>
            <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'bonestheme')); ?> </a></time>
            <?php edit_comment_link(__('(Edit)', 'bonestheme'),'  ','') ?>
        </header>
        <?php if ($comment->comment_approved == '0') : ?>
            <div class="alert alert-info">
                <p><?php _e('Your comment is awaiting moderation.', 'bonestheme') ?></p>
            </div>
        <?php endif; ?>
        <section class="comment_content clearfix">
            <?php comment_text() ?>
        </section>
        <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
    <?php // </li> is added by WordPress automatically ?>
    <?php
}


function bones_wpsearch($form) {
    $form = '<div class="omt-suche"><h2>Inhalte auf dem OMT suchen:</h2><form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '">
    <input type="text" class="searchphrase" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Finde die Inhalte beim OMT...','bonestheme').'" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Los') .'" />
    </form></div>';
    return $form;
}


if (function_exists( "acf_add_options_page" )) {
    acf_add_options_page(array(
            'page_title' => 'Clubtreffen',
            'menu_title' => 'Clubtreffen',
            'redirect' => false
        )
    );

    $parent = acf_add_options_page(array(
            'page_title' => 'Optionen',
            'menu_title' => 'Optionen',
            'redirect' => false
        )
    );
    acf_add_options_sub_page(array(
            'page_title' => 'Content Editor',
            'menu_title' => 'content-editor',
            'parent_slug'   => $parent['menu_slug'],
        )
    );


}
function override_mce_options($initArray) {
    $opts = '*[*]';
    $initArray['valid_elements'] = $opts;
    $initArray['extended_valid_elements'] = $opts;
    return $initArray;
}
add_filter('tiny_mce_before_init', 'override_mce_options');

/****************************************************************************/
// Allow SVG
/****************************************************************************/
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

    global $wp_version;
    if ( $wp_version !== '4.7.1' ) {
        return $data;
    }

    $filetype = wp_check_filetype( $filename, $mimes );

    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];

}, 10, 4 );

function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );
/****************************************************************************/
/****************************************************************************/



////////////////////////////////////////////////////////////////////////
// ALLOW TTF IN MEDIA LIBRARY////////////////////
////////////////////////////////////////////////////////////////////////
add_filter('upload_mimes', 'add_custom_upload_mimes');
function add_custom_upload_mimes($existing_mimes) {
    $existing_mimes['ttf'] = 'application/x-font-ttf';
    return $existing_mimes;
}
////////////////////////////////////////////////////////////////////////
// ALLOW TTF IN MEDIA LIBRARY////////////////////
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// Ultimate Member Profile Display Name Integration ////////////////////
////////////////////////////////////////////////////////////////////////
add_filter('wpdiscuz_comment_author', 'wpdiscuz_um_author', 10, 2);
function wpdiscuz_um_author($author_name, $comment) {
    if ($comment->user_id) {
        $column = 'display_name'; // Other options: 'user_login', 'user_nicename', 'nickname', 'first_name', 'last_name'
        if (class_exists('UM_API') || class_exists('UM')) {
            um_fetch_user($comment->user_id); $author_name = um_user($column); um_reset_user();
        } else {
            $author_name = get_the_author_meta($column, $comment->user_id);
        }
    }
    return $author_name;
}
////////////////////////////////////////////////////////////////////////
// Ultimate Member Profile URL Integration /////////////////////////////
////////////////////////////////////////////////////////////////////////
add_filter('wpdiscuz_profile_url', 'wpdiscuz_um_profile_url', 10, 2);
function wpdiscuz_um_profile_url($profile_url, $user) {
    if ($user && (class_exists('UM_API') || class_exists('UM'))) {
        um_fetch_user($user->ID); $profile_url = um_user_profile_url();
    }
    return $profile_url;
}

function date_compare($a, $b) ////***helper function to sort the array by starting date via "date" field ****/
{
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    return $t1 - $t2;
}

function timestamp_compare($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
{
    $t1 = $a['$webinar_timestamp'];
    $t2 = $b['$webinar_timestamp'];
    return $t1 - $t2;
}

function timestamp_compare_desc($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
{
    $t1 = $a['$webinar_timestamp'];
    $t2 = $b['$webinar_timestamp'];

    if ($t1 === $t2) {
        return strcmp(strtolower($a['$webinar_vorschautitel']), strtolower($b['$webinar_vorschautitel']));
    }
    
    return $t2 - $t1;
}

function sort_by_timestamp($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
{
    $t1 = $a['timestamp'];
    $t2 = $b['timestamp'];
    return $t1 - $t2;
}

/**register google maps api**/
function my_acf_google_map_api( $api ){

    $api['key'] = 'AIzaSyD9Qw28M7pNw6mb0WfJwA1wVO10XzfC7RE';

    return $api;

}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');




//Weiterleitung auf kleingeschriebene URL, falls Großbuchstaben in der URL gefunden werden.
//function kleingeschriebeneURL () { if (preg_match('/[A-Z]/', $_SERVER['REQUEST_URI'])) { header('Location: ' . strtolower($_SERVER['REQUEST_URI']), TRUE, 301); exit(); } } add_action('init', 'kleingeschriebeneURL');



function reading_time($id) {
    $content = get_post_field( 'post_content', $id );
    $word_count = str_word_count( strip_tags( $content ) );
    $readingtime = ceil($word_count / 200);

    if ($readingtime == 1) {
        $timer = " Min";
    } else {
        $timer = " Min";
    }
    $totalreadingtime = $readingtime . $timer;

    return $totalreadingtime;
}


//set all forms to scroll to themselves after submit instead of top of page
add_filter( 'gform_confirmation_anchor', '__return_true' );



//****Adding Open Graph Data to the head***//
//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');


//////////////////////////DYNAMIC LOAD MORE//////////////////

//////////////////////////END OF DYNAMIC LOAD MORE//////////////////
///
/// //measureing php runtime function
function rutime($ru, $rus, $index) {
    return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
        -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
}
//measureing php runtime function


//saving webinar_endzeitpunkt on webinar post save/publish/update
//webinar_endzeitpunkt
// get current count value
add_action('save_post', 'webinar_save_enddate', 10, 3 );
function webinar_save_enddate( $post_ID, $post, $update )
{
    if ($post->post_type == 'webinare') {
        $webinar_day  = get_field("webinar_datum", $post_ID);
        //$webinar_day = substr($webinar_datum, 0, 10);
        if (strlen($webinar_day)>1) {
            $webinar_time = get_field("webinar_uhrzeit_start");
            //$date = DateTime::createFromFormat('d.m.Y', $webinar_day);
            //$newday = $date->format('Y-m-d'); // => 2013-12-24
            $webinar_uhrzeit_start = get_field("webinar_uhrzeit_start", $post_ID);
            $webinar_time_ende = get_field("webinar_uhrzeit_ende", $post_ID);
            $webinar_start_value = $webinar_day . " " . $webinar_uhrzeit_start;
            $webinar_end_value = $webinar_day . " " . $webinar_time_ende;
// update

            //data endzeitpunkt
            $field_key = "field_5c5d7af095881";
            $value = $webinar_end_value;

            ///data startzeitpunkt
            $startfield_key = "field_5c87897ee3ed6";
            $startvalue = $webinar_start_value;


            update_field($field_key, $value, $post_ID); //endzeitpunkt
            update_field($startfield_key, $startvalue, $post_ID); //startzeitpunkt
        }
    }
}

//add_filter('wp_feed_cache_transient_lifetime', create_function('', 'return 10;')); //refreshing the feed within 10seconds

//////////***********************************/////////////////////////
//////////***********************************/////////////////////////
//////////***********************************/////////////////////////
//////////***********************************/////////////////////////
//****************JSON FUNCTION FOR WEBINARE***********************/
function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

function update_json_files( $post_id, $post ) {
    // If this is just a revision, don't rebuild the json
    if ( wp_is_post_revision( $post_id ) ) {
        return;
    }

    if (isset($post->post_status) && 'auto-draft' == $post->post_status) {
        return;
    }

    // Autosave, do nothing
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // AJAX? Not used here
    if (defined('DOING_AJAX') && DOING_AJAX) {
        return;
    }

    // Return if it's a post revision
    if ( false !== wp_is_post_revision( $post_id ) ) {
        return;
    }

    $post_type = get_post_type($post_id);

    if (USE_JSON_POSTS_SYNC) {
        if ($post_type == "webinare") {
            require_once('library/json/json_webinare.php');
            json_webinare();
        }

        if ($post_type == "tool") {
            require_once('library/json/json_tools.php');
            json_tools();
        }

        if ($post_type == "toolrezension") {
            require_once ('library/tools/json-rezensionen.php');
            json_toolrezensionen($post_id);
        }

        if (in_array($post_type, Magazines::keys())) {
            require_once('library/json/json_magazinartikel.php');
            json_artikel();
        }
    }

    if ("seminare" == $post_type || "product" == $post_type) {
        require_once('library/json/json_seminare.php');
        json_seminare();
    }

    if ("podcasts" == $post_type) {
        require_once('library/json/json_podcasts.php');
        json_podcasts();
    }

    if ("agenturen" == $post_type) {
        require_once ('library/json/json_agenturen.php');
        json_agenturen($post_id);
    }
}
add_action( 'save_post', 'update_json_files', 10, 3 );

function rocket_lazyload_exclude_class( $attributes ) {
    $attributes[] = 'class="no-ll"';

    return $attributes;
}
add_filter( 'rocket_lazyload_excluded_attributes', 'rocket_lazyload_exclude_class' );


////////////ACF META FELDER IN REST PUBLISHEN
function create_ACF_meta_in_REST() {
    /*   $postypes_to_exclude = ['acf-field-group','acf-field'];
       $extra_postypes_to_include = ["page"];
       $post_types = array_diff(get_post_types(["_builtin" => false], 'names'),$postypes_to_exclude);

       array_push($post_types, $extra_postypes_to_include);

       foreach ($post_types as $post_type) {*/
    register_rest_field( "webinare", 'ACF', [
            'get_callback'    => 'expose_ACF_fields',
            'schema'          => null,
        ]
    );
    register_rest_field( "speaker", 'ACF', [
            'get_callback'    => 'expose_ACF_fields',
            'schema'          => null,
        ]
    );
    register_rest_field( "seminare", 'ACF', [
            'get_callback'    => 'expose_ACF_fields',
            'schema'          => null,
        ]
    );
    register_rest_field( "locations", 'ACF', [
            'get_callback'    => 'expose_ACF_fields',
            'schema'          => null,
        ]
    );
    //   }

}


/////////SHOW PRODUCT VARIATIONS IN REST API//////////////////
add_filter('woocommerce_rest_prepare_product_object', 'custom_change_product_response', 20, 3);
add_filter('woocommerce_rest_prepare_product_variation_object', 'custom_change_product_response', 20, 3);

function custom_change_product_response($response, $object, $request) {
    $variations = $response->data['variations'];
    $variations_res = array();
    $variations_array = array();
    if (!empty($variations) && is_array($variations)) {
        foreach ($variations as $variation) {
            $variation_id = $variation;
            $variation = new WC_Product_Variation($variation_id);
            $variations_res['id'] = $variation_id;
            $variations_res['on_sale'] = $variation->is_on_sale();
            $variations_res['regular_price'] = (float)$variation->get_regular_price();
            $variations_res['sale_price'] = (float)$variation->get_sale_price();
            $variations_res['sku'] = $variation->get_sku();
            $variations_res['quantity'] = $variation->get_stock_quantity();
            if ($variations_res['quantity'] == null) {
                $variations_res['quantity'] = '';
            }
            $variations_res['stock'] = $variation->get_stock_quantity();

            $attributes = array();
            // variation attributes
            foreach ( $variation->get_variation_attributes() as $attribute_name => $attribute ) {
                // taxonomy-based attributes are prefixed with `pa_`, otherwise simply `attribute_`
                $attributes[] = array(
                    'name'   => wc_attribute_label( str_replace( 'attribute_', '', $attribute_name ), $variation ),
                    'slug'   => str_replace( 'attribute_', '', wc_attribute_taxonomy_slug( $attribute_name ) ),
                    'option' => $attribute,
                );
            }

            $variations_res['attributes'] = $attributes;
            $variations_array[] = $variations_res;
        }
    }
    $response->data['product_variations'] = $variations_array;

    return $response;
}
/////////SHOW PRODUCT VARIATIONS IN REST API//////////////////

function expose_ACF_fields( $object ) {
    $ID = $object['id'];
    return get_fields($ID);
}

add_action( 'rest_api_init', 'create_ACF_meta_in_REST' );
///////////END OF ACF REST
///
///
//Exclude Toolanbieter Page from Autoptimize:
add_filter('autoptimize_filter_noptimize','unbounce_noptimize',10,0);
function unbounce_noptimize() {
    if ((strpos($_SERVER['REQUEST_URI'],'toolanbieter/')!==false)) {
        return true;
    } else {
        return false;
    }
}

//deactivate searchwp woocommerce notice
add_filter( 'searchwp_missing_integration_notices', '__return_false' );


/////REWRITING URLS FOR SUBCATEGORIES IN TOOLS
//add_action('init', 'rewrite_rule_example');
/**
 * Add rewrite rule for a pattern matching "post-by-slug/<post_name>"
 */
function rewrite_rule_example() {
    add_rewrite_rule('^online-marketing-tools/rechnungsprogramme/fuer-kleinunternehmer/','/online-marketing-tools/rechnungsprogramme-fuer-kleinunternehmer/','top');
}

/** -----------------------------------------------------------
 * Plugin Name: Rewrite Test
 * Plugin URI:  http://www.coder-welten.com/die-wp-rewrite-api/
 * Author:      Horst Müller
 * ------------------------------------------------------------
 */
//"http://www.example.com/oldies/example/evergreens-aus-den-50er-jahren/"
// => "http://www.example.com/oldies/evergreens/50er-jahre/"

//add_action("init", "teste_eine_neue_rewrite_regel");

//function teste_eine_neue_rewrite_regel() {
//    global $wp_rewrite;
//    add_rewrite_rule(
//        '^online-marketing-tools/([a-zA-Z0-9]+?)/([a-zA-Z0-9-]+?)/?$',
//        'index.php?name=$matches[2]',
//        'top'
//    );
//    $wp_rewrite->flush_rules();
//}


function no_redirect_on_404($redirect_url)
{
    if (is_404()) {
        return false;
    }
    return $redirect_url;
}


//fix for wp 5.5.x
add_action( 'admin_footer', function () {
    ?>
    <script>
        if ( typeof commonL10n === 'undefined' ) {
            var commonL10n = { dismiss : 'Dismiss' };
        }
    </script>
    <?php
}, 100 );

// Init posts synchronization to Datahost database
PostsSynchronization::init();

// Init Jobs/Hooks/Filters/Actions
AdvancedCacheFileRegeneration::init();
ManageRss2Feed::init();
CustomThankYouPage::init();
NotifyAdminsAboutNewOrder::init();
SetPostsToNoIndex::init();
StringifyBrokenCommentUrls::init();
ManageUserProfile::init();
SetLangAttributeToGerman::init();
HideExtraFeedLink::init();

// Init administrator Jobs/Hooks/Filters/Actions
OpenUserProfileResume::init();
ExportUserProfiles::init();

// Init Ajax requests
AjaxRequests::init();

//add standard (facebooks default) facebook app ID:
function add_fb_app_id() {
    $app_id = 966242223397117;
    $tag = '<meta property="fb:app_id" content="%d" />';
    echo sprintf($tag, $app_id);
}
add_action( 'wp_head', 'add_fb_app_id' );

//change itemprop="author" for Magazin Post Types
function magazin_change_author($authordata){
    if(!$authordata)
        return NULL;
    $magazinPostTypes = Magazines::keys();
    if(!in_array(get_post_type(), $magazinPostTypes)){
        return NULL;
    }
    $autor = get_field('autor');
    $autor = $autor[0];
    return get_the_title($autor->ID);
}
add_filter('the_author' , 'magazin_change_author');


//removes all link in the content
function removeLink($str){
    $regex = '/<a (.*)<\/a>/isU';
    preg_match_all($regex,$str,$result);
    foreach($result[0] as $rs){
        $regex = '/<a (.*)>(.*)<\/a>/isU';
        $text = preg_replace($regex,'$2',$rs);
        $str = str_replace($rs,$text,$str);
    }
    return $str;
}





// Add product activate deactivate checkbox in woocomerece product variation
function action_woocommerce_variation_options( $loop, $variation_data, $variation ) {
    $is_checked = get_post_meta( $variation->ID, '_activePro', true );

    if ( $is_checked == 'yes' ) {
        $is_checked = 'checked';
    } else {
        $is_checked = '';     
    }

    ?>
    <label class="tips" data-tip="<?php esc_attr_e( 'This is my data tip', 'woocommerce' ); ?>">
        <?php esc_html_e( 'Active:', 'woocommerce' ); ?>
        <input type="checkbox" class="checkbox variable_checkbox" name="_activePro[<?php echo esc_attr( $loop ); ?>]"<?php echo $is_checked; ?>/>
    </label>
    <?php
}
add_action( 'woocommerce_variation_options', 'action_woocommerce_variation_options', 10, 3);

// Save checkbox
function action_woocommerce_save_product_variation( $variation_id, $i ) {
    if ( ! empty( $_POST['_activePro'] ) && ! empty( $_POST['_activePro'][$i] ) ) {
        update_post_meta( $variation_id, '_activePro', 'yes' );
    } else {
        update_post_meta( $variation_id, '_activePro', 'no' ); 
    }       
}
add_action( 'woocommerce_save_product_variation', 'action_woocommerce_save_product_variation', 10, 2 );

//Custom toolbar for URL Insights
add_filter( 'acf/fields/wysiwyg/toolbars' , 'custom_toolbar'  );
function custom_toolbar( $toolbars )
{
    if(!is_admin()){
       $toolbars['Full' ] = array();
        $toolbars['Full' ][1] = array(
            'formatselect',
            'bold',
            'italic',
            'bullist',
            'numlist',
            'blockquote',
            'alignleft',
            'aligncenter',
            'alignright',
            'wp_more',
            'spellchecker',
            'fullscreen',
            'wp_adv',
            'separator',
        );
        $toolbars['Full' ][2] = array(
            'strikethrough',
            'horizontalline',
            'underline',
            'forecolor',
            'pastetext',
            'pasteword',
            'removeformat',
            'charmap',
            'outdent',
            'indent',
            'undo',
            'redo',
            'wp_help',
        );
    }
    
    if( ($key = array_search('code' , $toolbars['Full' ][2])) !== false )
    {
        unset( $toolbars['Full' ][2][$key] );
    }
    unset( $toolbars['Basic' ] );
    return $toolbars;
}


function wpb_find_shortcode($atts, $content=null) { 
ob_start();
extract( shortcode_atts( array(
        'find' => '',
    ), $atts ) );
 
$string = $atts['find'];
 
$args = array(
    's' => $string,
    );
 
$the_query = new WP_Query( $args );
 
if ( $the_query->have_posts() ) {
        echo '<ul>';
    while ( $the_query->have_posts() ) {
    $the_query->the_post(); ?>
    <li><a href="<?php  the_permalink() ?>"><?php the_title(); ?></a></li>
    <?php
    }
        echo '</ul>';
} else {
        echo "Sorry no posts found"; 
}
 
wp_reset_postdata();
return ob_get_clean();
}
add_shortcode('shortcodefinder', 'wpb_find_shortcode'); 