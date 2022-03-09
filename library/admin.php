<?php

function remove_dashboard_elements() {
	// remove_meta_box('dashboard_right_now', 'dashboard', 'normal');       // Right Now Widget
	// remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Comments Widget
	// remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Incoming Links Widget
	// remove_meta_box('dashboard_plugins', 'dashboard', 'normal');         // Plugins Widget
	// remove_meta_box('dashboard_quick_press', 'dashboard', 'normal');     // Quick Press Widget
	// remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal');   // Recent Drafts Widget
	// remove_meta_box('dashboard_primary', 'dashboard', 'normal');         //
	// remove_meta_box('dashboard_secondary', 'dashboard', 'normal');       //
	// remove_meta_box('yoast_db_widget', 'dashboard', 'normal');           // Yoast's SEO Plugin Widget
	// remove_meta_box('icl_dashboard_widget', 'dashboard', 'side');        // wpml admin widget

	// remove_menu_page('wpcf7', 'dashboard', 'normal');                                         // contact form 7
	// remove_menu_page('edit.php?post_type=acf', 'dashboard', 'normal');                        // acf
	// remove_menu_page('sitepress-multilingual-cms/menu/languages.php', 'dashboard', 'normal'); // wpml
	// remove_menu_page('tools.php');
	// remove_menu_page('plugins.php');
	// remove_menu_page('acf-options');
	// remove_submenu_page('themes.php','customize.php'); // themes customize
}
add_action('admin_menu', 'remove_dashboard_elements');


function remove_dashboard_elements_init() {
	//remove_submenu_page('themes.php','theme-editor.php'); // themes editor
}
add_action('admin_init', 'remove_dashboard_elements_init');


function remove_from_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'remove_from_admin_bar', 0);


/*
function bones_rss_dashboard_widget() {
	if(function_exists('fetch_feed')) {
		include_once(ABSPATH . WPINC . '/feed.php');               // include the required file
		$feed = fetch_feed('http://themble.com/feed/rss/');        // specify the source feed
		$limit = $feed->get_item_quantity(7);                      // specify number of items
		$items = $feed->get_items(0, $limit);                      // create an array of items
	}
	if ($limit == 0) echo '<div>The RSS Feed is either empty or unavailable.</div>';   // fallback message
	else foreach ($items as $item) { ?>

	<h4 style="margin-bottom: 0;">
		<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo mysql2date(__('j F Y @ g:i a', 'bonestheme'), $item->get_date('Y-m-d H:i:s')); ?>" target="_blank">
			<?php echo $item->get_title(); ?>
		</a>
	</h4>
	<p style="margin-top: 0.5em;">
		<?php echo substr($item->get_description(), 0, 200); ?>
	</p>
	<?php }
}

function bones_custom_dashboard_widgets() {
	wp_add_dashboard_widget('bones_rss_dashboard_widget', __('Recently on Themble (Customize on admin.php)', 'bonestheme'), 'bones_rss_dashboard_widget');
}
add_action('wp_dashboard_setup', 'bones_custom_dashboard_widgets');
*/


function bones_login_css() {
	wp_enqueue_style( 'bones_login_css', get_template_directory_uri() . '/library/less/login.less', false);
}
add_action('login_enqueue_scripts', 'bones_login_css', 10);


function bones_login_url() {
	return home_url();
}
add_filter('login_headerurl', 'bones_login_url');


function bones_login_title() {
	return get_option('blogname');
}
add_filter('login_headertitle', 'bones_login_title');


function bones_custom_admin_footer() {
	_e('', 'bonestheme');
}
add_filter('admin_footer_text', 'bones_custom_admin_footer');