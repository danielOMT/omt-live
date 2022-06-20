<?php

use OMT\Model\Datahost\Article;
use OMT\Model\Datahost\Webinar;
use OMT\Services\WebinarsFilter;
use OMT\Services\ArraySort;
use OMT\View\ArticleView;
use OMT\View\WebinarView;

?>
<?php get_header(); ?>
<?php
require_once('library/functions/show-readmore-acf.php');
require_once ('library/functions/function-seminare.php');
require_once ('library/functions/function-webinare.php');
require_once ('library/functions/json-webinare/json-webinare-alle.php');
require_once ('library/functions/function-magazin.php');
require_once ('library/functions/json-magazin/json-magazin-alle.php');
require_once ('library/functions/function-podcasts.php');
require_once ('library/functions/json-podcasts/json-podcasts-alle.php');
$name = get_the_title();
$logo = get_field('logo');
$agentur_ID = get_the_ID();
$logo_aus_formular = get_field('logo_attachment');
if (strlen($logo_aus_formular)>0) {
    $logo['url'] = $logo_aus_formular;
    $logo['sizes']['350-180'] = $logo_aus_formular;
    $logo['sizes']['350-180'] = $logo_aus_formular;
}
$agentur_mitarbeiter = get_field('agentur_mitarbeiter');
$einzugsgebiet_orte = get_field('einzugsgebiet_orte');
$beschreibung = get_field('beschreibung');
$agentur_email = get_field('agentur_email');
$anzahl_der_mitarbeiter = get_field('anzahl_der_mitarbeiter');
$agentur_telefonnummer = get_field('agentur_telefonnummer');
$google_maps_adresse = get_field('google_maps_adresse');
$adresse_strasse = get_field('adresse_strasse');
$adresse_plz = get_field('adresse_plz');
$adresse_stadt = get_field('adresse_stadt');
$branchen = get_field('branchen');
$services = get_field('services');
$angestrebtes_mindestbudget = get_field('angestrebtes_mindestbudget');
$mindestmediabudget = get_field('mindestmediabudget');
$agentur_ansprechpartner = get_field('agentur_ansprechpartner');
$agentur_ansprechpartner_email = get_field('agentur_ansprechpartner_email');
$agentur_ansprechpartner_profilbild = get_field('agentur_ansprechpartner_profilbild');
$agentur_ansprechpartner_auswahlfeld = get_field('agentur_ansprechpartner_auswahlfeld');
$ansprechpartner_attachment = get_field('ansprechpartner_attachment');
if (strlen($ansprechpartner_attachment)>0) {
    $agentur_ansprechpartner_profilbild['url'] = $ansprechpartner_attachment;
    $agentur_ansprechpartner_profilbild['sizes']['350-180'] = $ansprechpartner_attachment;
    $agentur_ansprechpartner_profilbild['sizes']['350-180'] = $ansprechpartner_attachment;
    $agentur_ansprechpartner_profilbild['sizes']['350-180'] = $ansprechpartner_attachment;
}
$homepage = get_field('homepage');
$facebook = get_field('facebook');
$linkedin_profil = get_field('linkedin_profil');
$instagram = get_field('instagram');
$instagram_profil_2 = get_field('instagram_profil_2');
$youtube = get_field('youtube');
$xing = get_field('xing');
$snapchat = get_field('snapchat');
$twitter = get_field('twitter_profil');
$videos = get_field('videos');
$erfolge = get_field('erfolge');
$zertifikat_1_titel = get_field('zertifikat_1_titel');
$zertifikat_2_titel = get_field('zertifikat_2_titel');
$zertifikat_3_titel = get_field('zertifikat_3_titel');
$zertifikat_4_titel = get_field('zertifikat_4_titel');
$zertifikat_1_bild = get_field('zertifikat_1_bild');
$zertifikat_2_bild = get_field('zertifikat_2_bild');
$zertifikat_3_bild = get_field('zertifikat_3_bild');
$zertifikat_4_bild = get_field('zertifikat_4_bild');
$zertifikat_1_bild_formularfeld = get_field('zertifikat_1_bild_formularfeld');
$zertifikat_2_bild_formularfeld = get_field('zertifikat_2_bild_formularfeld');
$zertifikat_3_bild_formularfeld = get_field('zertifikat_3_bild_formularfeld');
$zertifikat_4_bild_formularfeld = get_field('zertifikat_4_bild_formularfeld');
$zertifikat_1_beschreibung = get_field('zertifikat_1_beschreibung');
$zertifikat_2_beschreibung = get_field('zertifikat_2_beschreibung');
$zertifikat_3_beschreibung = get_field('zertifikat_3_beschreibung');
$zertifikat_4_beschreibung = get_field('zertifikat_4_beschreibung');

if (!defined('USE_JSON_POSTS_SYNC') || USE_JSON_POSTS_SYNC === false) {
    if (count(array_filter((array) $agentur_mitarbeiter))) {
        $agencyExpertsIds = array_map(fn ($expert) => $expert->ID, $agentur_mitarbeiter);
        $agencyWebinars = Webinar::init()->activeItems(['expert' => $agencyExpertsIds], ['with' => 'experts']);
        $agencyArticles = Article::init()->activeItems(['expert' => $agencyExpertsIds], [
            'order' => 'post_date',
            'order_dir' => 'DESC',
            'with' => ['experts']
        ]);
    
        $agencyWebinars = [
            ...ArraySort::byDateAsc(WebinarsFilter::upcoming($agencyWebinars)),
            ...ArraySort::byDateDesc(WebinarsFilter::past($agencyWebinars))
        ];
    }
}
?>
<?php get_header(); ?>
<div id="content" class="">
    <div id="kontakt" class="mfp-hide" data-effect="mfp-zoom-out">
        <?php echo do_shortcode( '[gravityform id="35" title="true" description="true" tabindex="0" ajax=true ]' ); ?>
    </div>
    <div id="kontakt-agentur" class="mfp-hide" data-effect="mfp-zoom-out">
        <?php echo do_shortcode( '[gravityform id="42" title="true" description="true" tabindex="0" ajax=true ]' ); ?>
    </div>
    <?php   get_template_part('library/templates/hero-agenturfinder', 'page'); ?>
    <div id="main" class="agenturen-single no-margin-top clearfix" role="main">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article style="" id="post-<?php the_ID(); ?>" class="clearfix omt-row wrap" role="article">
                <div class="agenturen-main-content module-with-sidebar">
                    <section class="entry-content omt-row agentur-header intro-wrap " itemprop="articleBody">
                        <img class="agentur-logo" src="<?php print $logo['sizes']['350-180'];?>"/>
                        <h1 class="agentur-title"><?php print get_the_title();?></h1>
                        <div class="meta-wrap">
                            <?php print "Agentur in " . $adresse_stadt . " | ";
                            foreach($services as $service) { ?>
                                <?php print $service['label'] . " | "; ?>
                            <?php } ?>
                            <?php print $anzahl_der_mitarbeiter . " Mitarbeiter"; ?>
                        </div>
                        <?php print $beschreibung;?>
                        <div class="social-media">
                            <?php if (strlen($homepage)>0) { $icon = "fa fa-home"; $link = $homepage; ?> <a target="_blank" class="social-icon" href="<?php print trim($link) ?>"><i class="<?php print $icon;?>"></i></a><?php } ?>
                            <?php if (strlen($facebook)>0) { $icon = "fa fa-facebook"; $link = $facebook; ?> <a target="_blank" class="social-icon" href="<?php print trim($link) ?>"><i class="<?php print $icon;?>"></i></a><?php } ?>
                            <?php if (strlen($linkedin_profil)>0) { $icon = "fa fa-linkedin"; $link = $linkedin_profil; ?> <a target="_blank" class="social-icon" href="<?php print trim($link) ?>"><i class="<?php print $icon;?>"></i></a><?php } ?>
                            <?php if (strlen($instagram)>0) { $icon = "fa fa-instagram"; $link = $instagram; ?> <a target="_blank" class="social-icon" href="<?php print trim($link) ?>"><i class="<?php print $icon;?>"></i></a><?php } ?>
                            <?php if (strlen($instagram_profil_2)>0) { $icon = "fa fa-instagram"; $link = $instagram_profil_2; ?> <a target="_blank" class="social-icon" href="<?php print trim($link) ?>"><i class="<?php print $icon;?>"></i></a><?php } ?>
                            <?php if (strlen($youtube)>0) { $icon = "fa fa-youtube"; $link = $youtube; ?> <a target="_blank" class="social-icon" href="<?php print trim($link) ?>"><i class="<?php print $icon;?>"></i></a><?php } ?>
                            <?php if (strlen($twitter)>0) { $icon = "fa fa-twitter"; $link = $twitter; ?> <a target="_blank" class="social-icon" href="<?php print trim($link) ?>"><i class="<?php print $icon;?>"></i></a><?php } ?>
                            <?php if (strlen($xing)>0) { $icon = "fa fa-xing"; $link = $xing; ?> <a target="_blank" class="social-icon" href="<?php print trim($link) ?>"><i class="<?php print $icon;?>"></i></a><?php } ?>
                            <?php if (strlen($snapchat)>0) { $icon = "fa fa-snapchat"; $link = $snapchat; ?> <a target="_blank" class="social-icon" href="<?php print trim($link) ?>"><i class="<?php print $icon;?>"></i></a><?php } ?>
                        </div>

                        <div class="kompetenzen">
                            <?php foreach ($branchen as $kompetenz) { ?>
                                <div class="button button-grey kompetenz"><?php print $kompetenz['label']; ?></div>
                            <?php } ?>
                        </div>
                    </section>
                    <?php if (strlen($videos[0]['youtube_embed_code'])>0) { ?>
                        <section class="omt-row video-wrap">
                            <h2>Videos <?php print get_the_title();?></h2>
                            <?php foreach ($videos as $video) { ?>
                                <div class="vidembed_wrap "><div class="youtube lazy-youtube" data-embed="<?php print $video['youtube_embed_code'];?>">
                                        <div class="play-button"></div>
                                    </div></div>
                            <?php } ?>
                        </section>
                    <?php } ?>

                    <?php if (strlen($erfolge[0]['headline'])>0) { ?>
                        <section class="omt-row erfolge-wrap">
                            <h2>Erfolge <?php print get_the_title();?></h2>
                            <?php foreach ($erfolge as $erfolg) { ?>
                                <div>
                                    <p style="font-weight: 700;"><?php print $erfolg['headline'];?></p>
                                    <?php print $erfolg['text'];?>
                                </div>
                            <?php } ?>
                        </section>
                    <?php } ?>

                    <?php if (strlen($zertifikat_1_titel)>0) { ?>
                    <section class="omt-row erfolge-wrap">
                        <h2>Zertifikate <?php print get_the_title();?></h2>
                        <div class="card">
                            <h3><?php print $zertifikat_1_titel;?></h3>
                            <?php if (strlen($zertifikat_1_bild_formularfeld)>0) { $zertifikat_1_bild['url'] = $zertifikat_1_bild_formularfeld; } ?>
                            <?php if (strlen($zertifikat_1_bild['url'])>0) { ?><img src="<?php print $zertifikat_1_bild['url'];?>"><?php } ?>
                            <?php print $zertifikat_1_beschreibung;?>
                        </div>
                        <?php } ?>
                        <?php if (strlen($zertifikat_2_titel)>0) { ?>
                            <div class="card">
                                <h3><?php print $zertifikat_2_titel;?></h3>
                                <?php if (strlen($zertifikat_2_bild_formularfeld)>0) { $zertifikat_2_bild['url'] = $zertifikat_2_bild_formularfeld; } ?>
                                <?php if (strlen($zertifikat_1_bild['url'])>0) {?><img src="<?php print $zertifikat_2_bild['url'];?>"><?php } ?>
                                <?php print $zertifikat_2_beschreibung;?>
                            </div>
                        <?php } ?>
                        <?php if (strlen($zertifikat_3_titel)>0) { ?>
                            <div class="card">
                                <h3><?php print $zertifikat_3_titel;?></h3>
                                <?php if (strlen($zertifikat_3_bild_formularfeld)>0) { $zertifikat_3_bild['url'] = $zertifikat_3_bild_formularfeld; } ?>
                               <?php if (strlen($zertifikat_1_bild['url'])>0) { ?> <img src="<?php print $zertifikat_3_bild['url'];?>"><?php } ?>
                                <?php print $zertifikat_3_beschreibung;?>
                            </div>
                        <?php } ?>
                        <?php if (strlen($zertifikat_4_titel)>0) { ?>
                            <div class="card">
                                <h3><?php print $zertifikat_4_titel;?></h3>
                                <?php if (strlen($zertifikat_4_bild_formularfeld)>0) { $zertifikat_4_bild['url'] = $zertifikat_4_bild_formularfeld; } ?>
                                <?php if (strlen($zertifikat_1_bild['url'])>0) {?><img src="<?php print $zertifikat_4_bild['url'];?>"><?php } ?>
                                <?php print $zertifikat_4_beschreibung;?>
                            </div>
                        <?php } ?>
                        <?php if (strlen($zertifikat_1_titel)>0) { ?>
                    </section>
                <?php } ?>
                </div> <?php //end of leftside / main content?>
                <div class="sidebar agentur-sidebar">
                    <?php $agenturen_sidebar_cta = get_field('agenturen_sidebar_cta','options');
                    if (strlen($agenturen_sidebar_cta)>0) { ?>
                        <div class="contact-modal">
                            <a class="omt-row sidebar-cta agentursuche-button" href="#kontakt">
                                <?php print $agenturen_sidebar_cta;?>
                            </a>
                        </div>
                    <?php } ?>
                    <section class="omt-row ansprechpartner">
                        <?php
                        if ($agentur_ansprechpartner_auswahlfeld->ID>0) {
                            $ansprechpartner_link = get_the_permalink($agentur_ansprechpartner_auswahlfeld->ID);
                        }?>
                        <?php if (strlen($ansprechpartner_link)>0) { ?><a href="<?php print $ansprechpartner_link;?>"><?php }?>
                            <strong>Ansprechpartner: <?php print$agentur_ansprechpartner;?></strong>
                            <?php if (strlen($ansprechpartner_link)>0) { ?></a><?php }?>
                        <?php if (strlen($agentur_ansprechpartner_profilbild['sizes']['350-180'])>0) { ?>
                        <img class="anspreachpartner-img"
                             alt="<?php print $agentur_ansprechpartner;?>"
                             title="<?php print $agentur_ansprechpartner;?>"
                             src="<?php print $agentur_ansprechpartner_profilbild['sizes']['350-180'];?>"
                        />
                        <?php } ?>
                    </section>
                    <section class="omt-row row-ansprechpartner"">
                    <div class="contact-modal">
                        <a class="cta button button-red agentursuche-button button-full" href="#kontakt-agentur">Jetzt kontaktieren</a>
                    </div>
                    </section>
                    <section class="omt-row google-map">
                        <?php
                        $map_marker_text = get_the_title();
                        $map_marker_image = $logo['sizes']['350-180'];
                        $zoom = 11;
                        ?>
                        <div class="maps-wrap">
                            <?php
                            wp_enqueue_script('google-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDFmVEWDZOoE8GtOglBut7XSID-OSC6hK0', null, null, true); // Add in your key
                            // ACF Google Map Single Map Output
                            //$location = get_field('location'); // Set the ACF location field to a variable
                            //wp_enqueue_script('acfmaps', get_stylesheet_directory_uri() . '/library/js/acf-maps.js', array('jquery'), '', true);
                            ?>
                            <div class="acf-map">
                                <div class="marker" data-lat="<?php echo $google_maps_adresse['lat']; ?>" data-lng="<?php echo $google_maps_adresse['lng']; ?>">
                                    <img class="agentur-logo" alt="<?php print get_the_title();?>" src="<?php print $logo['sizes']['350-180'];?>"/>
                                    <div class="agentur-titel-wrap">
                                        <p class="agentur-name"><?php print get_the_title();?></p>
                                    </div>
                                    <div class="agentur-adresse">
                                        <?php print $adresse_strasse . "<br/>" . $adresse_plz . "&nbsp;" . $adresse_stadt;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <?php /*Mitarbeiter Experten und Veröffentlichungen*/?>
                <?php if (strlen($agentur_mitarbeiter[0]->ID)>0) {
                    $mitarbeiter_ids = ""; ?>
                    <section class="omt-row">
                        <h2>Mitarbeiter <?php print get_the_title();?></h2>
                        <?php foreach($agentur_mitarbeiter as $speaker) {
                            $speaker_image = get_field("profilbild", $speaker->ID);
                            $speaker_profil = get_field("beschreibung", $speaker->ID);
                            $speaker_titel = get_field("titel", $speaker->ID);
                            $speaker_id = $speaker->ID;
                            ?>
                            <div class="testimonial card clearfix speakerprofil no-margin-top">
                                <h3 class="experte"><a target="_self" href="<?php print the_permalink($speaker->ID);?>"><?php print $speaker->post_title;?></a></h3>
                                <div class="testimonial-img">
                                    <a target="_self" href="<?php print the_permalink($speaker->ID);?>">
                                        <img class="teaser-img" alt="<?php print $speaker_image['alt'];?>" title="<?php print $speaker_image['alt'];?>" src="<?php print $speaker_image['sizes']['350-180'];?>"/>
                                    </a>
                                </div>
                                <div class="testimonial-text">
                                    <?php print $speaker_profil;?>
                                </div>
                            </div>
                            <?php
                            $mitarbeiter_ids .= $speaker->ID . "|";
                            $multiautor = substr($mitarbeiter_ids, 0, -1);
                            $multiautor = explode("|", $multiautor);
                        } ?>
                    </section>

                    <?php /////////////////////////// WEBINARE DER AGENTUR COME HERE ////////////////////////// ?>
                    <?php if (!defined('USE_JSON_POSTS_SYNC') || USE_JSON_POSTS_SYNC === false) : ?>
                        <?php if (count($agencyWebinars)) : ?>
                            <div class="omt-row">
                                <h2>Webinare von <?php print get_the_title();?></h2>

                                <div class="webinare-wrap teaser-modul speaker-webinare">
                                    <?php echo WebinarView::loadTemplate('items', ['webinars' => $agencyWebinars, 'highlightFirst' => true]) ?>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php else : ?>
                        <?php if (display_webinare_json_alle(99, 'ASC', NULL, $speaker_id, true, true, $mitarbeiter_ids) > 0) { ?>
                            <div class="omt-row">
                                <h2>Webinare von <?php print get_the_title();?></h2>

                                <div class="webinare-wrap teaser-modul speaker-webinare">
                                    <?php display_webinare_json_alle(99, 'ASC', NULL, $speaker_id, true, false, $mitarbeiter_ids);?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php endif ?>

                    <?php ///MAGAZINARTIKEL DER AGENTUR COME HERE ?>
                    <?php if (USE_JSON_POSTS_SYNC) : ?>
                        <?php if (display_magazinartikel_json(999, "alle", NULL, true, 1, "teaser-small", false, $mitarbeiter_ids) > 0) : ?>
                            <div class="omt-row">
                                <h2>Magazinartikel <?php print get_the_title();?></h2>
                                <div class="webinare-wrap teaser-modul speaker-webinare">
                                    <?php display_magazinartikel_json(999, "alle", NULL, false, 1, "teaser-small", false, $mitarbeiter_ids);?>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php else : ?>
                        <?php if (count($agencyArticles)) : ?>
                            <div class="omt-row">
                                <h2>Magazinartikel <?php echo get_the_title() ?></h2>

                                <div class="webinare-wrap teaser-modul speaker-webinare">
                                    <?php echo ArticleView::loadTemplate('items', [
                                        'articles' => $agencyArticles,
                                        'format' => 'teaser-small',
                                        'highlightFirst' => true
                                    ]); ?>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endif ?>

                    <?php ///////////////////////////PODCASTS GO HERE//////////////////////////?>
                    <?php $podcast_counter = display_podcasts_json(99991, NULL, $speaker_id,true, NULL, $mitarbeiter_ids);
                    if ($podcast_counter >0 ) { ?>
                        <div class="omt-row">
                            <h2>Podcasts <?php print get_the_title();?></h2>
                            <div class="webinare-wrap podinare-wrap teaser-modul speaker-webinare">
                                <?php  display_podcasts_json(99, NULL, $speaker_id,false, NULL, $mitarbeiter_ids);?>
                            </div>
                        </div>
                    <?php } ?>


                    <?php ////////////VORTRÄGE////////
                    $headline = 0;
                    $args = array( //next
                        'posts_per_page'    => -1,
                        'post_type'         => "vortrag",
                        'posts_status'      => "publish",
                        'order'				=> 'DESC',
                        'orderby'			=> 'date',
                    );
                    $loop = new WP_Query( $args );
                    ?>
                    <div class="omt-row">

                        <?php
                        while ( $loop->have_posts() ) : $loop->the_post(); ?>
                        <?php
                        $speaker = get_field('speaker');
                        $speakervortrag = 0;
                        if (is_array($speaker)) {
                            foreach ($speaker as $sid) {
                                $speaker_id = $sid->ID;
                                if (in_array($speaker_id, $multiautor)) { $speakervortrag = 1; }
                            }
                        }
                        if (1==$speakervortrag) {
                        if ($headline != 1) { ?>
                        <h2>Vorträge von <?php print $name;?></h2>
                        <div class="webinare-wrap teaser-modul speaker-webinare">
                            <?php $headline = 1; ?>
                            <?php }
                            $speaker = $speaker[0];
                            $speaker_image = get_field("profilbild", $speaker->ID);
                            $image_teaser = $speaker_image['sizes']['350-180'];
                            $title = get_the_title();
                            $vortrag_vimeo_link = get_field('vortrag_vimeo_link');
                            if (strlen($vortrag_vimeo_link)<1) { $vortrag_vimeo_link = get_the_permalink();}
                            if (strlen($title)>65) { $title = substr($title, 0, 65) . "..."; } ;
                            //$webinar_shorttitle = implode(' ', array_slice(explode(' ', $title), 0, 7));
                            //$wordcount = str_word_count($title);
                            //if ($wordcount > 7) { $title = $webinar_shorttitle . "..."; }
                            ?>
                            <div class="teaser teaser-small teaser-matchbuttons">
                                <div class="teaser-image-wrap" style="">
                                    <img class="webinar-image teaser-img" alt="<?php the_title();?>" title="<?php the_title();?>" src="<?php print $image_teaser;?>"/>
                                    <img alt="OMT Vortrag" title="OMT Vortrag" class="teaser-image-overlay" src="/uploads/omt-banner-overlay-350.png" style="">
                                </div>
                                <h4 class="article-title"><a target="_blank" href="<?php print $vortrag_vimeo_link;?>" title="<?php the_title_attribute(); ?>"><?php print $title; ?></a></h4>
                                <p class="experte no-margin-top no-margin-bottom">
                                    <a target="_self" href="<?php print get_the_permalink($speaker->ID);?>"><?php print get_the_title($speaker->ID); ?></a>
                                </p>
                                <a class="button" target="_blank" href="<?php print $vortrag_vimeo_link;?>" title="<?php the_title_attribute(); ?>">Vortrag anschauen</a>
                            </div>
                            <?php }
                            endwhile; //end
                            wp_reset_postdata();?>
                        </div>
                    </div>
                    <?php ///////////////////////////?>
                <?php } ?>
                <?php ///TOOLS///
                $headline = 0;
                $args = array( //next
                    'posts_per_page'    => -1,
                    'post_type'         => "tool",
                    'posts_status'      => "publish",
                    'order'				=> 'DESC',
                    'meta_query' => array(
                        array(
                            'key' => 'experten_agenturen', // name of custom field
                            'value' => '"' . $agentur_ID . '"',
                            'compare' => 'LIKE'
                        )
                    )
                );
                $loop = new WP_Query( $args );
                if ( $loop->have_posts()) { ?>
                <h2>Tool-Expertise von <?php print $name;?></h2>
                 <?php }?>
                 <div class="omt-row tool-experten teaser-modul">
                    <?php
                    while ( $loop->have_posts() ) : $loop->the_post();
                        $ID = get_the_ID();
                        $permalink = get_the_permalink();
                        $logo = get_field('logo');
                        $title = str_replace('Privat: ', "", get_the_title());
                        $vorschautext = get_field('vorschautext');
//if (strlen($vorschautext)>300) { $vorschautext = implode(' ', array_slice(explode(' ', $vorschautext), 0, 35))."..."; }
                        $gesamt = number_format(get_field('gesamt')['$wertung_gesamt'], 1, ".",",");
                        $toolanbieter = get_field('$toolanbieter');
                        $anzahl_bewertungen = get_field('$anzahl_bewertungen');
                        $tool_details = get_field('$tool_details');
                        if ( ( strlen($toolanbieter) <1) OR (NULL == $toolanbieter) ) {  }
                        ?>
                        <div class="card agentur-preview tool-agentur teaser teaser-small">
                            <a class="" style=""
                               href="<?php print $permalink; ?>">
                                <img class="agentur-logo" src="<?php print $logo['url']; ?>"
                                     alt="<?php print $title; ?>" title="<?php print $title; ?>"/>
                            </a>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                    ?>
            </article>
        <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>


