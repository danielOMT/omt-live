<?php //template for magazinartikel singles//

use OMT\Model\Comment;
use OMT\View\AuthorView;

$post_id = get_the_ID();
$featured_img_url = get_the_post_thumbnail_url($post_id, 'post-image');
$hero_image = get_field('hero_image');
$zeilen = get_field('zeilen');
$autor = get_field('autor');
$autor = $autor[0];
$autor_helper = get_field('autor');
$titel = get_field('titel', $autor->ID);
$profilbild = get_field('profilbild', $autor->ID);
$firma = get_field('firma', $autor->ID);
$speaker_galerie = get_field('speaker_galerie', $autor->ID);
$beschreibung = get_field('beschreibung', $autor->ID);
$social_media = get_field('social_media', $autor->ID);
$speaker_name = get_the_title($autor->ID);
$inhaltsverzeichnis_deaktivieren = get_field('inhaltsverzeichnis_deaktivieren');
$lesen = 'content';
$schauen = get_field('webinar_id');
$horen = get_field('spotify_id');
?>
<!--<div class="socials-floatbar-left">-->
<!--    --><?php //print do_shortcode('[shariff headline="<p>Artikel teilen:</p>" borderradius="1" services="facebook|twitter|googleplus|linkedin|xing" theme="round" orientation="vertical"]');?>
<!--</div>-->
<?php if (strlen($zeilen[0]['inhaltstyp'][0]['acf_fc_layout'])<2) { // check if this is a regular tool or a page-like build ?>
    <div id="content" xmlns:background="http://www.w3.org/1999/xhtml">
        <?php if (in_array($post_type, ["lexikon", "quicktipps"])) : ?>
            <div class="omt-row hero-header header-flat" style="background: url('<?php echo get_field('header_hero_hintergrundbild')['url'] ?? get_field('standardseite', 'options')['url'] ?>') no-repeat 50% 0;">
                <div class="wrap">
                    <?php
                    $currentyear = date("Y");
                    $h1 = get_the_title();
                    $h1 = str_replace("%%currentyear%%", $currentyear, $h1);
                    ?>
                    <h1 class="mag-title"><?php print $h1; ?></h1>
                </div>
            </div>
        <?php endif ?>

        <div id="inner-content" class="wrap clearfix magazin-single-wrap no-hero">
            <div class="blog-single magazin-single clearfix" role="main">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php /*if (1 != $inhaltsverzeichnis_deaktivieren) { ?>
                        <div class="inhaltsverzeichnis-wrap">
                            <ul class="caret-right inhaltsverzeichnis">
                                <p class="index_header">Inhaltsverzeichnis:</p>
                            </ul>
                        </div>
                    <?php } */?>

                    <?php if (1 != $inhaltsverzeichnis_deaktivieren) {
                        //https://www.codepicky.com/wordpress-table-of-contents/
                        //files: scripts.js, functions.php
                        ?>
                        <div class="inhaltsverzeichnis-wrap inhaltsverzeichnis-index">
                            <ul class="caret-right inhaltsverzeichnis">
                                <p class="index_header">Inhaltsverzeichnis:</p>
                                <?php
                                $tableOfContents = "";
                                $postcontent = get_the_content();
                                $index = 1;
                                // Insert the IDs and create the TOC.
                                $content = preg_replace_callback('#<(h[2-2])(.*?)>(.*?)</\1>#si', function ($matches) use (&$index, &$tableOfContents) {
                                    $tag = $matches[1];
                                    $title = strip_tags($matches[3]);
                                    $hasId = preg_match('/id=(["\'])(.*?)\1[\s>]/si', $matches[2], $matchedIds);
                                    $id = $hasId ? $matchedIds[2] : $index++ . '-' . sanitize_title($title);
                                    if(!strpos($matches[2], "no-ihv")) {
                                        $tableOfContents .= "<li class='item-$tag'><a href='#$id'>$title</a></li>";
                                    }
                                    if ($hasId) {
                                        return $matches[0];
                                    }
                                    return sprintf('<%s%s id="%s">%s</%s>', $tag, $matches[2], $id, $matches[3], $tag);
                                }, $postcontent);
                                $tableOfContents .= '</div>';
                                ?>
                                <?php print $tableOfContents; ?>
                            </ul>
                        </div>
                    <?php } ?>

                    <?php if (!in_array($post_type, ["lexikon", "quicktipps"])) : ?>
                        <img class="article-hero magazin-hero" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $featured_img_url;?>" />
                    <?php endif ?>

                    <article id="post-<?php the_ID(); ?>" class="omt-row template-themenwelt" role="article">
                        <div class="article-header">
                            <?php if (!in_array($post_type, ["lexikon", "quicktipps"])) : ?>
                                <h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
                            <?php endif ?>


                            <div class="info-wrap">
                                <p class="text-red"><strong>Lesezeit: <?php echo reading_time(get_the_ID());?></strong>
                                    <?php if (!in_array($post_type, ["lexikon", "quicktipps"])) : ?>
                                        <span class="artikel-divider">|</span>
                                        <span class="artikel-autor">Autor:
                                        <?php
                                        $i=0;
                                        if (is_array($autor_helper)) {
                                            foreach ($autor_helper as $helper) {
                                                $i++;
                                                if ($i > 1 AND $i != count($autor_helper)) { print ", "; }
                                                if ($i > 1 AND $i == count($autor_helper)) { print " & "; }
                                                ?>
                                                <a target="_blank" href="<?php print get_the_permalink($helper->ID);?>"><?php print get_the_title($helper->ID); ?></a>
                                            <?php } ?>
                                        </span><?php } ?>
                                        <span class="artikel-divider">|</span>
                                        <button
                                                type="button"
                                                onclick="return scrollToCommentsSection()"
                                                class="x-bg-transparent x-border-b x-border-blue-300 x-border-solid x-border-t-0 x-border-l-0 x-border-r-0 x-text-blue x-p-0"
                                        >
                                            <?php echo Comment::init()->count(get_the_ID()) ?> Kommentare
                                        </button>
                                    <?php endif ?>
                                </p>
                                <div class="socials-header"><?php print do_shortcode('[shariff headline="Teile den Artikel" borderradius="1" buttonsize="small" services="facebook|twitter|googleplus|linkedin|xing" theme="round" orientation="horizontal" align="flex-end"]');?></div>
                            </div>
                            <?php if(isset($schauen) && $schauen != '' || isset($horen) && $horen):?>
                                <script>
                                    //changing article content
                                    function articledropdown() {
                                        var value = document.getElementById("article_select").value;
                                        if(value === 'schauen'){
                                            $("#art_content").hide();
                                            $("#soundcloud_content").hide();
                                            $("#webinar_content").show();
                                        }else if(value === 'horen'){
                                            $("#art_content").hide();
                                            $("#soundcloud_content").show();
                                            $("#webinar_content").hide();
                                        }else{
                                            $("#art_content").show();
                                            $("#soundcloud_content").hide();
                                            $("#webinar_content").hide();
                                        }
                                    }
                                </script>
                                <h3 class="article_select_headline">Wie möchtest Du den Artikel konsumieren?</h3>
                                <label class="artikel-select-wrap">
                                    <select id="article_select" onchange="articledropdown()">>
                                        <option value="auswahlen">Bitte auswählen</option>
                                        <option value="Lesen">Artikel Lesen</option>
                                        <?php if(isset($schauen) && $schauen != ''): ?>
                                            <option value="schauen">Video schauen</option>
                                        <?php endif;?>
                                        <?php if(isset($horen) && $horen != ''): ?>
                                            <option value="horen">Tonspur hören</option>
                                        <?php endif;?>
                                    </select>
                                </label>

                            <?php endif;?>
                        </div>
                        <section class="entry-content clearfix inhaltseditor" itemprop="articleBody">
                            <section class="entry-content clearfix" itemprop="articleBody">
                                <div id="art_content">
                                    <?php the_content(); ?>
                                </div>
                                <div id="soundcloud_content" class="hide_article">
                                    <?php echo do_shortcode( '[spotify trackid="'.$horen.'"]' );   ?>
                                </div>
                                <div id="webinar_content" class="hide_article">
                                    <?php echo do_shortcode( '[youtube id="'.$schauen.'"]' );   ?>
                                </div>

                            </section>
                            <div class="wrap socials-after-content">
                                <?php echo do_shortcode('[shariff headline="Teile den Artikel" borderradius="1" buttonsize="small" services="facebook|twitter|googleplus|linkedin|xing" theme="round" orientation="horizontal" align="flex-end"]');?>
                                <div>Wie ist Deine Meinung zu dem Thema? Wir freuen uns über Deinen
                                    <button
                                            type="button"
                                            onclick="return scrollToCommentsSection()"
                                            class="x-bg-transparent x-border-b x-border-blue-300 x-border-solid x-border-t-0 x-border-l-0 x-border-r-0 x-text-blue x-p-0"
                                    >
                                        Kommentar
                                    </button>
                                </div>
                            </div>
                        </section>
                    </article>

                <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <?php //get_sidebar(); ?>
        </div>
        <section class="omt-row color-area-weiss wrap layout-730 ">
            <div class="omt-module card">
                <h2 class="no-ihv">Diesen Artikel bewerten</h2>
                <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
            </div>
        </section>
        <section class="omt-row color-area-weiss wrap layout-730 magazin-newsletter">
            <h3>Willst Du im Online Marketing besser werden?</h3>
            <p>Mit unserem Newsletter schicken wir Dir regelmäßig unsere neusten Webinare und Magazinartikel zu den unterschiedlichen Online Marketing Themen. Mehr als 10.000 Abonnenten nutzen es bereits!</p>
            <!--[if lte IE 8]>
            <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
            <![endif]-->
            <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
            <script>
                hbspt.forms.create({
                    portalId: "3856579",
                    formId: "cfa9a495-893a-469e-8b06-1c5c47244f9f"
                });
            </script>
        </section>
        <section id="post-<?php the_ID(); ?>" class="omt-row wrap autor-wrap">
            <?php if (isset($autor)) {
                if (is_array($autor_helper)) {
                    foreach ($autor_helper as $autor) {
                        $titel = get_field('titel', $autor->ID);
                        $profilbild = get_field('profilbild', $autor->ID);
                        $firma = get_field('firma', $autor->ID);
                        $speaker_galerie = get_field('speaker_galerie', $autor->ID);
                        $beschreibung = get_field('beschreibung', $autor->ID);
                        $social_media = get_field('social_media', $autor->ID);
                        $speaker_name = get_the_title($autor->ID);
                        $social_media = get_field('social_media', $autor->ID);
                        ?>
                        <div class="testimonial card clearfix speakerprofil">
                            <h3 class="experte">
                                <a target="_self" href="<?php print get_the_permalink($autor->ID); ?>"><?php print $speaker_name; ?></a>
                            </h3>
                            <div class="testimonial-img">
                                <a target="_self" href="<?php print get_the_permalink($autor->ID); ?>">
                                    <img
                                            class="teaser-img"
                                            alt="<?php print $speaker_name; ?>"
                                            title="<?php print $speaker_name; ?>"
                                            src="<?php print $profilbild['sizes']['350-180']; ?>"
                                    />
                                </a>
                                <div class="social-media">
                                    <?php
                                    if (is_array($social_media)) {
                                        foreach ($social_media as $social) { ?>
                                            <?php $icon = "fa fa-home"; ?>
                                            <?php if (strpos($social['link'], "facebook") > 0) {
                                                $icon = "fa fa-facebook";
                                            } ?>
                                            <?php if (strpos($social['link'], "xing") > 0) {
                                                $icon = "fa fa-xing";
                                            } ?>
                                            <?php if (strpos($social['link'], "linkedin") > 0) {
                                                $icon = "fa fa-linkedin";
                                            } ?>
                                            <?php if (strpos($social['link'], "twitter") > 0) {
                                                $icon = "fa fa-twitter";
                                            } ?>
                                            <?php if (strpos($social['link'], "instagram") > 0) {
                                                $icon = "fa fa-instagram";
                                            } ?>
                                            <?php if (strpos($social['link'], "google") > 0) {
                                                $icon = "fa fa-google-plus-g";
                                            } ?>
                                            <a target="_blank" class="social-icon" href="<?php echo trim($social['link']) ?>">
                                                <i class="<?php print $icon; ?>"></i>
                                            </a>
                                        <?php }
                                    } ?>
                                </div>
                            </div>
                            <div class="testimonial-text">
                                <?php print $beschreibung; ?>
                            </div>
                        </div>
                    <?php }
                } else {
                    $titel = get_field('titel', $autor->ID);
                    $profilbild = get_field('profilbild', $autor->ID);
                    $firma = get_field('firma', $autor->ID);
                    $speaker_galerie = get_field('speaker_galerie', $autor->ID);
                    $beschreibung = get_field('beschreibung', $autor->ID);
                    $social_media = get_field('social_media', $autor->ID);
                    $speaker_name = get_the_title($autor->ID);
                    $social_media = get_field('social_media', $autor->ID);
                    ?>
                    <div class="testimonial card clearfix speakerprofil">
                        <h3 class="experte">
                            <a target="_self" href="<?php print get_the_permalink($autor->ID); ?>"><?php print $speaker_name; ?></a>
                        </h3>
                        <div class="testimonial-img">
                            <a target="_self" href="<?php print get_the_permalink($autor->ID); ?>">
                                <img
                                        class="teaser-img"
                                        alt="<?php print $speaker_name; ?>"
                                        title="<?php print $speaker_name; ?>"
                                        src="<?php print $profilbild['sizes']['350-180']; ?>"
                                />
                            </a>
                            <div class="social-media">
                                <?php
                                if (is_array($social_media)) {
                                    foreach ($social_media as $social) { ?>
                                        <?php $icon = "fa fa-home"; ?>
                                        <?php if (strpos($social['link'], "facebook") > 0) {
                                            $icon = "fa fa-facebook";
                                        } ?>
                                        <?php if (strpos($social['link'], "xing") > 0) {
                                            $icon = "fa fa-xing";
                                        } ?>
                                        <?php if (strpos($social['link'], "linkedin") > 0) {
                                            $icon = "fa fa-linkedin";
                                        } ?>
                                        <?php if (strpos($social['link'], "twitter") > 0) {
                                            $icon = "fa fa-twitter";
                                        } ?>
                                        <?php if (strpos($social['link'], "instagram") > 0) {
                                            $icon = "fa fa-instagram";
                                        } ?>
                                        <?php if (strpos($social['link'], "google") > 0) {
                                            $icon = "fa fa-google-plus-g";
                                        } ?>
                                        <a target="_blank" class="social-icon" href="<?php echo trim($social['link']) ?>">
                                            <i class="<?php print $icon; ?>"></i>
                                        </a>
                                    <?php }
                                } ?>
                            </div>
                        </div>
                        <div class="testimonial-text">
                            <?php print $beschreibung; ?>
                        </div>
                    </div>
                <?php }

                ?>
            <?php } ?>
        </section>
        <section class="omt-row wrap grid-wrap">
            <?php //related articles ?>
            <?php if (!in_array($post_type, ["lexikon", "quicktipps"])) {?>
                <h3>Weitere interessante Artikel zum Thema:</h3>
                <div class="omt-module artikel-wrap teaser-modul">
                    <?php         $post_type = get_post_type(get_the_ID());
                    require_once (__DIR__ . '/../functions/function-magazin.php');
                    display_magazinartikel(4, $post_type, NULL, false, 1, "teaser-small", false, "", true );
                    ?>
                </div>
                <?php //END OF related articles
                comments_template();
            } else { ?>
                <h3 style="margin-top:60px !important;">Weitere interessante Artikel zum Thema</h3>
                <div class="omt-module artikel-wrap teaser-modul" >
                    <?php         $post_type = "alle";
                    require_once (__DIR__ . '/../functions/function-magazin.php');
                    display_magazinartikel(6, "alle", NULL, false, 1, "teaser-small", false, "", false );
                    ?>
                </div>
            <?php } ?>
        </section>

    </div>
<?php } else { //if we have 1 or more ZEILEN, this is going to be treated as a PAGE:
$header_hero_hintergrundbild = get_field('header_hero_hintergrundbild');
$header_hero_h1 = get_field('header_hero_h1');
$intro_headline = get_field('intro_headline');
$intro_text = get_field('intro_text');
$has_sidebar = get_field('has_sidebar');
$kommentarfunktion_aktivieren = get_field('kommentarfunktion_aktivieren');
$sidebar_welche = get_field('sidebar_welche');
$sticky_button_text = get_field('sticky_button_text');
$sticky_button_link = get_field('sticky_button_link');
$hero_background = get_field('standardseite', 'options');

if (strlen($header_hero_hintergrundbild['url'])>0) { $hero_background = $header_hero_hintergrundbild;}
if (strlen($header_hero_h1)>0) { $h1 = $header_hero_h1;} else { $h1 = get_the_title(); }
?>
<?php if ($has_sidebar != false) {
    $extraclass="has-sidebar";
} else { $extraclass = "fullwidth"; } ?>

<?php $class_themenwelt = " template-themenwelt"; ?>

<div id="content" class="<?php print $extraclass;?>" xmlns:background="http://www.w3.org/1999/xhtml">
    <?php if ( is_singular( array( 'contentagentur', 'cmagentur', 'digitalagentur', 'gaagentur', 'internetagentur', 'omagentur', 'seaagentur', 'seoagentur', 'smagentur', 'webagentur', 'webdesignagentur', 'wpagentur' ) ) ) {
        get_template_part('library/templates/hero-agenturfinder', 'page');
    } else {
        $artikeltyp = "themenwelt";
        ?>
        <div class="omt-row hero-header header-flat" style="background: url('<?php print $hero_background['url'];?>') no-repeat 50% 0;">
            <div class="wrap">
                <h1><?php print $h1;?></h1>
            </div>
        </div>
    <?php } ?>
    <?php if (strlen($sticky_button_text)>0) { ?>
        <p class="button-termine"><a class="button button-red button-730px centered" href="<?php print trim($sticky_button_link) ?>"><?php print $sticky_button_text;?></a></p>
    <?php } ?>
    <?php if (1 != $inhaltsverzeichnis_deaktivieren && strlen($sticky_button_text)<1) { //Inhaltsverzeichnis einblenden, falls Themenwelt Checkbox angeklickt wurde?>
        <div class="omt-row no-margin-bottom">
            <div id="inner-content" class="wrap clearfix magazin-single-wrap  no-hero">
                <div class="inhaltsverzeichnis-wrap">
                    <ul class="caret-right inhaltsverzeichnis">
                        <p class="index_header">Inhaltsverzeichnis:</p>
                    </ul>
                </div>
                <?php if (strlen($featured_img_url)>0) : ?>
                    <img class="article-hero magazin-hero" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $featured_img_url;?>" />
                <?php endif ?>
            </div>
        </div>
    <?php } ?>
    <?php if (strlen($intro_headline) >0 || strlen($intro_text) > 0) { ?>
        <div class="omt-row omt-intro wrap article-header page-intro">
            <?php if (strlen($intro_headline) >0) { ?><h2><?php print $intro_headline;?></h2><?php } ?>
            <?php if (strlen($intro_text) >0) { print $intro_text; } ?>
        </div>
    <?php } ?>

    <?php if ($has_sidebar != false) { ?>
    <div class="clearfix wrap omt-main" role="main">
        <main>
            <?php } ?>

            <?php include('single-as-page-contentparts-main.php'); ?>

            <?php if (in_array($post_type, ['omt_student'])) : ?>
                <?php $postExpert = get_field('experte') ?>

                <?php if ($postExpert && $postExpert->ID) : ?>
                    <section class="omt-row wrap experte-wrap">
                        <?php echo AuthorView::loadTemplate('profile-box', ['author' => $postExpert]) ?>
                    </section>
                <?php endif ?>
            <?php endif ?>

            <?php if ( is_singular( array( 'contentagentur', 'cmagentur', 'digitalagentur', 'gaagentur', 'internetagentur', 'omagentur', 'seaagentur', 'seoagentur', 'smagentur', 'webagentur', 'webdesignagentur', 'wpagentur' ) ) ) {
                get_template_part('library/templates/footer-agenturfinder', 'page');
            } ?>
            <?php if (1 == $kommentarfunktion_aktivieren) { ?>
                <section class="omt-row color-area-weiss">
                    <?php if (!in_array($post_type, ["lexikon", "quicktipps"])) {
                        comments_template();
                    }
                    ?>
                </section>
            <?php } ?>

            <?php if ( is_singular( array( 'lexikon', 'quicktipps', 'affiliate', 'amazon', 'amazon_marketing', 'content', 'conversion', 'direktmarketing', 'emailmarketing', 'facebook', 'sea', 'sma', 'ga', 'gmb', 'growthhack', 'inbound', 'influencer', 'links', 'local', 'marketing', 'onlinemarketing', 'pinterest', 'p_r', 'social', 'seo', 'tiktok', 'videomarketing', 'webanalyse', 'webdesign', 'wordpress' ) ) ) { ?>
                <section class="omt-row color-area-weiss wrap layout-730 ">
                    <div class="omt-module card">
                        <h2 class="no-ihv">Diesen Artikel bewerten</h2>
                        <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                    </div>
                </section>
                <section id="post-<?php the_ID(); ?>" class="omt-row wrap autor-wrap">
                    <?php if (isset($autor)) {
                        if (is_array($autor_helper)) {
                            foreach ($autor_helper as $autor) {
                                $titel = get_field('titel', $autor->ID);
                                $profilbild = get_field('profilbild', $autor->ID);
                                $firma = get_field('firma', $autor->ID);
                                $speaker_galerie = get_field('speaker_galerie', $autor->ID);
                                $beschreibung = get_field('beschreibung', $autor->ID);
                                $social_media = get_field('social_media', $autor->ID);
                                $speaker_name = get_the_title($autor->ID);
                                $social_media = get_field('social_media', $autor->ID);
                                ?>
                                <div class="testimonial card clearfix speakerprofil">
                                    <h3 class="experte">
                                        <a target="_self" href="<?php print get_the_permalink($autor->ID); ?>"><?php print $speaker_name; ?></a>
                                    </h3>
                                    <div class="testimonial-img">
                                        <a target="_self" href="<?php print get_the_permalink($autor->ID); ?>">
                                            <img
                                                    class="teaser-img"
                                                    alt="<?php print $speaker_name; ?>"
                                                    title="<?php print $speaker_name; ?>"
                                                    src="<?php print $profilbild['sizes']['350-180']; ?>"
                                            />
                                        </a>
                                        <div class="social-media">
                                            <?php
                                            if (is_array($social_media)) {
                                                foreach ($social_media as $social) { ?>
                                                    <?php $icon = "fa fa-home"; ?>
                                                    <?php if (strpos($social['link'], "facebook") > 0) {
                                                        $icon = "fa fa-facebook";
                                                    } ?>
                                                    <?php if (strpos($social['link'], "xing") > 0) {
                                                        $icon = "fa fa-xing";
                                                    } ?>
                                                    <?php if (strpos($social['link'], "linkedin") > 0) {
                                                        $icon = "fa fa-linkedin";
                                                    } ?>
                                                    <?php if (strpos($social['link'], "twitter") > 0) {
                                                        $icon = "fa fa-twitter";
                                                    } ?>
                                                    <?php if (strpos($social['link'], "instagram") > 0) {
                                                        $icon = "fa fa-instagram";
                                                    } ?>
                                                    <?php if (strpos($social['link'], "google") > 0) {
                                                        $icon = "fa fa-google-plus-g";
                                                    } ?>
                                                    <a target="_blank" class="social-icon" href="<?php echo trim($social['link']) ?>">
                                                        <i class="<?php print $icon; ?>"></i>
                                                    </a>
                                                <?php }
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="testimonial-text">
                                        <?php print $beschreibung; ?>
                                    </div>
                                </div>
                            <?php }
                        } else {
                            $titel = get_field('titel', $autor->ID);
                            $profilbild = get_field('profilbild', $autor->ID);
                            $firma = get_field('firma', $autor->ID);
                            $speaker_galerie = get_field('speaker_galerie', $autor->ID);
                            $beschreibung = get_field('beschreibung', $autor->ID);
                            $social_media = get_field('social_media', $autor->ID);
                            $speaker_name = get_the_title($autor->ID);
                            $social_media = get_field('social_media', $autor->ID);
                            ?>
                            <div class="testimonial card clearfix speakerprofil">
                                <h3 class="experte">
                                    <a target="_self" href="<?php print get_the_permalink($autor->ID); ?>"><?php print $speaker_name; ?></a>
                                </h3>
                                <div class="testimonial-img">
                                    <a target="_self" href="<?php print get_the_permalink($autor->ID); ?>">
                                        <img
                                                class="teaser-img"
                                                alt="<?php print $speaker_name; ?>"
                                                title="<?php print $speaker_name; ?>"
                                                src="<?php print $profilbild['sizes']['350-180']; ?>"
                                        />
                                    </a>
                                    <div class="social-media">
                                        <?php
                                        if (is_array($social_media)) {
                                            foreach ($social_media as $social) { ?>
                                                <?php $icon = "fa fa-home"; ?>
                                                <?php if (strpos($social['link'], "facebook") > 0) {
                                                    $icon = "fa fa-facebook";
                                                } ?>
                                                <?php if (strpos($social['link'], "xing") > 0) {
                                                    $icon = "fa fa-xing";
                                                } ?>
                                                <?php if (strpos($social['link'], "linkedin") > 0) {
                                                    $icon = "fa fa-linkedin";
                                                } ?>
                                                <?php if (strpos($social['link'], "twitter") > 0) {
                                                    $icon = "fa fa-twitter";
                                                } ?>
                                                <?php if (strpos($social['link'], "instagram") > 0) {
                                                    $icon = "fa fa-instagram";
                                                } ?>
                                                <?php if (strpos($social['link'], "google") > 0) {
                                                    $icon = "fa fa-google-plus-g";
                                                } ?>
                                                <a target="_blank" class="social-icon" href="<?php echo trim($social['link']) ?>">
                                                    <i class="<?php print $icon; ?>"></i>
                                                </a>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                                <div class="testimonial-text">
                                    <?php print $beschreibung; ?>
                                </div>
                            </div>
                        <?php }

                        ?>
                    <?php } ?>
                </section>
                <section class="omt-row wrap grid-wrap">
                    <?php //related articles ?>
                    <h3>Weitere interessante Artikel</h3>
                    <div class="omt-module artikel-wrap teaser-modul">
                        <?php         $post_type = get_post_type(get_the_ID());
                        require_once (__DIR__ . '/../functions/function-magazin.php');
                        display_magazinartikel(6, "alle", NULL, false, 1, "teaser-small", false, "", false );
                        ?>
                    </div>
                    <?php //END OF related articles ?>
                    <?php if (!in_array($post_type, ["lexikon", "quicktipps"])) {
                        comments_template();
                    } ?>
                </section>
            <?php } ?>
            <?php } ?>

    </div> <?php //end of #content ?>
    <div class="socials-floatbar-mobile">
        <?php echo do_shortcode('[shariff services="facebook|twitter|googleplus|linkedin|xing" backend="on" lang="de" theme="round" borderradius="1" buttonstretch="1"]'); ?>
    </div>
    <?php get_footer(); ?>
