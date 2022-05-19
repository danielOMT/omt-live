<?php

use OMT\Model\Datahost\Webinar;
use OMT\StructuredData\WebinarVideo;

?>
<?php get_header(); ?>
<?php
$post_id = get_the_ID();
$featured_img_url = get_the_post_thumbnail_url($post_id, 'post-image');
$hero_image = get_field('webinare_einzelansicht', 'options');
$h1 = get_field('webinare_einzelansicht_text', 'options');
$hubspot_formular_id = get_field('hubspot_formular_id');
$webinar_vorschautitel = get_field('webinar_vorschautitel');
$webinar_youtube_embed_code = get_field('webinar_youtube_embed_code');
$webinar_wistia_embed_code= get_field('webinar_wistia_embed_code');
$soundcloud = get_field('webinar_soundcloud_iframe_link');
$webinar_day  = get_field('webinar_datum');
$webinar_time = get_field("webinar_uhrzeit_start");
$webinar_uhrzeit_ende = get_field('webinar_uhrzeit_ende');
$webinar_speakers = get_field('webinar_speaker');
$webinar_download = get_field('webinar_download');
$webinar_download_text = get_field('webinar_download_text');
$webinar_download_2 = get_field('webinar_download_2');
$webinar_download_text_2 = get_field('webinar_download_text_2');
$webinar_beschreibung = get_field('webinar_beschreibung');
$alternative_beschreibung_fur_themenwelten = get_field('alternative_beschreibung_fur_themenwelten');
$webinar_agenda = get_field('webinar_agenda');
$webinar_zielgruppe = get_field('webinar_zielgruppe');
$webinar_zusammenfassung = get_field('webinar_zusammenfassung');
$webinarID = get_field('webinarID');
$webinar_wistia_embed_code_mitglieder = get_field('webinar_wistia_embed_code_mitglieder');
// Convert it into a timestamp.
$timestamp = strtotime($webinar_day);
// Convert it to DD-MM-YYYY
$webinar_day = date("d.m.Y", $timestamp);
$zeilen = get_field("zeilen");
$als_seite_behandeln = get_field('als_seite_behandeln');
$slideShareUrl = trim(get_field('slideshare-url'));
$webinar_schwierigkeitsgrad = get_field('webinar_schwierigkeitsgrad');
$datahostWebinar = Webinar::init()->item(['id' => $post_id]);
?>
<!--<div class="socials-floatbar-left">-->
<!--    --><?php //print do_shortcode('[shariff headline="<p>Webinar teilen:</p>" borderradius="1" services="facebook|twitter|googleplus|linkedin|xing" theme="round" orientation="vertical"]');?>
<!--</div>-->
<?php echo WebinarVideo::init($datahostWebinar)->render() ?>

<div id="content" class="" xmlns:background="http://www.w3.org/1999/xhtml">
    <?php
    if (1 != $als_seite_behandeln) {
    /* <div class="hero-header" style="background: url('<?php print $hero_image['url'];?>') no-repeat 50% 0;">
        <div class="wrap">
            <h2 class="h1"><?php print $h1;?></h2>
        </div>
    </div>*/?>
    <div id="inner-content" class="wrap clearfix no-hero">
        <div id="main" class="omt-row blog-single  clearfix" role="main">
            <div class="header-extras">
                <?php if (strlen($webinar_youtube_embed_code)<1 AND strlen($webinar_wistia_embed_code)<1 AND strlen($hubspot_formular_id) > 0 ) { /*FALLS KEIN VIDEO CODE: HUBSPOT FORMULAR, falls vorhanden, ausgeben*/?>
                    <h4 class="teaser-cat no-margin-bottom webinar-date no-margin-top"><?php print $webinar_day; ?> | <?php print $webinar_time . " Uhr - " . $webinar_uhrzeit_ende. " Uhr";?></h4>
                <?php } ?>
                <div class="socials-header"><?php print do_shortcode('[shariff borderradius="1" services="facebook|twitter|googleplus|linkedin|xing" theme="round" orientation="horizontal" align="flex-end"]');?></div>
            </div>
            <h1 class="entry-title single-title h2"  style="margin-bottom:0px; itemprop="headline"><?php the_title(); ?></h1>
            <div class="table-cats has-margin-bottom-30">
                <span style="font-size:14px;">Schwierigkeitsgrad: </span>
                <?php if (in_array(1, $webinar_schwierigkeitsgrad)) { ?><i style="cursor:help;" title="Für Anfänger geeignet" class="cat1 fa fa-circle"></i><?php } ?>
                <?php if (in_array(2, $webinar_schwierigkeitsgrad)) { ?><i style="cursor:help;" title="Einsteiger, aber Basiswissen vorhanden" class="cat2 fa fa-circle"></i><?php } ?>
                <?php if (in_array(3, $webinar_schwierigkeitsgrad)) { ?><i style="cursor:help;" title="Fortgeschrittene" class="cat3 fa fa-circle"></i><?php } ?>
                <?php if (in_array(4, $webinar_schwierigkeitsgrad)) { ?><i style="cursor:help;" title="Experten" class="cat4 fa fa-circle"></i><?php } ?>
            </div>
            <?php //***WEBINAR VIDEO UND DOWNLOADS + SONSTIGE FEATURES AUSGEBEN**//?>
            <?php if (strlen($webinar_youtube_embed_code)>0 OR strlen($webinar_wistia_embed_code)>0 OR strlen($webinar_wistia_embed_code_mitglieder)>0) {  //webinar video erst nach club launch aktivieren ?>
                <div class="video_wrap">
                    <div class="webinar-video">
                        <?php if (!is_user_logged_in()) {
                            if (strlen($webinar_wistia_embed_code) > 0) { ?>
                                <div class="video-wrap player-wrap" data-members="<?php print $webinar_wistia_embed_code_mitglieder; ?>">
                                    <script src="//fast.wistia.com/embed/medias/<?php print $webinar_wistia_embed_code; ?>.jsonp" async></script>
                                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                                    <div class="wistia_responsive_padding">
                                        <div class="wistia_responsive_wrapper">
                                            <div class="wistia_embed wistia_async_<?php print $webinar_wistia_embed_code; ?>">
                                                &nbsp;
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if (strlen($webinar_wistia_embed_code) < 3) { ?>
                                <div class="webinar-not-available">
                                    <h3>Dieses Video ist nur für eingeloggte Mitglieder verfügbar</h3>
                                </div>
                            <?php }
                        }
                        if (is_user_logged_in()) { ?>
                            <?php if (strlen($webinar_wistia_embed_code_mitglieder) >0 ) { ?>
                                <div class="video-wrap">
                                    <script src="//fast.wistia.com/embed/medias/<?php print $webinar_wistia_embed_code_mitglieder;?>.jsonp" async></script>
                                    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                                    <div class="wistia_responsive_padding">
                                        <div class="wistia_responsive_wrapper">
                                            <div class="wistia_embed wistia_async_<?php print $webinar_wistia_embed_code_mitglieder;?>">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else {
                                if (strlen($webinar_youtube_embed_code)>0) { ?>
                                    <div class="vidembed_wrap">
                                        <div class="vidembed">
                                            <iframe title="YouTube video player" src="https://www.youtube.com/embed/<?php print $webinar_youtube_embed_code;?>?enablejsapi=1&origin=<?php print get_the_permalink();?>" frameborder="0" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <?php if (strlen($webinar_download['url'])>0) { ?>
                    <?php if (is_user_logged_in()) {  ?>
                        <?php $button_text = "Folien zum Webinar herunterladen";
                        if (strlen($webinar_download_text)>0) { $button_text = $webinar_download_text; } ?>
                        <div class="block download-wrap">
                            <a class="button button-730px centered" target="_blank" href="<?php print $webinar_download['url'];?>"><?php print $button_text;?></a>
                        </div>
                    <?php } ?>
                    <?php if (!is_user_logged_in()) { ?>
                        <div class=" download-wrap">
                            <span class="button button-login button-730px button-centered">Zum Download der Folien bitte im OMT-Club einloggen</span>
                        </div>
                    <?php } ?>
                <?php } ?>
                <?php if (strlen($webinar_download_2['url'])>0) { ?>
                    <?php if (is_user_logged_in()) {  ?>
                        <?php $button_text = "Weitere Infos zum Webinar herunterladen";
                        if (strlen($webinar_download_text_2)>0) { $button_text = $webinar_download_text_2; } ?>
                        <div class=" download-wrap">
                            <a class="button button-730px centered" target="_blank" href="<?php print $webinar_download_2['url'];?>"><?php print $button_text;?></a>
                        </div>
                    <?php } ?>
                <?php } ?>
                <?php if (is_user_logged_in() && !empty($slideShareUrl)) : ?>
                    <div class="download-wrap">
                        <a class="button button-730px centered" target="_blank" href="<?php echo $slideShareUrl ?>">Die Folien bei Slideshare</a>
                    </div>
                <?php endif ?>

                <?php  if (strlen($soundcloud)>0) { //SOUNDCLOUD ?>
                    <?php if (is_user_logged_in()) {  ?>
                        <?php
                        //  $soundcloud = '<iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/323253642&color=%23c0cedb&auto_play=false&hide_related=true&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>';
                        $trackpos = strpos($soundcloud, "/tracks/");
                        $trackid_start = substr($soundcloud, $trackpos+8);
                        $trackendpos = strpos($trackid_start, "&color=");
                        $trackid = substr($trackid_start,0,$trackendpos);
                        ?>
                        <iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/<?php print $trackid;?>&color=%23ea506c&auto_play=false&hide_related=true&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>
                    <?php } ?>
                <?php } ?>
            <?php } /***END OF WEBINAR VIDEO UND DOWNLOADS + SONSTIGE FEATURES AUSGEBEN*/ else { ?>
            <?php }?>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
                <section class="entry-content clearfix" itemprop="articleBody">
                    <div class="content-intro clearfix">
                        <?php if (strlen($webinar_youtube_embed_code)>0 OR strlen($webinar_wistia_embed_code)>0) {  //webinar video erst nach club launch aktivieren ?>
                            <?php print $webinar_beschreibung; ?>
                            <?php print $webinar_agenda; ?>
                            <?php print $webinar_zielgruppe; ?>
                        <?php } else { ?>
                        <div class="half left-half">
                            <?php print $webinar_beschreibung; ?>
                            <?php print $webinar_agenda; ?>
                            <?php print $webinar_zielgruppe; ?>
                        </div>
                        <div class="half right-half">
                            <?php if (strlen($webinar_youtube_embed_code)<1 AND strlen($webinar_wistia_embed_code)<1 AND strlen($hubspot_formular_id) > 0 ) { /*FALLS KEIN VIDEO CODE: HUBSPOT FORMULAR, falls vorhanden, ausgeben*/?>
                                <?php if (isWebinarAvailable($datahostWebinar)) { //set webinar status?>
                                    <!--[if lte IE 8]>
                                    <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
                                    <![endif]-->
                                    <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
                                    <script>
                                        hbspt.forms.create({
                                            portalId: '3856579',
                                            formId: '<?php print $hubspot_formular_id;?>'
                                        });
                                    </script>
                                    <!-- Button code -->
                                    <!-- AddEvent button -->
                                    <script type="text/javascript" src="https://addevent.com/libs/atc/1.6.1/atc.min.js" async defer></script>
                                    <div title="Add to Calendar" class="addeventatc" data-styling="none">
                                        Webinar im Kalender eintragen
                                        <span class="arrow">&nbsp;</span>
                                        <span class="start"><?php print $webinar_day;?> <?php print $webinar_time;?></span>
                                        <span class="end"><?php print $webinar_day;?> <?php print $webinar_uhrzeit_ende;?></span>
                                        <span class="timezone">Europe/Berlin</span>
                                        <span class="title"><?php print get_the_title();?></span>
                                        <span class="description">OMT Webinar: <?php print get_the_permalink();?></span>
                                        <span class="location">Online</span>
                                        <span class="organizer">Online Marketing Tag</span>
                                        <span class="organizer_email">info@omt.de</span>
                                        <span class="all_day_event">false</span>
                                    </div>
                                <?php } else { ?>
                                    <img class="coming-soon" alt="Das OMT Webinar ist bald verfügbar" title="Das OMT Webinar ist bald verfügbar" src="/uploads/webinare-aufzeichung-coming-soon.jpg"/>
                                <?php } ?>
                                <a class="button button-red button-350px has-margin-top-30" target="_blank" href="https://share.jumpbird.io/subscribe/token/cRGV2hP0qK3U2A3ewS1BgwOuT85DMcUnXhmWzcfM9KtnWM">Alle OMT-Webinare in Deinem Kalender</a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </section>
                <?php if (strlen($webinar_youtube_embed_code)>0 OR strlen($webinar_wistia_embed_code)>0) {  //Webinar liegt in der Vergangenheit, Video liegt vor ?>
                    <section class="omt-row wrap">
                        <?php foreach($webinar_speakers as $webinar_speaker) {
                            $speaker_image = get_field("profilbild", $webinar_speaker->ID);
                            $speaker_profil = get_field("beschreibung", $webinar_speaker->ID);
                            $speaker_titel = get_field("titel", $webinar_speaker->ID);
                            ?>
                            <div class="testimonial card clearfix speakerprofil">
                                <h3 class="experte"><a target="_self" href="<?php print the_permalink($webinar_speaker->ID);?>"><?php print $webinar_speaker->post_title;?></a></h3>
                                <div class="testimonial-img">
                                    <a target="_self" href="<?php print the_permalink($webinar_speaker->ID);?>">
                                        <img class="teaser-img" alt="<?php print $speaker_image['alt'];?>" title="<?php print $speaker_image['alt'];?>" src="<?php print $speaker_image['sizes']['350-180'];?>"/>
                                    </a>
                                </div>
                                <div class="testimonial-text">
                                    <?php print $speaker_profil;?>
                                </div>
                            </div>
                            <a class="button button-730px button-grey centered has-margin-top-30" href="<?php print get_permalink($webinar_speaker->ID);?>">Mehr über <?php print $webinar_speaker->post_title;?> erfahren</a>
                        <?php } ?>
                    </section>
                    <?php
                    require_once ('library/functions/function-magazin.php');
                    $terms = get_the_terms( $post_id, 'kategorie' );
                    $kategorie = "";
                    foreach ($terms as $term) {
                        $kategorie .= $term->slug . "|";
                    }
                    if (strlen($kategorie)<1) { $kategorie = "alle"; }
                    $count_artikel = display_magazinartikel(10, $kategorie, NULL, true, 1, "teaser-small");
                    if ($count_artikel > 0) { ?>
                        <div class="omt-row wrap grid-wrap">
                            <h2>Weitere Magazinartikel rund um das Webinarthema</h2>
                            <div class="omt-module webinare-wrap teaser-modul">
                                <?php
                                if (count($terms)<2 AND $kategorie!="alle") { $kategorie = $terms[0]->slug; }
                                display_magazinartikel(10, $kategorie, NULL, false, 1, "teaser-small");
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php $standard_icon_teaser_highlight = get_field('standard_icon_teaser_highlight', 'options');?>
                    <div class="omt-row color-area-grau">
                        <div class="color-area-inner"></div>
                        <div class="omt-module teaser-highlight teaser-highlight-gradient">
                            <a class="teaser-highlight-container" href="/club/" target="_self">
                                <!--starting teaser highlight content-->
                                <div class="teaser-highlight-img">
                                    <img src="<?php print $standard_icon_teaser_highlight['url'];?>" width="130" />
                                </div>
                                <div class="teaser-highlight-text">
                                    <h3>Der OMT Club</h3>
                                    <p>Bleibe auf dem Laufenden und erhalte alle News zum OMT per E-Mail.</p>
                                </div>
                                <!--ending teaser highlight content-->
                            </a>
                        </div>
                    </div>
                <?php } ?>
                <?php if (strlen($webinar_youtube_embed_code)<1 AND strlen($webinar_wistia_embed_code)<1 AND strlen($hubspot_formular_id) > 0 ) { /*FALLS KEIN VIDEO CODE: HUBSPOT FORMULAR, falls vorhanden, ausgeben*/?>
                <section class="omt-row wrap color-area-grau">
                    <div class="color-area-inner"></div>
                    <?php foreach($webinar_speakers as $webinar_speaker) {
                        $speaker_image = get_field("profilbild", $webinar_speaker->ID);
                        $speaker_profil = get_field("beschreibung", $webinar_speaker->ID);
                        $speaker_titel = get_field("titel", $webinar_speaker->ID);
                        ?>
                        <div class="testimonial card clearfix speakerprofil">
                            <h3 class="experte"><a target="_self" href="<?php print the_permalink($webinar_speaker->ID);?>"><?php print $webinar_speaker->post_title;?></a></h3>
                            <div class="testimonial-img">
                                <a target="_self" href="<?php print the_permalink($webinar_speaker->ID);?>">
                                    <img class="teaser-img" alt="<?php print $speaker_image['alt'];?>" title="<?php print $speaker_image['alt'];?>" src="<?php print $speaker_image['sizes']['350-180'];?>"/>
                                </a>
                            </div>
                            <div class="testimonial-text">
                                <?php print $speaker_profil;?>
                            </div>
                        </div>
                        <a class="button button-730px button-blue centered" href="<?php print get_permalink($webinar_speaker->ID);?>">Mehr über <?php print $webinar_speaker->post_title;?> erfahren</a>
                    <?php } ?>
                </section>
                <?php $standard_icon_teaser_highlight = get_field('standard_icon_teaser_highlight', 'options'); ?>
                <section class="omt-row wrap color-area-weis">
                    <div class="color-area-inner"></div>
                    <div class="omt-module teaser-highlight teaser-highlight-gradient">
                        <a class="teaser-highlight-container" href="/club/" target="_self">
                            <!--starting teaser highlight content-->
                            <div class="teaser-highlight-img">
                                <img src="<?php print $standard_icon_teaser_highlight['url'];?>" width="130" />
                            </div>
                            <div class="teaser-highlight-text">
                                <h3>Der OMT Club</h3>
                                <p>Bleibe auf dem Laufenden und erhalte alle News zum OMT per E-Mail.</p>
                            </div>
                            <!--ending teaser highlight content-->
                        </a>
                    </div>
        </div>
        </section>
        <?php }
        ?>
        </article>
        <?php endwhile; ?>
        <?php endif; ?>
    </div>
    <?php //get_sidebar(); ?>
</div>
<?php } ////END OF REGULÄRES WEBINAR?>

<?php if (1 == $als_seite_behandeln) {
    include('library/templates/single-as-page-contentparts-top.php');
    foreach ($zeilen as $zeile) {
        if($user && isset($user->user_login) && 'Daniel Voelskow' == $user->user_login) {
            // do stuff
            $rustart = getrusage();//start measuring php workload time
        }

        ?>
        <?php $rowclass = ""; ?>
        <?php $color_area = true;
        $headline = $zeile['headline'];
        $headline_typ = $zeile['headline_typ'];
        $introtext = $zeile['introtext'];
        $headline_noindex = $zeile['headline_noindex'];
        $headline_set = $zeile['headline_&_introtext_vor_dem_modul'];
        if ($headline_set!=true) {
            $headline = "";
            $headline_typ = "";
            $introtext = "";
        }
        if (true == $headline_noindex ){ $headline_class = "class='no-ihv'"; } else { $headline_class=""; }
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////SET UP CLASS FOR EACH ROW//////////////////////////////////////
        include ('library/modules/modules-rowclass.php');
        //////////////////////////////////////SET UP CLASS FOR EACH ROW//////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        if ($zeile['no_margin_bottom'] != false) { $rowclass .= " no-margin-bottom"; }
        ?>
    <section class="wrapper omt-row <?php print $rowclass;?> <?php print $class_themenwelt;?> <?php if (false != $color_area ) { ?>color-area-<?php print $zeile['color_embed']; } ?> <?php if (1==$zeile['content_rotate']) { print "content-rotate"; } ?>">
        <?php if (false != $color_area ) { ?><div class="color-area-inner"></div><?php } ?>
        <?php
    if (strlen($headline)>0 OR strlen($introtext)>0) { ?><div class="wrap module-headline-wrap"><?php }
    if (strlen($headline)>0) { ?>
        <<?php print $headline_typ;?> <?php print $headline_class;?>>
        <?php print $headline;?>
        </<?php print $headline_typ;?>>
    <?php } ?>
        <?php if (strlen($introtext)>0) { print $introtext; }
    if (strlen($headline)>0 OR strlen($introtext)>0) { ?></div><?php } ?>
        <?php $i=0;?>
        <?php $i++;

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////SET UP CLASS FOR EACH COLUMN//////////////////////////////////////
        include ('library/modules/modules-columnclass.php');
//////////////////////////////////////SET UP CLASS FOR EACH COLUMN//////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
        ?>
        <div class="omt-module <?php print $columnclass . " "; ?>"
             <?php if ($columnclass == "header_hero_modul") { ?>style="background: url('<?php print $zeile['inhaltstyp'][0]['hero_background_image']['url'];?>');" <?php } ?>
        >
            <?php
            /////////////////////////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////SET UP COMPLETE MODULES FOR EACH INPUT/////////////////////////
            include ('library/modules/modules_modultyp.php');
            //////////////////////////////////////SET UP COMPLETE MODULES FOR EACH INPUT/////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////////
            ?>
        </div>  <?php  //end of foreach COLUMN ?>
        <?php
// END OF SPEEDTEST, SCRIPT COMES BEFORE THIS
        if ( is_user_logged_in() ) {
            if ($user && isset($user->user_login) && 'Daniel Voelskow' == $user->user_login) {
                // do stuff
                $ru = getrusage();
                //        echo "This process used " . rutime($ru, $rustart, "utime") .
//            " ms for its computations\n";
//        echo "It spent " . rutime($ru, $rustart, "stime") .
//            " ms in system calls\n";
            }
        }
// END OF SPEEDTEST, SCRIPT COMES BEFORE THIS
        ?>
        </section><?php } // end of foreach ROW
    include('library/templates/single-as-page-contentparts-bottom.php');
} ?>

</div>
<div class="socials-floatbar-mobile">
    <?php echo do_shortcode('[shariff services="facebook|twitter|googleplus|linkedin|xing" backend="on" lang="de" theme="round" borderradius="1" buttonstretch="1"]'); ?>
</div>
<?php get_footer(); ?>

