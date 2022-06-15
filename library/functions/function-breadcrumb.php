<?php // Breadcrumbs
function custom_breadcrumbs() {

// Settings
    $separator          = '&#187;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Home';

// If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';

// Get the query & post information
    global $post,$wp_query;

    if (is_front_page()) {
        echo '<b>Du befindest Dich auf der Startseite</b>';
    }
// Do not display on the homepage
    if ( !is_front_page() ) {

// Build the breadcrums
        echo '<b>Du bist hier:&nbsp;</b><ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';

        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';

        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';

        } else if ( is_single() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
                $post_type_name = $post_type_object->labels->name;
                //falls der Post ein Magazinartikel ist, welche diverse andere Post Types haben
                switch ($post_type) {
                    case "magazin":
                        $post_type_name = "Magazin";
                        $post_type_archive = "https://www.omt.de";
                        break;
                    case "seo":
                        $post_type_name = "Suchmaschinenoptimierung";
                        $post_type_archive = "/suchmaschinenoptimierung";
                        break;
                    case "sma":
                        $post_type_name = "Suchmaschinenmarketing";
                        $post_type_archive = "/suchmaschinenmarketing";
                        break;
                    case "affiliate":
                        $post_type_name = "Affiliate Marketing";
                        $post_type_archive = "/affiliate-marketing";
                        break;
                    case "amazon":
                        $post_type_name = "Amazon SEO";
                        $post_type_archive = "/amazon-seo";
                        break;
                    case "amazon_marketing":
                        $post_type_name = "Amazon Marketing";
                        $post_type_archive = "/amazon-marketing";
                        break;
                    case "content":
                        $post_type_name = "Content Marketing";
                        $post_type_archive = "/content-marketing";
                        break;
                    case "conversion":
                        $post_type_name = "Conversion Optimierung";
                        $post_type_archive = "/conversion-optimierung";
                        break;
                    case "digitalesmarketing":
                        $post_type_name = "Digital Marketing";
                        $post_type_archive = "/digital-marketing";
                        break;
                    case "direktmarketing":
                        $post_type_name = "Direktmarketing";
                        $post_type_archive = "/direktmarketing";
                        break;
                    case "e-commerce":
                        $post_type_name = "E-Commerce";
                        $post_type_archive = "/e-commerce";
                        break;
                    case "facebook":
                        $post_type_name = "Facebook Ads";
                        $post_type_archive = "/facebook-ads";
                        break;
                    case "ga":
                        $post_type_name = "Google Analytics";
                        $post_type_archive = "/online-marketing-tools/google-analytics";
                        break;
                    case "gmb":
                        $post_type_name = "Google My Business";
                        $post_type_archive = "/google-my-business";
                        break;
                    case "growthhack":
                        $post_type_name = "Growth Hacking";
                        $post_type_archive = "/growth-hacking";
                        break;
                    case "inbound":
                        $post_type_name = "Inbound Marketing";
                        $post_type_archive = "/inbound-marketing";
                        break;
                    case "internetmarketing":
                        $post_type_name = "Internet  Marketing";
                        $post_type_archive = "/internet-marketing";
                        break;
                    case "links":
                        $post_type_name = "Linkbuilding";
                        $post_type_archive = "/linkbuilding";
                        break;
                    case "sea":
                        $post_type_name = "Google Ads";
                        $post_type_archive = "/google-ads";
                        break;
                    case "social":
                        $post_type_name = "Social Media Marketing";
                        $post_type_archive = "/social-media-marketing";
                        break;
                    case "webanalyse":
                        $post_type_name = "Webanalyse";
                        $post_type_archive = "/webanalyse";
                        break;
                    case "videomarketing":
                        $post_type_name = "Video Marketing";
                        $post_type_archive = "/video-marketing";
                        break;
                    case "pinterest":
                        $post_type_name = "Pinterest Marketing";
                        $post_type_archive = "/pinterest-marketing";
                        break;
                    case "performance":
                        $post_type_name = "Performance Marketing";
                        $post_type_archive = "/performance-marketing";
                        break;
                    case "onlinemarketing":
                        $post_type_name = "Online Marketing";
                        $post_type_archive = "/online-marketing";
                        break;
                    case "local":
                        $post_type_name = "Local SEO";
                        $post_type_archive = "/local-seo";
                        break;
                    case "marketing":
                        $post_type_name = "Marketing";
                        $post_type_archive = "/marketing";
                        break;
                    case "pagespeed":
                        $post_type_name = "Wordpress Pagespeed";
                        $post_type_archive = "/wordpress-pagespeed";
                        break;
                    case "plugins":
                        $post_type_name = "Wordpress Plugins";
                        $post_type_archive = "/wordpress-plugins";
                        break;
                    case "p_r":
                        $post_type_name = "PR";
                        $post_type_archive = "/pr";
                        break;
                    case "emailmarketing":
                        $post_type_name = "Email Marketing";
                        $post_type_archive = "/email-marketing";
                        break;
                    case "influencer":
                        $post_type_name = "Influencer Marketing";
                        $post_type_archive = "/influencer-marketing";
                        break;
                    case "tiktok":
                        $post_type_name = "TikTok-Marketing";
                        $post_type_archive = "/tiktok-marketing";
                        break;
                    case "tool":
                        $post_type_name = "Online Marketing Tools";
                        $post_type_archive = "/online-marketing-tools";
                        break;
                    case "vortrag":
                        $post_type_name = "Vorträge";
                        $post_type_archive = "/konferenz";
                        break;
                    case "speaker":
                        $post_type_name = "Experte beim OMT";
                        $post_type_archive = "/konferenz";
                        break;
                    case "emailmarketing":
                        $post_type_name = "Email Marketing";
                        $post_type_archive = "/email-marketing";
                        break;
                    case "webanalyse":
                        $post_type_name = "Webanalyse";
                        $post_type_archive = "/webanalyse";
                        break;
                    case "webdesign":
                        $post_type_name = "Webdesign";
                        $post_type_archive = "/webdesign";
                        break;
                    case "wordpress":
                        $post_type_name = "WordPress";
                        $post_type_archive = "/online-marketing-tools/wordpress/";
                        break;
                    case "omt_magazin":
                        $post_type_name = "OMT-Magazin";
                        $post_type_archive = "/downloads/magazin";
                        break;
                    case "omt_ebook":
                        $post_type_name = "OMT-eBooks";
                        $post_type_archive = "/downloads/ebooks";
                        break;
                    case "omt_student":
                        $post_type_name = "OMT-Studentenarbeiten";
                        $post_type_archive = "/downloads/studentenarbeiten";
                        break;
                    case "omt_downloads":
                        $post_type_name = "OMT-Leadmagneten";
                        $post_type_archive = "/downloads/leadmagneten";
                        break;
                    case "podcasts":
                        $post_type_name = "OMT-Podcast";
                        $post_type_archive = "/podcast";
                        break;
                    case "agenturen":
                        $post_type_name = "OMT-Agenturfinder";
                        $post_type_archive = "/agentur-finden/agentur";
                        break;
                    case "wissenswertes":
                        $post_type_name = "Wissenswertes";
                        $post_type_archive = "/wissenswertes";
                        break;
                }
                if (strlen ($post_type_archive)<1) { $post_type_archive = "/" . $post_type; } //if we dont have an archive due to parent pages

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '/" title="' . $post_type_object->labels->name . '">' . $post_type_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            // Get post category info
            $category = get_the_category();

            if(!empty($category)) {

                // Get last category post is in
                $last_category = end(array_values($category));

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                // foreach($cat_parents as $parents) {
                //$cat_display .= '<li class="item-cat">'.$parents.'</li>';
                //$cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                //}

            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;

            }

            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

                // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {

                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            } else {

                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            }

        } else if ( is_category() ) {

            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';

        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ){

                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';

            } else {

                // Just display current page if not parents
                $header_hero_h1 = get_field('header_hero_h1');
                if (strlen($header_hero_h1)>0) { $h1 = $header_hero_h1;} else { $h1 = get_the_title(); }
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . $h1 . '</strong></li>';

            }

        } else if ( is_tag() ) {

            // Tag page

            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;

            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';

        } elseif ( is_day() ) {

            // Day archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_month() ) {

            // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_year() ) {

            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';

        } else if ( is_author() ) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';

        } else if ( get_query_var('paged') ) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }  elseif ( is_home() ) {
            echo '<li class="item-current item-current-news"><strong class="bread-current bread-current-news" title="News">News</strong></li>';
        }

        echo '</ul>';

    }

}?>