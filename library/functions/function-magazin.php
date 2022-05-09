<?php
/**
Function to Display Webinare by Parameters given from user.
 * Params:
 * Anzahl
 * Title_only?
 * Kategorie
 * Autor
 * Status (zukünftige, vergangene, alle)
 */

function display_magazinartikel(int $anzahl = 12, string $kategorie="alle", int $autor_id=NULL, bool $countonly = false, int $ab_x = 1, string $format = "teaser-small", bool $agenturfinder = false, string $multiautor = "", bool $highlightfirst = true ) {
    //*******************WEBINARE LOGIK VOM ALTEN OMT START*********************// ?>
    <?php
    /**  if ($kategorie_id != NULL) {
    $tax_query[] =  array(
    'taxonomy' => 'kategorie',
    'field' => 'id',
    'terms' => $kategorie_id
    );
    }*/
    if (strpos($kategorie, "|" )>0) {
        $kategorie = substr($kategorie, 0, -1);
        $kategorie = explode("|", $kategorie);
    }


    if (strpos($multiautor, "|" )>0) {
        $manyauthors = 1;
        $multiautor = substr($multiautor, 0, -1);
        $multiautor = explode("|", $multiautor);
    } else { $manyauthors = 0; }

    if ($kategorie == "alle") {
        $post_types = array('magazin', 'seo', 'sea', 'sma', 'links', 'ga', 'content', 'social', 'facebook', 'affiliate', 'conversion', 'growthhack', 'amazon', 'amazon_marketing', 'local', 'webanalyse', 'onlinemarketing', 'inbound', 'influencer', 'videomarketing', 'pinterest', 'pagespeed', 'plugins', 'emailmarketing', 'wordpress');
    }  else {
        $post_types = $kategorie;
    }
    if ($autor_id != NULL) { //falls autorenspezifische magazinartikel nicht ausgegeben werden: es MUSS jeder Artikel nochmal neu gespeichert werden (ab Einfügen des entsprechenden Checkbox-Fields), damit diese hier angezeigt werden.
        $meta_query[] = array(
            'relation' => 'AND', // Optional, defaults to "AND",
            array(
                'key' => 'autor',
                'value' => $autor_id,
                'compare' => 'LIKE'
            ),
            array(
                'relation' => 'OR', // Optional, defaults to "AND",
                array(
                    'key' => 'recap',
                    'value' => 1,
                    'compare' => 'NOT EXISTS'
                ),
                array(
                    'key' => 'recap',
                    'value' => 1,
                    'compare' => '!='
                )
            )
        );
    } else {
        $meta_query[] = array(
            'relation' => 'OR', // Optional, defaults to "AND",
            array(
                'key' => 'recap',
                'value' => 1,
                'compare' => 'NOT EXISTS'
            ),
            array(
                'key' => 'recap',
                'value' => 1,
                'compare' => '!='
            )
        );
    }
    $recap_meta_query[] = array(
        'relation' => 'OR', // Optional, defaults to "AND",
        array(
            'key' => 'recap',
            'value' => 1,
            'compare' => 'NOT EXISTS'
        ),
        array(
            'key' => 'recap',
            'value' => 1,
            'compare' => '!='
        )
    );
    if ($ab_x <=1) { $ab_x = 1; }
    $anzahl = $anzahl + $ab_x-1;
    $currentID = get_the_ID();
    $args = array( //next
        'posts_per_page'    => $anzahl,
        'post_type'         => $post_types,
        'posts_status'    => "publish",
        'order'				=> 'DESC',
        'orderby'			=> 'date',
        'meta_query'		=> $meta_query,
        //'meta_key'	        => 'webinar_datum',
        //'meta_type'			=> 'DATETIME',
        //'tax_query'         => $tax_query,
        'post__not_in' => array($currentID)
    );
    $magazin_count = 0;
    $loop = new WP_Query( $args );
    $current_page_id = get_the_ID();
    while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <?php
        $agenturfinder_artikel = get_field('im_agenturfinder_anzeigen');
        if (($agenturfinder == false) OR ($agenturfinder == true AND $agenturfinder_artikel == 1)) {
            $id = get_the_ID();
            $featured_image_teaser = wp_get_attachment_image_src( get_post_thumbnail_id($id), '350-180' );
            $featured_image_highlight = wp_get_attachment_image_src( get_post_thumbnail_id($id), '550-290' );
            $image_teaser = $featured_image_teaser[0];
            $image_highlight = $featured_image_highlight[0];
            $vorschau_350 = get_field('vorschau-350x180', $id);
            if (strlen($vorschau_350['url'])>0) { $image_teaser = $vorschau_350['url']; }
            $vorschau_550 = get_field('vorschau-550-290', $id);
            if (strlen($vorschau_550['url'])>0) { $image_highlight = $vorschau_550['url']; }
            $post_type = get_post_type($id);
            $post_type_nice = "";
            $autor = get_field('autor', $id);
            $autor_helper = get_field('autor', $id);
            $i=0;

            if (1 == $manyauthors) {
                $autor_id = $multiautor[0];
                foreach ($multiautor as $helper) {
                    $multiautor_id = $helper;
                    foreach ($autor_helper as $helper2) {
                        if ( $helper2->ID == $multiautor_id ) { $autor = $autor_id;}
                    }
                }
            } else {
                if (is_array($autor_helper)) {
                    foreach ($autor_helper as $helper) {
                        if ($helper->ID == $autor_id) {
                            $autor[0] = $autor_id;
                        }
                    }
                }
                $autor = $autor[0]; }
            if ($autor_id == NULL OR $autor == $autor_id) {
                switch ($post_type) {
                    case "magazin": $post_type_nice = "Magazin"; break;
                    case "seo": $post_type_nice = "Suchmaschinenoptimierung"; break;
                    case "sea": $post_type_nice = "Google Ads"; break;
                    case "sma": $post_type_nice = "Suchmaschinenmarketing"; break;
                    case "links": $post_type_nice = "Linkbuilding"; break;
                    case "ga": $post_type_nice = "Google Analytics"; break;
                    case "content": $post_type_nice = "Content Marketing"; break;
                    case "emailmarketing": $post_type_nice = "E-Mail Marketing"; break;
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
                    case "inbound": $post_type_nice = "Inbound Marketing"; break;
                    case "influencer": $post_type_nice = "Influencer Marketing"; break;
                    case "videomarketing": $post_type_nice = "Video Marketing"; break;
                    case "pinterest": $post_type_nice = "Pinterest Marketing"; break;
                    case "pagespeed": $post_type_nice = "Wordpress Pagespeed"; break;
                    case "plugins": $post_type_nice = "Wordpress Plugins"; break;
                    case "wordpress": $post_type_nice = "WordPress"; break;
                    case "lexikon": $post_type_nice = "Lexikon"; break;
                    case "quicktipps": $post_type_nice = "Quicktipps"; break;
                }
                $title = get_the_title();
                if (strlen($title)>70) { $title = substr($title, 0, 70) . "..."; } ;
                //$webinar_shorttitle = implode(' ', array_slice(explode(' ', $title), 0, 7));
                //$wordcount = str_word_count($title);
                //if ($wordcount > 7) { $title = $webinar_shorttitle . "..."; }
                $post_type_data = get_post_type_object( $post_type );
                $post_type_slug = $post_type_data->rewrite['slug'];
                if ("wordpress" == $post_type_slug) { $post_type_slug = "online-marketing-tools/wordpress"; }
                if ("google-analytics" == $post_type_slug) { $post_type_slug = "online-marketing-tools/google-analytics"; }
                ?>
                <?php if ($countonly == false AND $magazin_count>=$ab_x-1 AND $format != "teaser-medium") { ?>
                    <?php if ( (true == $highlightfirst) AND (0 == $magazin_count or $ab_x-1 == $magazin_count) ) { ?>
                        <div class="teaser-modul-highlight">
                            <div class="teaser-image-wrap" style="">
                                <img class="teaser-img" alt="<?php the_title();?>" title="<?php the_title();?>" src="<?php print $image_highlight;?>"/>
                                <img alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-550.png" style="">
                            </div>
                            <div class="textarea">
                                <h2 class="h4 no-margin-bottom no-ihv">
                                    <a href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>"><?php print $title; ?></a>
                                    <?php $compare_slug = "https://www.omt.de/" . $post_type_slug . "/";
                                    if ($compare_slug == get_the_permalink($current_page_id)) { ?>
                                        <span class="has-margin-top-30 no-margin-bottom is-size-20 block category-link"><?php print $post_type_nice;?></span>
                                    <?php } else { ?>
                                        <a class="has-margin-top-30 no-margin-bottom is-size-20 block category-link" href="/<?php print $post_type_slug;?>/"><?php print $post_type_nice;?></a>
                                    <?php } ?>
                                </h2>
                                <p class="experte no-margin-top">
                                    <?php
                                    $i=0;
                                    if (is_array($autor_helper)) {
                                    foreach ($autor_helper as $helper) {
                                        $i++;
                                        if ($i > 1 AND $i != count($autor_helper)) { print ", "; }
                                        if ($i > 1 AND $i == count($autor_helper)) { print " & "; }
                                        ?>
                                        <?php if ( get_the_permalink($helper->ID) == get_the_permalink($current_page_id)) { ?>
                                            <span><?php print get_the_title($helper->ID); ?></span>
                                        <?php } else { ?>
                                            <a target="_self" href="<?php print get_the_permalink($helper->ID);?>"><?php print get_the_title($helper->ID); ?></a>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                    <span style="float:right;"><i class="fa fa-clock-o" style="vertical-align:middle;"></i> <?php echo reading_time($id);?></span>
                                </p>
                                <?php if (has_excerpt()) { the_excerpt(); } else {
                                    generate_excerpt_magazin(get_the_content($id));
                                } ?>...
                                <?php /*<a class="button has-margin-top-30" href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>">Artikel lesen</a>*/?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ( (false == $highlightfirst) OR (0 != $magazin_count AND $ab_x-1 != $magazin_count ) ) { ?>
                        <div class="teaser teaser-small teaser-matchbuttons">
                            <div class="teaser-image-wrap" style="">
                                <img class="webinar-image teaser-img <?php if (in_array($post_type, ["lexikon", "quicktipps"])) {print "lexikon-img"; } ?>" alt="<?php the_title();?>" title="<?php the_title();?>" src="<?php print $image_teaser;?>"/>
                                <img alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png">
                            </div>
                            <h2 class="h4 article-title no-ihv <?php if (in_array($post_type, ["lexikon", "quicktipps"])) {print "lexikon-title"; } ?>"><a href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>"><?php print $title; ?></a></h2>
                            <?php $compare_slug = "https://www.omt.de/" . $post_type_slug . "/";
                            if ($compare_slug == get_the_permalink($current_page_id)) { ?>
                                <span class="teaser-cat category-link"><?php print $post_type_nice;?></span>
                            <?php } else { ?>
                                <a class="teaser-cat category-link" href="/<?php print $post_type_slug;?>/"><?php print $post_type_nice;?></a>
                            <?php } ?>
                            <p class="experte no-margin-top no-margin-bottom">
                                <?php
                                if (!in_array($post_type, ["lexikon", "quicktipps"])) {
                                $i=0;
                                if (is_array($autor_helper)) {
                                    foreach ($autor_helper as $helper) {
                                        $i++;
                                        if ($i > 1 AND $i != count($autor_helper)) {
                                            print ", ";
                                        }
                                        if ($i > 1 AND $i == count($autor_helper)) {
                                            print " & ";
                                        }
                                        ?>
                                        <?php if (get_the_permalink($helper->ID) == get_the_permalink($current_page_id)) { ?>
                                            <span><?php print get_the_title($helper->ID); ?></span>
                                        <?php } else { ?>
                                            <a target="_self"
                                               href="<?php print get_the_permalink($helper->ID); ?>"><?php print get_the_title($helper->ID); ?></a>
                                        <?php } ?>
                                    <?php }
                                }
                                ?>
                                <span style="float:right;"><i class="fa fa-clock-o" style="vertical-align:middle;"></i> <?php echo reading_time($id);?></span>
                                    <?php }
                                if (in_array($post_type, ["lexikon", "quicktipps"])) {
                                    $vorschautext = get_field('vorschautext');
                                    print $vorschautext;
                                } ?>
                            </p>
                            <?php /*<a class="button" href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>">Artikel lesen</a>*/?>
                        </div>
                    <?php } ?>
                <?php } //end of displaying in teaser small format ?>
                <?php //if format = teaser-medium:
                if ("teaser-medium" == $format) {
                    $vorschautext = get_field('vorschautext');
                    $featured_image_teaser = wp_get_attachment_image_src( get_post_thumbnail_id($id), '350-180' );
                    $featured_image_highlight = wp_get_attachment_image_src( get_post_thumbnail_id($id), '550-290' );
                    $image_teaser = $featured_image_highlight[0];
                    $image_highlight = $featured_image_highlight[0];
                    $vorschautext = get_field('vorschautext', $id);
                    $image_overlay  = "/uploads/omt-banner-overlay-550.png";
                    ?>
                    <div class="teaser <?php print $format;?> teaser-matchbuttons">
                        <div class="teaser-image-wrap" style="">
                            <img class="webinar-image teaser-img" alt="<?php print get_the_title($id);?>" title="<?php print get_the_title($id);?>" src="<?php print $image_teaser;?>"/>
                            <img alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay" src="<?php print $image_overlay;?>" style="">
                        </div>
                        <h2 class="h4 article-title no-ihv"><a href="<?php the_permalink($id)?>" title="<?php the_title_attribute($id); ?>"><?php print $title; ?></a></h2>
                        <?php $compare_slug = "https://www.omt.de/" . $post_type_slug . "/";
                        if ($compare_slug == get_the_permalink($current_page_id)) { ?>
                            <span class="teaser-cat category-link"><?php print $post_type_nice;?></span>
                        <?php } else { ?>
                            <a class="teaser-cat category-link" href="/<?php print $post_type_slug;?>/"><?php print $post_type_nice;?></a>
                        <?php } ?>
                        <p class="experte no-margin-top no-margin-bottom">
                            <?php
                            $i=0;
                            foreach ($autor_helper as $helper) {
                                $i++;
                                if ($i > 1 AND $i != count($autor_helper)) { print ", "; }
                                if ($i > 1 AND $i == count($autor_helper)) { print " & "; }
                                ?>
                                <?php if ( get_the_permalink($helper->ID) == get_the_permalink($current_page_id)) { ?>
                                    <span><?php print get_the_title($helper->ID); ?></span>
                                <?php } else { ?>
                                    <a target="_self" href="<?php print get_the_permalink($helper->ID);?>"><?php print get_the_title($helper->ID); ?></a>
                                <?php } ?>
                            <?php } ?>
                            <span style="float:right;"><i class="fa fa-clock-o" style="vertical-align:middle;"></i> <?php echo reading_time($id);?></span>
                        </p>
                        <?php if ("teaser-medium" == $format) { ?>
                            <div class="vorschautext">
                                <?php print strip_tags(substr($vorschautext, 0, 200));
                                if (strlen($vorschautext)>200) { print "..."; } ?>
                            </div>
                        <?php } ?>
                        <?php /*<a class="button" href="<?php the_permalink($id)?>" title="<?php the_title_attribute($id); ?>">Artikel lesen</a>*/?>
                    </div>
                <?php } ?>
                <?php $magazin_count++;?>
            <?php } ?>
        <?php } ?>
    <?php endwhile; //end
    wp_reset_postdata();?>

    <?php

    return $magazin_count;
}