<?php get_header(); ?>
<?php
$hero_image = get_field('news_hero', 'options');
$h1 = get_field('news_h1', 'options');
?>
    <div id="content" class="" xmlns:background="http://www.w3.org/1999/xhtml">
        <div class="omt-row hero-header header-flat" style="background: url('<?php print $hero_image['url'];?>') no-repeat 50% 0;">
            <div class="wrap">
                <h1><?php print $h1;?></h1>
            </div>
        </div>
        <section class="omt-row blog-index wrap grid-wrap">
            <div class="omt-module artikel-wrap teaser-modul">
                <?php
                $magazin_count = 0;
                if (have_posts()) : while (have_posts()) : the_post();
                    $id = get_the_ID();
                    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($id), '550-290' );
                    $regular_image = wp_get_attachment_image_src( get_post_thumbnail_id($id), '350-180' );
                    $image = $featured_image[0];
                    $featimage = $featured_image[0];
                    $regimage = $regular_image[0];
                    $post_type = get_post_type($id);
                    $post_type_nice = "";
                    switch ($post_type) {
                        case "magazin": $post_type_nice = "Magazin"; break;
                        case "seo": $post_type_nice = "Suchmaschinenoptimierung"; break;
                        case "sea": $post_type_nice = "Google Ads"; break;
                        case "links": $post_type_nice = "Linkbuilding"; break;
                        case "ga": $post_type_nice = "Google Analytics"; break;
                        case "content": $post_type_nice = "Content Marketing"; break;
                        case "social": $post_type_nice = "Social Media Marketing"; break;
                        case "facebook": $post_type_nice = "Facebook Ads"; break;
                        case "affiliate": $post_type_nice = "Affiliate Marketing"; break;
                        case "conversion": $post_type_nice = "Conversion Optimierung"; break;
                        case "growthhack": $post_type_nice = "Growth Hacking"; break;
                        case "amazon": $post_type_nice = "Amazon SEO"; break;
                        case "amazon_marketing": $post_type_nice = "Amazon Marketing"; break;
                        case "local": $post_type_nice = "Local SEO"; break;
                        case "onlinemarketing": $post_type_nice = "Online Marketing"; break;
                        case "webanalyse": $post_type_nice = "Webanalyse"; break;
                        case "videomarketing": $post_type_nice = "Video Marketing"; break;
                        case "pinterest": $post_type_nice = "Pinterest Marketing"; break;
                        case "pagespeed": $post_type_nice = "Wordpress Pagespeed"; break;
                        case "plugins": $post_type_nice = "Wordpress Plugins"; break;
                    }
                    $title = get_the_title();
                    $webinar_shorttitle = implode(' ', array_slice(explode(' ', $title), 0, 7));
                    $wordcount = str_word_count($title);
                    if ($wordcount > 7) { $title = $webinar_shorttitle . "..."; }
                    ?>
                    <?php if (0 == $magazin_count) { ?>
                        <div class="teaser-modul-highlight">
                            <img class="teaser-img"
                                 width="550"
                                 height="290"
                                 alt="<?php the_title();?>"
                                 title="<?php the_title();?>"
                                 srcset="
           <?php print $regimage;?> 480w,
            <?php print $regimage;?> 800w,
            <?php print $featimage;?> 1400w"
                                 sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                                 src="<?php print $featimage;?>"
                            />
                            <div class="textarea"><?php
                                ?>
                                <h4>
                                    <?php /*<span><?php print $post_type_nice;?></span>
                                    <p class="text-red"><strong>Lesezeit: <?php echo reading_time();?></strong></p>*/?>
                                    <a href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>"><?php print $title; ?></a>
                                </h4>
                                <?php if (has_excerpt()) { the_excerpt(); } ?>
                                <a class="button" href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>">Artikel lesen</a>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (0 != $magazin_count) { ?>
                        <div class="teaser teaser-small teaser-matchbuttons">
                            <img class="webinar-image teaser-img"
                                 width="350"
                                 height="180"
                                 alt="<?php the_title();?>"
                                 title="<?php the_title();?>"
                                 srcset="
            <?php print $regimage;?> 480w,
            <?php print $regimage;?> 800w,
            <?php print $regimage;?> 1400w"
                                 sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                                 src="<?php print $regimage;?>"
                            />
                            <h4 class="teaser-cat"><?php print $post_type_nice;?></h4>
                            <p class="text-red"><strong>Lesezeit: <?php echo reading_time($id);?></strong></p>
                            <h4><a href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>"><?php print $title; ?></a></h4>
                            <?php if (has_excerpt()) { the_excerpt(); } ?>
                            <a class="button" href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>">Artikel lesen</a>
                        </div>
                    <?php } ?>
                    <?php $magazin_count++;?>
                <?php endwhile; //end ?>
                <?php endif; //end ?>
            </div>
        </section>
    </div>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>