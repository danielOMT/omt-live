<?php

use OMT\Services\GravityForms;

function bones_ahoy() {
    add_action('init', 'bones_head_cleanup');
    add_filter('the_generator', 'bones_rss_version');
    add_filter('wp_head', 'bones_remove_wp_widget_recent_comments_style', 1);
    add_action('wp_head', 'bones_remove_recent_comments_style', 1);
    add_filter('gallery_style', 'bones_gallery_style');
    add_action('wp_enqueue_scripts', 'bones_scripts_and_styles', 999);

    bones_theme_support();
    add_action('widgets_init', 'bones_register_sidebars');
    add_filter('get_search_form', 'bones_wpsearch');
    add_filter('the_content', 'bones_filter_ptags_on_images');
    add_filter('excerpt_more', 'bones_excerpt_more');
}
add_action('after_setup_theme', 'bones_ahoy', 16);


function bones_head_cleanup() {
    // remove_action('wp_head', 'feed_links_extra', 3);
    // remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_generator');
    add_filter('style_loader_src', 'bones_remove_wp_ver_css_js', 9999);
    add_filter('script_loader_src', 'bones_remove_wp_ver_css_js', 9999);
}


function bones_rss_version() {
    return '';
}


function bones_remove_wp_ver_css_js($src) {
    // Leave "ver=" for GravityForms scrips and assets that have a custom version like "c.1.0.0".
    // This will fix Cache purge error of the pages that aren't cached by WP Rocket
    if (strpos($src, 'ver=') && strpos($src, 'ver=c.') === false && !GravityForms::isPluginScript($src)) {
        $src = remove_query_arg( 'ver', $src );
    }

    return $src;
}


function bones_remove_wp_widget_recent_comments_style() {
    if (has_filter('wp_head', 'wp_widget_recent_comments_style')) {
        remove_filter('wp_head', 'wp_widget_recent_comments_style');
    }
}


function bones_remove_recent_comments_style() {
    global $wp_widget_factory;
    if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
        remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
    }
}


function bones_gallery_style($css) {
    return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


function bones_scripts_and_styles() {
    global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
        // use google's cdn jquery
        wp_deregister_script('jquery'); // use google cdn instead. should we go to jQuery 2 (no winxp support)?
        wp_enqueue_script('jquery', get_stylesheet_directory_uri() . '/library/js/libs/jquery-3.6.0.min.js', array(), '3.6.0', false); // no http: so it works on both http and https
        // wp_enqueue_script('passive_events', get_stylesheet_directory_uri() . '/library/js/libs/passive_events.js', array(), '1.3.2', false); // no http: so it works on both http and https
        // modernizr (without media query polyfill)
        //wp_enqueue_script('bones-modernizr', get_stylesheet_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', true);
        wp_enqueue_style('bones-stylesheet', get_stylesheet_directory_uri() . '/library/less/style.less', array(), '', 'all');
        wp_enqueue_style('bones-ie-only', get_stylesheet_directory_uri() . '/library/less/ie.less', array(), '');
        //wp_enqueue_style('fontawesome', get_stylesheet_directory_uri() . '/library/font-awesome-4.6.3/less/font-awesome.less";', array(), '');
        wp_enqueue_script('fastclick', get_stylesheet_directory_uri() . '/library/js/libs/fastclick.js', array('jquery'), '', true );
        wp_enqueue_script('slick', get_stylesheet_directory_uri() . '/library/js/slick/slick.min.js', array('jquery'), '', true);
        wp_enqueue_script('acfmaps', get_stylesheet_directory_uri() . '/library/js/acf-maps.js', ['jquery', 'google-api'], 'c.1.0.0', true);
        if (is_admin()) { wp_enqueue_script('tinymcebuttons', get_stylesheet_directory_uri() . '/library/js/tinymce_buttons/tinymce_buttons.js', array('jquery'), '', true); }
        wp_enqueue_script('hoverintent', get_stylesheet_directory_uri() . '/library/js/libs/hoverIntent.min.js', array('jquery'), '', true);
        // wp_enqueue_script('matchheight', get_stylesheet_directory_uri() . '/library/js/libs/matchheight.min.js', array('jquery'), '', true);
        wp_enqueue_script('countdown', get_stylesheet_directory_uri() . '/library/js/libs/countdown.js', array('jquery'), '', true );
        wp_enqueue_script('bones-js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array('jquery'), '', true);
        wp_enqueue_script('bones-critical-js', get_stylesheet_directory_uri() . '/library/js/critical-scripts.js', array('jquery'), 'c.1.0.0', true);
        wp_enqueue_script('magnific-popup', get_stylesheet_directory_uri() . '/library/js/libs/jquery.magnific-popup.min.js', array('jquery'), '', true);
        wp_enqueue_script('sticky-kit', get_stylesheet_directory_uri() . '/library/js/libs/sticky-kit.js', array('jquery'), '', true);
        //wp_enqueue_script('stickysidebar', get_stylesheet_directory_uri() . '/library/js/libs/sticky-sidebar.js', array('jquery'), '', true); 
        //   wp_enqueue_script('scrollmagic', get_stylesheet_directory_uri() . '/library/js/libs/scrollmagic.js', array('jquery'), '', true);

        if (!is_user_logged_in()) {
            wp_enqueue_script('guest-bones-js', get_stylesheet_directory_uri() . '/library/js/guest-scripts.js', ['jquery'], '', true);
        }

        $wp_styles->add_data('bones-ie-only', 'conditional', 'lt IE 9'); // add conditional wrapper around ie stylesheet
    }
}


function bones_theme_support() {
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(125, 125, true);

    add_theme_support('automatic-feed-links');
    add_theme_support('menus');

    register_nav_menus(array(
        'main-nav' => __('The Main Menu', 'bonestheme'),   // main nav in header
        'mobile-nav' => __('The Mobile Menu', 'bonestheme'),   // main nav in header
        'footer-links' => __('Footer Links', 'bonestheme'), // secondary nav in footer
        'footer-links-2' => __('Footer Links 2', 'bonestheme'), // secondary nav in footer
        'footer-links-3' => __('Footer Links 3', 'bonestheme'), // secondary nav in footer
        'footer-links-4' => __('Footer Links 4', 'bonestheme') // secondary nav in footer
    ));

    /*
        add_theme_support('custom-background', array(
            'default-image' => '',  // background image default
            'default-color' => '', // background color default (dont add the #)
            'wp-head-callback' => '_custom_background_cb',
            'admin-head-callback' => '',
            'admin-preview-callback' => ''
        ));
    */

    // add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
}


function bones_main_nav() {
    wp_nav_menu(array(
        'container' => false,
        'container_class' => 'menu clearfix',
        'menu' => __('The Main Menu', 'bonestheme'),
        'menu_class' => 'nav top-nav clearfix hide-on-mobile',
        'theme_location' => 'main-nav',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'depth' => 0,
        'fallback_cb' => 'bones_main_nav_fallback'
    ));
}

function bones_mobile_nav() {
    wp_nav_menu(array(
        'container' => false,
        'container_class' => 'menu clearfix',
        'menu' => __('The Mobile Menu', 'bonestheme'),
        'menu_class' => 'nav mobile-nav clearfix hide-on-mobile',
        'theme_location' => 'mobile-nav',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'depth' => 0,
        'fallback_cb' => 'bones_mobile_nav_fallback'
    ));
}


function bones_footer_links() {
    wp_nav_menu(array(
        'container' => '',
        'container_class' => 'footer-links clearfix',
        'menu' => __('Footer Links', 'bonestheme'),
        'menu_class' => 'nav footer-nav fnav-1 clearfix',
        'theme_location' => 'footer-links',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'depth' => 0,
        'fallback_cb' => 'bones_footer_links_fallback'
    ));

    wp_nav_menu(array(
        'container' => '',
        'container_class' => 'footer-links clearfix',
        'menu' => __('Footer Links 2', 'bonestheme'),
        'menu_class' => 'nav footer-nav fnav-2 clearfix',
        'theme_location' => 'footer-links-2',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'depth' => 0,
        'fallback_cb' => 'bones_footer_links_fallback'
    ));

    wp_nav_menu(array(
        'container' => '',
        'container_class' => 'footer-links clearfix',
        'menu' => __('Footer Links 3', 'bonestheme'),
        'menu_class' => 'nav footer-nav fnav-3 clearfix',
        'theme_location' => 'footer-links-3',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'depth' => 0,
        'fallback_cb' => 'bones_footer_links_fallback'
    ));

    wp_nav_menu(array(
        'container' => '',
        'container_class' => 'footer-links clearfix',
        'menu' => __('Footer Links 4', 'bonestheme'),
        'menu_class' => 'nav footer-nav fnav-4 clearfix',
        'theme_location' => 'footer-links-4',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'depth' => 0,
        'fallback_cb' => 'bones_footer_links_fallback'
    ));
}


function bones_main_nav_fallback() {
    wp_page_menu(array(
        'show_home' => true,
        'menu_class' => 'nav top-nav clearfix',
        'include' => '',
        'exclude' => '',
        'echo' => true,
        'link_before' => '',
        'link_after' => ''
    ));
}


function bones_footer_links_fallback() {
    /* you can put a default here if you like */
}


/*
function bones_related_posts() {
	echo '<ul id="bones-related-posts">';
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {
		foreach ($tags as $tag) {
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5,
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts($args);
		if ($related_posts) {
			foreach ($related_posts as $post) : setup_postdata($post); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; 
		} else { ?>
			<?php echo '<li class="no_related_post">' . __('No Related Posts Yet!', 'bonestheme') . '</li>'; ?>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
}
*/


function bones_page_navi() {
    global $wp_query;
    $bignum = 999999999;
    if ($wp_query->max_num_pages <= 1) {
        return;
    }
    echo '<nav class="pagination">';
    echo paginate_links(array(
        'base' => str_replace($bignum, '%#%', esc_url(get_pagenum_link($bignum))),
        'format' => '',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
        'type' => 'list',
        'end_size' => 3,
        'mid_size' => 3
    ));
    echo '</nav>';
}


// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function bones_filter_ptags_on_images($content) {
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}


// remove the annoying […] to a Read More link
function bones_excerpt_more($more) {
    global $post;
    // edit here if you like
    return '... <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. get_the_title($post->ID).'">'. __('weiterlesen &raquo;', 'bonestheme') .'</a>';
}


// This is a modified the_author_posts_link() which just returns the link. This is necessary to allow usage of the usual l10n process with printf().
function bones_get_the_author_posts_link() {
    global $authordata;
    if (!is_object($authordata)) {
        return false;
    }
    $link = sprintf('<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
        get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
        esc_attr(sprintf( __('Posts by %s'), get_the_author())), // No further l10n needed, core will take care of this one
        get_the_author()
    );
    return $link;
}