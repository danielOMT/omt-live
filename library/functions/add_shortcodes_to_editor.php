<?php
//buy this guy a beer: https://madebydenis.com/adding-shortcode-button-to-tinymce-editor/
add_action( 'after_setup_theme', 'mytheme_theme_setup' );

if ( ! function_exists( 'mytheme_theme_setup' ) ) {
    function mytheme_theme_setup() {

        add_action( 'init', 'mytheme_buttons' );

    }
}

/********* TinyMCE Buttons ***********/
if ( ! function_exists( 'mytheme_buttons' ) ) {
    function mytheme_buttons() {
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
            return;
        }

        if ( get_user_option( 'rich_editing' ) !== 'true' ) {
            return;
        }

        add_filter( 'mce_external_plugins', 'mytheme_add_buttons' );
        add_filter( 'mce_buttons', 'mytheme_register_buttons' );
    }
}

if ( ! function_exists( 'mytheme_add_buttons' ) ) {
    function mytheme_add_buttons( $plugin_array ) {
        $plugin_array['shortcode_button'] = get_template_directory_uri().'/library/js/tinymce_buttons/tinymce_buttons.js';
        $plugin_array['shortcode_webinar'] = get_template_directory_uri().'/library/js/tinymce_buttons/tinymce_buttons.js';
        $plugin_array['shortcode_ebook'] = get_template_directory_uri().'/library/js/tinymce_buttons/tinymce_buttons.js';
        $plugin_array['shortcode_ctawidget'] = get_template_directory_uri().'/library/js/tinymce_buttons/tinymce_buttons.js';
        $plugin_array['shortcode_zitat'] = get_template_directory_uri().'/library/js/tinymce_buttons/tinymce_buttons.js';
        $plugin_array['shortcode_titlebox'] = get_template_directory_uri().'/library/js/tinymce_buttons/tinymce_buttons.js';
        $plugin_array['shortcode_youtube'] = get_template_directory_uri().'/library/js/tinymce_buttons/tinymce_buttons.js';
        $plugin_array['shortcode_podcast'] = get_template_directory_uri().'/library/js/tinymce_buttons/tinymce_buttons.js';
        $plugin_array['shortcode_tiktok'] = get_template_directory_uri().'/library/js/tinymce_buttons/tinymce_buttons.js';
        $plugin_array['shortcode_spotify'] = get_template_directory_uri().'/library/js/tinymce_buttons/tinymce_buttons.js';
        return $plugin_array;
    }
}

if ( ! function_exists( 'mytheme_register_buttons' ) ) {
    function mytheme_register_buttons( $buttons ) {
        array_push( $buttons, 'shortcode_button' );
        array_push( $buttons, 'shortcode_webinar' );
        array_push( $buttons, 'shortcode_ebook' );
        array_push( $buttons, 'shortcode_ctawidget' );
        array_push( $buttons, 'shortcode_zitat' );
        array_push( $buttons, 'shortcode_titlebox' );
        array_push( $buttons, 'shortcode_youtube' );
        array_push( $buttons, 'shortcode_podcast' );
        array_push( $buttons, 'shortcode_tiktok' );
        array_push( $buttons, 'shortcode_spotify' );
        return $buttons;
    }
}

add_action ( 'after_wp_tiny_mce', 'mytheme_tinymce_extra_vars' );

if ( !function_exists( 'mytheme_tinymce_extra_vars' ) ) {
    function mytheme_tinymce_extra_vars() { ?>
        <script type="text/javascript">
            var shortcode_button = <?php echo json_encode(
                    array(
                        'button_name' => esc_html__('Button', 'mythemeslug'),
                        'button_title' => esc_html__('Button einfügen', 'mythemeslug'),
                    )
                );
                ?>;
            var shortcode_webinar = <?php echo json_encode(
                    array(
                        'button_name' => esc_html__('Webinar', 'mythemeslug'),
                        'button_title' => esc_html__('Webinar einfügen', 'mythemeslug'),
                    )
                );
            ?>;
            var shortcode_ebook = <?php echo json_encode(
                    array(
                        'button_name' => esc_html__('Ebook', 'mythemeslug'),
                        'button_title' => esc_html__('Ebook einfügen', 'mythemeslug'),
                    )
                );
            ?>;
            var shortcode_ctawidget = <?php echo json_encode(
                array(
                    'button_name' => esc_html__('CTA Widget', 'mythemeslug'),
                    'button_title' => esc_html__('CTA Widget einfügen', 'mythemeslug'),
                    'image_title' => esc_html__('Image', 'mythemeslug'),
                    'image_button_title' => esc_html__('Bild auswählen', 'mythemeslug'),
                )
            );
            ?>; //letztes Semikolon hinter dem ?> bezieht sich auf "var ..." => nichtvergessen!
            var shortcode_zitat = <?php echo json_encode(
                    array(
                        'button_name' => esc_html__('Zitat', 'mythemeslug'),
                        'button_title' => esc_html__('Zitat einfügen', 'mythemeslug'),
                    )
                );
                ?>; //letztes Semikolon hinter dem ?> bezieht sich auf "var ..." => nichtvergessen!
             var shortcode_titlebox = <?php echo json_encode(
                    array(
                        'button_name' => esc_html__('Titlebox', 'mythemeslug'),
                        'button_title' => esc_html__('Titlebox einfügen', 'mythemeslug'),
                    )
                );
                ?>; //letztes Semikolon hinter dem ?> bezieht sich auf "var ..." => nichtvergessen!
            var shortcode_youtube = <?php echo json_encode(
                    array(
                        'button_name' => esc_html__('Youtube', 'mythemeslug'),
                        'button_title' => esc_html__('Youtube Video einfügen', 'mythemeslug'),
                    )
                );
                ?>; //letztes Semikolon hinter dem ?> bezieht sich auf "var ..." => nichtvergessen!
            var shortcode_podcast = <?php echo json_encode(
                    array(
                        'button_name' => esc_html__('Podcast Tonspur', 'mythemeslug'),
                        'button_title' => esc_html__('Podcast ID', 'mythemeslug'),
                        'button_title' => esc_html__('Soundcloud Track ID', 'mythemeslug'),
                    )
                );
                ?>; //letztes Semikolon hinter dem ?> bezieht sich auf "var ..." => nichtvergessen!
            var shortcode_tiktok = <?php echo json_encode(
                    array(
                        'button_name' => esc_html__('TikTok', 'mythemeslug'),
                        'button_title' => esc_html__('TikTok URL', 'mythemeslug'),
                    )
                );
                ?>; //letztes Semikolon hinter dem ?> bezieht sich auf "var ..." => nichtvergessen!
            var shortcode_spotify = <?php echo json_encode(
                    array(
                        'button_name' => esc_html__('Spotify', 'mythemeslug'),
                        'button_title' => esc_html__('Spotify Video ID', 'mythemeslug'),
                    )
                );
                ?>; //letztes Semikolon hinter dem ?> bezieht sich auf "var ..." => nichtvergessen!
        </script>
        <?php
    }
}