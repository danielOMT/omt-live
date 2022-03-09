<?php

use OMT\Model\Datahost\Article;
use OMT\View\ArticleView;

$format = $zeile['inhaltstyp'][0]['format'];
        if (strlen($format)<1) { $format = "teaser-small"; }
        if (is_array($zeile['inhaltstyp'][0]['artikel'])) { $count = count($zeile['inhaltstyp'][0]['artikel']); }
        $first_id = $zeile['inhaltstyp'][0]['artikel'][0]['artikel']->ID;
        $kategorien = $zeile['inhaltstyp'][0]['artikelkategorie'];
        if (is_array($kategorien)) {
            if (count($kategorien)<2) {
                $kategorie = $kategorien[0];
            }
        } else {
            if (strlen($kategorie) < 2) {
                $kategorie = $kategorien;
            }
        }

        if (is_array($kategorien)) {
            if (count($kategorien) > 1) {
                $kategorie = "";
                foreach ($kategorien as $item) {
                    $kategorie .= $item . "|";
                }
            }
        }

        if ($count <= 1 && strlen($first_id) < 1) {
            if (USE_JSON_POSTS_SYNC) {
                require_once ( get_template_directory() . '/library/functions/json-magazin/json-magazin-alle.php');
                require_once ( get_template_directory() . '/library/functions/function-magazin.php');
                display_magazinartikel_json(99999, $kategorie, NULL, false, 1, $format);
            } else {
                $filters = [];
                if (!in_array('alle', (array) $kategorien) && count(array_filter((array) $kategorien))) {
                    $filters['postType'] = array_filter((array) $kategorien);
                }

                $options = [
                    'order' => 'post_date',
                    'order_dir' => 'DESC',
                    'with' => ['experts']
                ];

                echo ArticleView::loadTemplate('items', [
                    'articles' => Article::init()->activeItems($filters, $options),
                    'format' => $format,
                    'highlightFirst' => true
                ]);
            }
        }

        if (is_array($zeile['inhaltstyp'][0]['artikel'])) {
            foreach ($zeile['inhaltstyp'][0]['artikel'] as $artikel) {
                $artikel_id = $artikel['artikel']->ID;
                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($artikel_id), '350-180');
                $image = $featured_image[0];
                $post_type = get_post_type($artikel_id);
                $post_type_nice = "";
                $autor = get_field('autor', $artikel_id);
                $autor_helper = get_field('autor', $artikel_id);
                $autor = $autor[0];
                $featured_image_teaser = wp_get_attachment_image_src(get_post_thumbnail_id($artikel_id), '350-180');
                $featured_image_highlight = wp_get_attachment_image_src(get_post_thumbnail_id($artikel_id), '550-290');
                $image_teaser = $featured_image_teaser[0];
                $image_highlight = $featured_image_highlight[0];
                $vorschau_350 = get_field('vorschau-350x180', $id);
                if (strlen($vorschau_350['url']) > 0) {
                    $image_teaser = $vorschau_350['url'];
                }
                $vorschau_550 = get_field('vorschau-550-290', $id);
                if (strlen($vorschau_550['url']) > 0) {
                    $image_highlight = $vorschau_550['url'];
                }
                $vorschautext = get_field('vorschautext', $artikel_id);
                $image_overlay = "/uploads/omt-banner-overlay-350.png";
                $artikelkategorie = get_field('artikelkategorie', $artikel_id);
                if ("teaser-medium" == $format) {
                    $image_teaser = $image_highlight;
                    $image_overlay = "/uploads/omt-banner-overlay-550.png";
                }

                switch ($post_type) {
                    case "magazin": $post_type_nice = "Magazin"; break;
                    case "seo": $post_type_nice = "Suchmaschinenoptimierung"; break;
                    case "sea": $post_type_nice = "Google Ads"; break;
                    case "links": $post_type_nice = "Linkbuilding"; break;
                    case "ga": $post_type_nice = "Google Analytics"; break;
                    case "gmb": $post_type_nice = "Google My Business"; break;
                    case "content": $post_type_nice = "Content Marketing"; break;
                    case "e-commerce": $post_type_nice = "E-Commerce"; break;
                    case "emailmarketing": $post_type_nice = "E-Mail Marketing"; break;
                    case "social": $post_type_nice = "Social Media Marketing"; break;
                    case "facebook": $post_type_nice = "Facebook Ads"; break;
                    case "affiliate": $post_type_nice = "Affiliate Marketing"; break;
                    case "conversion": $post_type_nice = "Conversion Optimierung"; break;
                    case "direktmarketing": $post_type_nice = "Direktmarketing"; break;
                    case "growthhack": $post_type_nice = "Growth Hacking"; break;
                    case "amazon": $post_type_nice = "Amazon SEO"; break;
                    case "amazon_marketing": $post_type_nice = "Amazon Marketing"; break;
                    case "local": $post_type_nice = "Local SEO"; break;
                    case "onlinemarketing": $post_type_nice = "Online Marketing"; break;
                    case "webanalyse": $post_type_nice = "Webanalyse"; break;
                    case "inbound": $post_type_nice = "Inbound Marketing"; break;
                    case "influencer": $post_type_nice = "Influencer Marketing"; break;
                    case "marketing": $post_type_nice = "Marketing"; break;
                    case "videomarketing": $post_type_nice = "Video Marketing"; break;
                    case "performance": $post_type_nice = "Performance Marketing"; break;
                    case "pinterest": $post_type_nice = "Pinterest Marketing"; break;
                    case "pagespeed": $post_type_nice = "Wordpress Pagespeed"; break;
                    case "plugins": $post_type_nice = "Wordpress Plugins"; break;
                    case "p_r": $post_type_nice = "PR"; break;
                    case "tiktok": $post_type_nice = "TikTok-Marketing"; break;
                    case "wordpress": $post_type_nice = "Wordpress"; break;
                    case "webdesign": $post_type_nice = "Webdesign"; break;
                }
                $title = get_the_title($artikel_id);
                $webinar_shorttitle = implode(' ', array_slice(explode(' ', $title), 0, 7));
                $wordcount = str_word_count($title);
                $post_type_data = get_post_type_object($post_type);
                $post_type_slug = $post_type_data->rewrite['slug'];
                if ($wordcount > 7) {
                    $title = $webinar_shorttitle . "...";
                }
                ?>
                <div class="teaser <?php print $format; ?> teaser-matchbuttons">
                    <div class="teaser-image-wrap" style="">
                        <img class="webinar-image teaser-img"
                             alt="<?php print get_the_title($artikel_id); ?>"
                             title="<?php print get_the_title($artikel_id); ?>"
                             srcset="
            <?php print $image_teaser;?> 480w,
            <?php print $image_teaser;?> 800w,
            <?php print $image_highlight;?> 1400w"
                             sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                             src="<?php print $image_highlight;?>"
                        />
                        <img alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay"
                             src="<?php print $image_overlay; ?>" style="">
                    </div>
                    <h2 class="h4 article-title no-ihv"><a href="<?php the_permalink($artikel_id) ?>"
                                                           title="<?php the_title_attribute($artikel_id); ?>"><?php print $title; ?></a>
                    </h2>
                    <?php $compare_slug = "https://www.omt.de/" . $post_type_slug . "/";
                    if ($compare_slug == get_the_permalink()) { ?>
                        <span class="teaser-cat category-link"><?php print $post_type_nice; ?></span>
                    <?php } else { ?>
                        <a class="teaser-cat category-link"
                           href="/<?php print $post_type_slug; ?>/"><?php print $post_type_nice; ?></a>
                    <?php } ?>
                    <p class="experte no-margin-top no-margin-bottom">
                        <?php
                        $i = 0;
                        foreach ($autor_helper as $helper) {
                            $i++;
                            if ($i > 1 AND $i != count($autor_helper)) {
                                print ", ";
                            }
                            if ($i > 1 AND $i == count($autor_helper)) {
                                print " & ";
                            }
                            ?>
                            <a target="_self"
                               href="<?php print get_the_permalink($helper->ID); ?>"><?php print get_the_title($helper->ID); ?></a>
                        <?php } ?>
                        <span style="float:right;"><i class="fa fa-clock-o"
                                                      style="vertical-align:middle;"></i> <?php echo reading_time($artikel_id); ?></span>
                    </p>
                    <?php if ("teaser-medium" == $format) { ?>
                        <div class="vorschautext">
                            <?php print strip_tags(substr($vorschautext, 0, 200));
                            if (strlen($vorschautext) > 200) {
                                print "...";
                            } ?>
                        </div>
                    <?php } ?>
                    <?php /*<a class="button" href="<?php the_permalink($artikel_id)?>" title="<?php the_title_attribute($artikel_id); ?>">Artikel lesen</a>*/ ?>
                </div>
            <?php }
        } ?>