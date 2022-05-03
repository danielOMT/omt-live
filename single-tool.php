<?php

use OMT\Model\Datahost\MarketingTool;
use OMT\Model\Datahost\ToolReview;
use OMT\Model\PostModel;
use OMT\Services\ArraySort;
use OMT\View\AuthorView;
use OMT\View\ToolView;

get_header(); ?>
<?php
$post_id = get_the_ID();
$featured_img_url = get_the_post_thumbnail_url($post_id, 'post-image');
$hero_image = get_field('titelbild');
$h1 = get_field('titelbild_overlay_h1');
$inhalt = get_field('inhalt');
$zeilen = get_field('zeilen');
$artikel_autor = get_field('artikel_autor');
$testbericht_zeilen = get_field('testbericht_zeilen');
$produktubersicht = get_field('produktubersicht');
$vorschautext = get_field('vorschautext');
if (strlen($produktubersicht)<1) { $produktubersicht = $vorschautext; }
$wer_verwendet = get_field('wer_verwendet');
$anzahl_bewertungen = get_field('anzahl_bewertungen');
$gesamt_field = get_field('gesamt');
$gesamt                                                         = number_format(floatval($gesamt_field), 1, ".",",");
$rezension['$bewertung_benutzerfreundlichkeit']                 = number_format(floatval(get_field('benutzerfreundlichkeit')), 1, ".",",");
$rezension['$bewertung_support']                                = number_format(floatval(get_field('kundenservice')), 1, ".",",");
$rezension['$bewertung_funktionalitaten']                       = number_format(floatval(get_field('funktionen')), 1, ".",",");
$rezension['$bewertung_preisleistung']                          = number_format(floatval(get_field('preis-leistungs-verhaltnis')), 1, ".",",");
$rezension['$bewertung_wahrscheinlichkeit_weiterempfehlung']    = number_format(floatval(get_field('wahrscheinlichkeit_weiterempfehlung')), 1, ".",",");
$zum_toolanbieter = get_field('zur_webseite');
$tool_preisubersicht = get_field('tool_preisubersicht');
$tool_gratis_testen_link = get_field('tool_gratis_testen_link');
$alles_730 = 1;
$buttons_anzeigen = get_field('buttons_anzeigen');
$neue_ansicht_auch_ohne_content_verwenden = get_field('neue_ansicht_auch_ohne_content_verwenden');
$inhaltsverzeichnis_deaktivieren = get_field('inhaltsverzeichnis_deaktivieren');
$inhaltsverzeichnis_deaktivieren = 1;
$alternativseite_anzeigen = get_field('alternativseite_anzeigen');
$testbericht_menu_title = get_field('testbericht_alternativer_menu_name');
if (strlen($testbericht_menu_title)<1) { $testbericht_menu_title = "Testbericht"; }
$anwendungstipps_menu_title = get_field('anwendungstipps_alternativer_menuname');
if (strlen($anwendungstipps_menu_title)<1) { $anwendungstipps_menu_title = "Anwendungstipps"; }
$manuell_ausgewahlte_alternativen = get_field('manuell_ausgewahlte_alternativen');
$experten_agenturen = get_field('experten_agenturen');
$flexibleAreaEnabled = get_field('flexible_area_enabled');


$website_label = ">> Zum Toolanbieter";
$preise_label = "Preisübersicht";
$testen_label = "Gratis testen";

$toolanbieter_website_optionales_alternativlabel = get_field('toolanbieter_website_optionales_alternativlabel');
$toolanbieter_preise_optionales_alternativlabel = get_field('toolanbieter_preise_optionales_alternativlabel');
$toolanbieter_testen_optionales_alternativlabel = get_field('toolanbieter_testen_optionales_alternativlabel');

if (strlen($toolanbieter_website_optionales_alternativlabel) >1) { $website_label = $toolanbieter_website_optionales_alternativlabel; }
if (strlen($toolanbieter_preise_optionales_alternativlabel) >1) { $preise_label = $toolanbieter_preise_optionales_alternativlabel; }
if (strlen($toolanbieter_testen_optionales_alternativlabel) >1) { $testen_label = $toolanbieter_testen_optionales_alternativlabel; }


?>
<?php
$current_fp = get_query_var('fpage');
if (!$current_fp) { ?>
    <!--    <div class="socials-floatbar-left">-->
    <!--        --><?php //print do_shortcode('[shariff headline="<p>Tool-Testbericht<br/>teilen:</p>" borderradius="1" services="facebook|twitter|googleplus|linkedin|xing" theme="round" orientation="vertical"]');?>
    <!--    </div>-->
    <?php if ( (strlen($produktubersicht) <1) AND (count($zeilen)<2) AND (1 != $neue_ansicht_auch_ohne_content_verwenden) ) { // check if this is a regular tool or a page-like build ?>
        <div id="content" xmlns:background="http://www.w3.org/1999/xhtml" >
            <?php //template for magazinartikel singles//
            //
            /*<div class="hero-header" style="background: url('<?php print $hero_image['url'];?>') no-repeat 50% 0;">
                <div class="wrap">
                    <h2 class="h1"><?php print $h1;?></h2>
                </div>
            </div>*/?>
            <div id="inner-content" class="wrap clearfix magazin-single-wrap  no-hero">
                <div id="main" class="blog-single magazin-single clearfix" role="main">
                    <?php
                    print $produktubersicht;
                    if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php /*<div class="inhaltsverzeichnis-wrap">
                        <ul class="caret-right inhaltsverzeichnis">
                            <p class="index_header">Inhaltsverzeichnis:</p>
                        </ul>
                    </div>*/?>
                        <article style="" id="post-<?php the_ID(); ?>" class="omt-row template-themenwelt" role="article">
                            <header class="article-header">
                                <?php if (strlen($hero_image['url'])>0) { ?><img class="article-hero magazin-hero" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $hero_image['url'];?>" /><?php }?>
                                <h1 class="entry-title single-title has-margin-bottom-30" itemprop="headline"><?php print $h1;?></h1>
                            </header>
                            <section class="entry-content clearfix inhaltseditor" itemprop="articleBody">
                                <?php print $inhalt; ?>
                            </section>
                        </article>
                        <?php comments_template(); ?>
                    <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                <?php //get_sidebar(); ?>
            </div>
        </div>

    <?php }
    if ( (strlen($produktubersicht) <1) AND ( is_array($zeilen) )  AND (1 != $neue_ansicht_auch_ohne_content_verwenden) ) { //if we have 1 or more ZEILEN, this is going to be treated as a PAGE:
        include('library/templates/single-as-page-contentparts-top.php');
        foreach ($zeilen as $zeile) {
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
            if (1 == $alles_730) {
                $rowclass .= " layout-730";
            }
            //////////////////////////////////////SET UP CLASS FOR EACH ROW//////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////////
            if ($zeile['no_margin_bottom'] != false) { $rowclass .= " no-margin-bottom"; }
            ?>
        <section class="wrapper omt-row <?php print $rowclass;?> <?php if (false != $color_area ) { ?>color-area-<?php print $zeile['color_embed']; } ?> <?php if (1==$zeile['content_rotate']) { print "content-rotate"; } ?>">
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

            </section><?php } // end of foreach ROW ?>
        <?php if (strlen($artikel_autor->ID)>0) {?>
            <section class="omt-row wrap artikel-autor">
                <h2 class="no-margin-bottom">Autor des Artikels</h2>
                <?php
                $titel = get_field('titel', $artikel_autor->ID);
                $profilbild = get_field('profilbild', $artikel_autor->ID);
                $firma = get_field('firma', $artikel_autor->ID);
                $speaker_galerie = get_field('speaker_galerie', $artikel_autor->ID);
                $beschreibung = get_field('beschreibung', $artikel_autor->ID);
                $social_media = get_field('social_media', $artikel_autor->ID);
                $speaker_name = get_the_title($artikel_autor->ID);
                $social_media = get_field('social_media', $artikel_autor->ID);
                ?>
                <div class="testimonial card clearfix speakerprofil">
                    <h3 class="experte"><a target="_self"
                                           href="<?php print get_the_permalink($artikel_autor->ID); ?>"><?php print $speaker_name; ?></a>
                    </h3>
                    <div class="testimonial-img">
                        <a target="_self" href="<?php print get_the_permalink($artikel_autor->ID); ?>">
                            <img class="teaser-img" alt="<?php print $speaker_name; ?>"
                                 title="<?php print $speaker_name; ?>"
                                 src="<?php print $profilbild['sizes']['350-180']; ?>"/>
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
            </section>
        <?php } ?>

        <?php //Make a Linklist of all Tools with zeilen-content AKA Tool-Testberichte! ?>
        <section  class="omt-row wrap weitere-vergleiche <?php if (1 == $alles_730) { print "layout-730"; } ?>">
            <h2 class="no-ihv">Weitere Tool-Vergleiche findest Du hier:</h2>
            <?php
            $tools_links = get_posts(array(
                'post_type' => 'tool',
                'posts_per_page'    => -1,
                'post_status' => array( 'publish'),
                'orderby'           => 'title',
                'order'				=> 'ASC',
                'post__not_in' => array(310736, 310740),
            ));
//310736 310740
            foreach ($tools_links as $tool_loop) {
                $ID = $tool_loop->ID;
                $vorschautitel_fur_index = get_field('vorschautitel_fur_index', $ID);
                $zeilen = get_field('zeilen', $ID);
                if (strlen ($vorschautitel_fur_index)>0) { $title = $vorschautitel_fur_index; } else { $title = get_the_title($ID); }
                ?>
                <?php if (is_array($zeilen) AND $ID != get_the_ID()) { // check if this is a regular tool or a page-like build ?>
                    <a class="button button-blue has-margin-bottom-30" style="margin-right: 30px;" href="<?php print get_the_permalink($ID);?>"><?php print $title;?></a>
                <?php }
            }
            ?>
        </section>
        <?php //Make a Linklist of all Tools with zeilen-content AKA Tool-Testberichte!
        ///END OF SPECIFIC TOOL PAGE STUFF


        ///CLOSING OF ALL SECTIONS
        include('library/templates/single-as-page-contentparts-bottom.php');


        ///BANNERWERBUNG
        $bannerbild = get_field('bannerbild');
        $bannerlink = get_field('bannerlink');

        $standardbanner_fur_alle_tools_ausspielen = get_field('standardbanner_fur_alle_tools_ausspielen', 'options');

        if (empty($bannerlink) && (get_field('globales_banner_verwenden_desktop') == 1 || $standardbanner_fur_alle_tools_ausspielen == 1)) {
            $bannerbild = get_field('desktop_standardbanner_tools', 'options');
            $bannerlink = get_field('desktop_standardbanner_tools_link', 'options');
        }

        if (empty($mobile_banner_bild) && (get_field('globales_banner_verwenden_mobile') == 1 || $standardbanner_fur_alle_tools_ausspielen == 1)) {
            $mobile_banner_bild = get_field('mobile_standardbanner_tools', 'options');
            $mobile_banner_link = get_field('mobile_standardbanner_tools_link', 'options');
        }
        ?>
        <?php if (!empty($bannerlink)) : ?>
            <div class="tool-info-image">
                <?php
                $tool_steckbrief_headline_name = get_field('tool_steckbrief_headline_name', 'options');
                $profilbild = get_field('profilbild', 'options');
                $toolsteckbrief_button_linkziel = get_field('toolsteckbrief_button_linkziel', 'options');
                $toolsteckbrief_button_label = get_field('toolsteckbrief_button_label', 'options');
                ?>
                <div class="tools-contact">
                    <div class="widget widget-nochfragen">
                        <?php if (strlen($tool_steckbrief_headline_name)>0) { ?><h4 class="widgettitle"><?php print $tool_steckbrief_headline_name;?></h4><?php } ?>
                        <?php if (strlen($profilbild['url'])>0) { ?><img class="noch-fragen-kontakt" alt="<?php print $profilbild['alt'];?>" title="<?php print $profilbild['alt'];?>" src="<?php print $profilbild['sizes']['350-180'];?>"/><?php } ?>
                        <?php if (strlen($toolsteckbrief_button_linkziel)>0) { ?><a class="button button-350 button-red" href="<?php print $toolsteckbrief_button_linkziel;?>"><?php print $toolsteckbrief_button_label;?></a><?php } ?>
                    </div>
                </div>
                <a class="" href="<?php print $bannerlink;?>" target="_blank" rel="nofollow">
                    <img src="<?php print $bannerbild['url'];?>" alt="<?php print $bannerbild['alt'];?>" title="<?php print $bannerbild['alt'];?>"/>
                </a>
            </div>

        <?php endif ?>
    <?php }
    if ( ( strlen($produktubersicht)>0 ) OR (strlen($wer_verwendet)>0) OR (1 == $neue_ansicht_auch_ohne_content_verwenden) )  {
        $logo = get_field('logo', $ID);
        $toolanbieter = get_field('toolanbieter');
        $info_slider = get_field('info_slider');
        //bild
        //youtube_code
        $funktionen = get_field('funktionen_');
        //funktionsthema_headline
        //beschreibungstext
        //autor
        //testbericht
        $anwendungstipps = get_field('anwendungstipps');
        $anwendungstipps_autor = get_field('anwendungstipps_autor');
        $helper_class = '';
        $get_title = getToolTitle(get_the_title(), $h1, $inhalt, $testbericht_zeilen, $buttons_anzeigen);
            if ( strlen($get_title) > 30 )  {$helper_class = 'tol-name-pos'; }

        ?>
        <div class="tool-header">
            <div id="inner-content" class="wrap clearfix">
                <div class="tool-logo-wrap">
                    <img
                            class="tool-logo"
                            alt="<?php echo get_the_title();?>"
                            title="<?php echo get_the_title();?>"
                            src="<?php echo $logo['url'] ? $logo['url'] : placeholderImage() ?>"
                    />
                </div>
                <div class="tool-about">
                    <div class="tool-name <?=$helper_class;?>">
                        <div class="headline-wrap">
                            <h1><?php echo $get_title; ?></h1>
                            <?php if (1 == $buttons_anzeigen && strlen($zum_toolanbieter) > 0) { ?>
                                <a rel="nofollow" id="<?php print get_the_title();?>" class="" target="_blank" class="header-toolanbieter"  href="<?php print $zum_toolanbieter;?>">
                                    <?php print $website_label;?></a>
                            <?php } ?>
                        </div>
                        <?php if (strlen($toolanbieter)>0) { ?><p><span class="light">von </span><?php print $toolanbieter;?></p><?php } ?>
                    </div>
                    <div class="bewertungen">
                        <div class="rezensionen-wrap"> <?php //https://codepen.io/andreacrawford/pen/NvqJXW ?>
                            <a class="stars-wrap" href="#bewertungen">
                                <?php for ($x = 0; $x < 5; $x++) { ?>
                                    <?php if ($x < floor($gesamt)) { ?><img class="rating rating-header" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                    $starvalue = $gesamt;
                                    if  ( $x == floor($starvalue) ) {
                                        if ($x < round($starvalue))  { //1/2 und 3/4 sterne machen
                                            if ($x < round($starvalue-0.24) ) { //wenn $gesamt mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                                <img class="rating rating-header" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                            <?php } else { //dann hat $gesamt nur zwischen x,5 und x,74 => abrunden! ?>
                                                <img class="rating rating-header" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                            <?php }?>
                                        <?php } else { //$gesamt befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                            if ($x < round($starvalue+0.25) ) { //wenn $gesamt mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                                <img class="rating rating-header" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                            } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                                <img class="rating rating-header" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                            }
                                        }
                                    }
                                    if ( ( $x > $gesamt)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                <?php } ?>
                            </a>
                        </div>
                        <p class="nutzerbewertungen-info ipadup"><?php print $gesamt . "/5 (" . $anzahl_bewertungen . ")";?><a data-effect="lightbox" data-id="form-45" class="activate-form header-bewerten" href="#">>> Jetzt bewerten</a>
                        </p>
                    </div>
                </div>
                <?php
                $rueckruf_button = get_field('rueckruf_button');
                $individueller_button_typ = get_field('individueller_button_typ');
                $individueller_button_text = get_field('individueller_button_text');
                $individueller_button_link = get_field('individueller_button_link');
                $individueller_button_label = get_the_title() . " Demo anfragen";
                if (strlen($individueller_button_text)>0) { $individueller_button_label = $individueller_button_text; }
                $individueller_button_email = get_field('individueller_button_email');
                $individueller_button_email_betreff = get_field('individueller_button_email_betreff');
                if (1 == $rueckruf_button) {
                    switch ($individueller_button_typ) {
                        case "Formular":
                            $ruckruf_formular_id = get_field('ruckruf_formular_id');
                            ?>
                            <div class="buttons-wrap">
                                <span data-effect="lightbox" data-id="form-<?php print $ruckruf_formular_id;?>" href="#" data-backend="toolanbieter-support" class="activate-form tool-lightbox-button button button-testen button-red button-full"><?php print $individueller_button_label;?></span>
                                <div id="form-<?php print $ruckruf_formular_id;?>" class="contact-lightbox hidden">
                                    <?php echo do_shortcode( '[gravityform ajax=true id="' . $ruckruf_formular_id . '" title="false" description="true" tabindex="0"]' ); ?>
                                </div>
                            </div>
                            <div id="form-<?php print $ruckruf_formular_id;?>" class="contact-lightbox hidden">
                                <?php echo do_shortcode( '[gravityform ajax=true id="' . $ruckruf_formular_id . '" title="false" description="true" tabindex="0"]' ); ?>
                            </div>
                            <?php
                            break;

                        case "Email": ?>
                            <div class="buttons-wrap">
                                <a
                                        class="button button-testen button-red button-full"
                                        href="mailto:<?php print $individueller_button_email;?><?php if (strlen($individueller_button_email_betreff)>0) { print "?subject="; print str_replace(" "," ", $individueller_button_email_betreff); } ?>">
                                    <?php print $individueller_button_label;?>
                                </a>

                            </div>
                            <?php break;

                        case "Link": ?>
                            <div class="buttons-wrap">
                                <a class="button button-testen button-red button-full" target="_blank"
                                   href="<?php print $individueller_button_link;?>">
                                    <?php print $individueller_button_label;?>
                                </a>
                            </div>
                            <?php break;

                            break;
                    }
                } else {

                    if (1 == $buttons_anzeigen) { ?>
                        <div class="buttons-wrap">
                            <?php if (strlen($tool_gratis_testen_link)>0) { ?><a rel="nofollow" id="<?php print get_the_title();?>"  target="_blank" class="button button-testen button-red button-350px"  href="<?php print $tool_gratis_testen_link;?>"><?php print $testen_label;?></a><?php } ?>
                            <?php if (strlen($tool_preisubersicht)>0) { ?><a rel="nofollow" id="<?php print get_the_title();?>" target="_blank" class="button button-pricing button-lightgrey button-350px"  href="<?php print $tool_preisubersicht;?>"><?php print $preise_label;?></a><?php } ?>
                        </div>
                    <?php }
                }
                if( strlen($buttons_anzeigen) == 0 ) { ?>
                    <div id="toolskontakt" class="widget widget-nochfragen widget-toolskontakt">
                        <h4 class="widgettitle">Ist das Dein Tool?<br>Möchtest Du es aktualisieren oder vermarkten?</h4>
                        <div class="buttons-wrap">
                            <a class="button button-testen button-red button-350px" href="/online-marketing-tools/kontakt/">Schick uns eine E-Mail</a>
                        </div>
                    </div>

                    <?php
                    /* echo '<div class="buttons-wrap">
                             <a class="button button-testen button-red button-350px" href="mailto:christos.pipsos@omt.de?cc=mario@omt.de&subject=Ich%20möchte%20mein%20Tool%20beim%20OMT%20Toolvergleich%20anpassen">Dein Tool?</a>
                         </div>' ;*/
                }
                ?>
            </div>
            <div class="tool-navigation-wrap">
                <ul class="tool-navigation wrap">
                    <li class="ipadup"><a class="active" href="#ubersicht">Übersicht</a></li>
                    <?php if (strlen($funktionen[0]['funktionsthema_headline'])>0) { ?><li><a href="#funktionen">Funktionen</a></li><?php } ?>
                    <li><a href="#bewertungen">Bewertungen</a></li>
                    <?php //////////////******** CHECKING IF REZENSIONEN AVAILABLE TO PRESENT LINK IF MIGHT BE SO

                    if (USE_JSON_POSTS_SYNC) {
                        $toolReviews = [];
                        $url = get_template_directory() . '/library/tools/rezensionen/' . $post_id . '.json';

                        if (file_exists($url) && is_file($url)) {
                            $content_json = file_get_contents($url);
                            $toolReviews = (array) json_decode($content_json, true);
                        }
                    } else {
                        $toolReviews = ToolReview::init()->activeItems(['tool' => $post_id], [
                            'order' => 'post_date',
                            'order_dir' => 'DESC'
                        ]);
                    }

                    if (count($toolReviews)) { ?><li class="ipadup"><a href="#rezensionen">Rezensionen</a></li><?php } ?>
                    <?php //////*************CHECKING IF ALTERNATIVEN AVAILABLE TO PRESENT LINK IF SO
                    $currentID = get_the_ID();
                    $terms = get_the_terms(get_the_ID(), 'tooltyp');
                    $termids = array();
                    foreach ($terms as $term) {
                        $termids[] = $term->term_id;
                    }
                    $category_id = $terms[0]->cat_ID;

                    if (USE_JSON_POSTS_SYNC) {
                        $url = get_template_directory() . '/library/json/tools.json';
                        $content_json = file_get_contents($url);
                        $json = json_decode($content_json, true);
                        $show = 0;

                        ArraySort::toolsBySponsored($json);

                        foreach ($json as $jsontool) {
                            $post_status = $jsontool['$post_status'];
                            $jsonID = $jsontool['ID'];
                            $is_term = 0;
                            if (is_array($jsontool['$terms'])) {
                                foreach ($jsontool['$terms'] as $term) {
                                    if (in_array($term['term_id'], $termids)) {
                                        $is_term = 1;
                                    }
                                }
                            }
                            if ( ( 1 == $is_term ) AND ($show < 3) AND ("private" != $post_status ) AND ( $jsonID != $post_id ) ) {
                                $show++;
                            }
                        }
                    } else {
                        $alternativeTools = MarketingTool::init()->alternatives($post_id, $termids);
                        $show = count($alternativeTools) ?: 0;
                    }

                    if ($show > 0) {?><li class="<?php if ( is_array($anwendungstipps) ) { print "ipadup"; }?>"><a href="#alternativen">Alternativen</a></li><?php } ?>
                    <?php if ( ( ( strlen($h1)>0 ) AND (strlen($inhalt)>0) ) OR ( is_array($testbericht_zeilen)) ) { ?>
                        <li><a href="#testbericht"><?php print $testbericht_menu_title;?></a></li>
                    <?php } ?>
                    <?php if ( is_array($experten_agenturen) ) { ?><li><a href="#agenturen">Agenturen</a></li><?php } ?>
                    <?php if ( is_array($anwendungstipps) ) { ?><li><a href="#anwendungstipps"><?php print $anwendungstipps_menu_title;?></a></li><?php } ?>
                    <?php if ($flexibleAreaEnabled) : ?>
                        <li><a href="<?php echo get_field('flexible_area_anchor') ?>"><?php echo get_field('flexible_area_title') ?></a></li>
                    <?php endif ?>
                </ul>
            </div>
            <?php if (1 == $buttons_anzeigen) { ?>
                <div class="tool-scrolled-links-wrap">
                    <ul class="scrolled-links wrap">
                        <?php if (strlen($tool_gratis_testen_link)>0) { ?><li><a rel="nofollow" target="_blank" class=""  href="<?php print $tool_gratis_testen_link;?>">Gratis Testen!</a></li><?php } ?>
                        <?php if (strlen($tool_preisubersicht)>0) { ?> <li><a rel="nofollow" target="_blank" class=""  href="<?php print $tool_preisubersicht;?>">Preisübersicht</a></li><?php } ?>
                        <?php if (strlen($zum_toolanbieter)>0) { ?><li><a rel="nofollow" target="_blank" class=""  href="<?php print $zum_toolanbieter;?>">Zum Toolanbieter</a></li><?php } ?>
                    </ul>
                </div>
            <?php  } ?>
        </div>
        <div id="content" xmlns:background="http://www.w3.org/1999/xhtml">
        <div id="inner-content" class="wrap clearfix no-hero">
            <div class="omt-row tool-abschnitt tool-uebersicht">
                <span class="anchor" id="ubersicht"></span>
                <div class="half left-half">
                    <div class="info-container half-reduced">
                        <div class="wer-verwendet">
                            <?php if (strlen($wer_verwendet)>0) {?>
                                <h2 class="no-ihv">Wer verwendet <?php print get_the_title();?>?</h2>
                                <?php
                                $cleaned_wer_verwendet = removeLink($wer_verwendet);
                                print $cleaned_wer_verwendet;
                            }
                            ?><?php
                            if (strlen($produktubersicht)>0) { ?>
                                <h2 class="no-ihv">Was ist <?php print get_the_title(); ?>?</h2>
                                <?php
                                $cleaned_produktubersicht = removeLink($produktubersicht);
                                print $cleaned_produktubersicht;
                            } ?>
                        </div>
                    </div>
                    <div class="more-info">Mehr Infos</div>
                </div>
                <?php if ( (strlen($info_slider[0]['bild']['url'])>0) OR ( strlen($info_slider[0]['youtube_code']) >0) OR ( strlen($info_slider[0]['wistia_code']) >0) ) { ?>
                <div class="half right-half">
                    <div class="tool-slider">
                        <?php foreach ($info_slider as $key => $slide) {
                        if (strlen($slide['bild']['url']) > 0) { $type = "image"; }
                        if (strlen($slide['youtube_code'])>0) { $type="youtube"; }
                        if (strlen($slide['wistia_code'])>0) { $type="wistia"; }

                        switch ($type) {
                        case "image": ?>
                            <div class="slide">
                                <img
                                        class="no-ll tool-slider-image"
                                        alt="<?php print $slide['bild']['alt'];?>"
                                        title="<?php print $slide['bild']['alt'];?>"

                                    <?php if ($key == 0) : ?>
                                        src="<?php print $slide['bild']['sizes']['550-290'];?>"
                                    <?php else : ?>
                                        data-lazy="<?php print $slide['bild']['sizes']['550-290'];?>"
                                    <?php endif; ?>
                                />
                            </div>
                            <?php break; ?>

                        <?php case "youtube": ?>
                            <div class="slide">
                                <div class="vidembed_wrap">
                                    <div class="tool-youtube-wrap">
                                        <div class="tool-youtube" data-embed="<?php echo $slide['youtube_code'] ?>">
                                            <div class="play-button"></div>

                                            <img
                                                    class="no-ll tool-slider-image"

                                                <?php if ($key == 0) : ?>
                                                    src="<?php echo getYoutubeThumb($slide['youtube_code']) ?>"
                                                <?php else : ?>
                                                    data-lazy="<?php echo getYoutubeThumb($slide['youtube_code']) ?>"
                                                <?php endif; ?>
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php break; ?>

                        <?php case "wistia": ?>
                        <div class="slide">
                            <div class="video_wrap">
                                <div class="webinar-video">
                                    <div class="video-wrap">
                                        <?php if ( ( !is_user_logged_in() ) AND (strlen($slide['wistia_code_emailschranke'])>0) ) { ?>
                                        <div class="slide-nav tool-wistia" data-embed="<?php print $slide['wistia_code_emailschranke'];?>">
                                            <?php } else { ?>
                                            <div class="slide-nav tool-wistia" data-embed="<?php print $slide['wistia_code'];?>">
                                                <?php } ?>
                                                <div class="play-icon-wrapper">
                                                    <div class="tri"></div>
                                                </div>
                                                <?php if (strlen($slide['bild']['url']) > 0) : ?>
                                                    <img
                                                            class="no-ll tool-slider-image"
                                                            alt="<?php print $slide['bild']['alt'];?>"
                                                            title="<?php print $slide_nav['bild']['alt'];?>"
                                                            width="<?php print $slide['bild']['sizes']['550-290-width'];?>"
                                                            height="<?php print $slide['bild']['sizes']['550-290-height'];?>"

                                                        <?php if ($key == 0) : ?>
                                                            src="<?php print $slide['bild']['sizes']['550-290'];?>"
                                                        <?php else : ?>
                                                            data-lazy="<?php print $slide['bild']['sizes']['550-290'];?>"
                                                        <?php endif; ?>
                                                    />
                                                <?php else : ?>
                                                    <img
                                                            class="no-ll tool-slider-image"

                                                        <?php if ($key == 0) : ?>
                                                            src="/uploads/OMT-Videoplayer-Screen-290x150px.jpg"
                                                        <?php else : ?>
                                                            data-lazy="/uploads/OMT-Videoplayer-Screen-290x150px.jpg"
                                                        <?php endif; ?>
                                                    />
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php break; ?>
                            <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="tool-slider-nav">
                            <?php foreach ( $info_slider as $slide_nav) {
                                if (strlen($slide_nav['bild']['url']) > 0) { ?>
                                    <div class="slide-nav">
                                        <img
                                                class="no-ll tool-slider-image nav-slider-image"
                                                alt="<?php print $slide_nav['bild']['alt'];?>"
                                                title="<?php print $slide_nav['bild']['alt'];?>"
                                                src="<?php print $slide_nav['bild']['sizes']['350-180'];?>"
                                                width="<?php print $slide['bild']['sizes']['350-180-width'];?>"
                                                height="<?php print $slide['bild']['sizes']['350-180-height'];?>"
                                        />
                                    </div>
                                <?php } else { ?>
                                    <div class="slide-nav"><img class="no-ll tool-slider-image nav-slider-image" src="/uploads/OMT-Videoplayer-Screen-290x150px.jpg"/></div>
                                <?php } ?>
                            <?php }?>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <?php if (strlen($funktionen[0]['funktionsthema_headline'])>0) { ?>
                    <div class="omt-row tool-abschnitt tool-funktionen accordion">
                        <span class="anchor" id="funktionen"></span>
                        <h2><?php print get_the_title();?> Funktionen</h2>
                        <div class="omt-module accordion">
                            <?php foreach ($funktionen as $item) { ?>
                                <div class="tools-accordion-item initial-closed">
                                    <h3 class="tools-accordion-title"><?php print $item['funktionsthema_headline'];?><span class="fa fa-plus"></span></h3>
                                    <div class="tools-accordion-content semi-closed">
                                        <?php print $item['beschreibungstext'];?>
                                    </div>
                                    <div class="button button-weiterlesen button-full button-visible">Weiterlesen</div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php }?>

                <div class="omt-row wrap tool-abschnitt  tool-nutzerbewertungen">
                    <span class="anchor" id="bewertungen"></span>
                    <h2 class="no-ihv"><?php print get_the_title();?> Bewertungen / Erfahrungen</h2>
                    <div class="nutzerbewertungen-box">
                        <p class="nutzerbewertungen-info">Diese <?php print get_the_title();?>-Bewertungen werden automatisch aus <?php print $anzahl_bewertungen;?> eingereichten Nutzer-Erfahrungen ermittelt.</p>
                        <div class="rezensionen-wrap"> <?php //https://codepen.io/andreacrawford/pen/NvqJXW ?>
                            <div class="bewertung-zeile">
                                <span class="title"><b>Gesamt</b></span>
                                <div class="rating">
                                    <div class="stars-wrap">
                                        <?php for ($x = 0; $x < 5; $x++) { ?>
                                            <?php if ($x < floor($gesamt)) { ?><img class="rating " width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                            $starvalue = $gesamt;
                                            if  ( $x == floor($starvalue) ) {
                                                if ($x < round($starvalue))  { //1/2 und 3/4 sterne machen
                                                    if ($x < round($starvalue-0.24) ) { //wenn $gesamt mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                                    <?php } else { //dann hat $gesamt nur zwischen x,5 und x,74 => abrunden! ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                                    <?php }?>
                                                <?php } else { //$gesamt befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                                    if ($x < round($starvalue+0.25) ) { //wenn $gesamt mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                                    } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                    }
                                                }
                                            }
                                            if ( ( $x > $gesamt)) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                        <?php } ?>
                                    </div>
                                    <strong class="rating-value"><?php print $gesamt;?>/5</strong>
                                </div>
                            </div>
                            <div class="bewertung-zeile">
                                <span class="title">Benutzerfreundlichkeit</span>
                                <div class="rating">
                                    <div class="stars-wrap">
                                        <?php for ($x = 0; $x < 5; $x++) { ?>
                                            <?php if ($x < floor($rezension['$bewertung_benutzerfreundlichkeit'])) { ?><img class="rating " width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                            $starvalue = $rezension['$bewertung_benutzerfreundlichkeit'];
                                            if  ( $x == floor($starvalue) ) {
                                                if ($x < round($starvalue))  { //1/2 und 3/4 sterne machen
                                                    if ($x < round($starvalue-0.24) ) { //wenn $gesamt mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                                    <?php } else { //dann hat $gesamt nur zwischen x,5 und x,74 => abrunden! ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                                    <?php }?>
                                                <?php } else { //$gesamt befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                                    if ($x < round($starvalue+0.25) ) { //wenn $gesamt mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                                    } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                    }
                                                }
                                            }
                                            if ( ( $x > $rezension['$bewertung_benutzerfreundlichkeit'])) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                        <?php } ?>
                                    </div>
                                    <span class="rating-value"><?php print $rezension['$bewertung_benutzerfreundlichkeit'];?>/5</span>
                                </div>
                            </div>
                            <div class="bewertung-zeile">
                                <span class="title">Support / Kundenbetreuung</span>
                                <div class="rating">
                                    <div class="stars-wrap">
                                        <?php for ($x = 0; $x < 5; $x++) { ?>
                                            <?php if ($x < floor($rezension['$bewertung_support'])) { ?><img class="rating " width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                            $starvalue = $rezension['$bewertung_support'];
                                            if  ( $x == floor($starvalue) ) {
                                                if ($x < round($starvalue))  { //1/2 und 3/4 sterne machen
                                                    if ($x < round($starvalue-0.24) ) { //wenn $gesamt mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                                    <?php } else { //dann hat $gesamt nur zwischen x,5 und x,74 => abrunden! ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                                    <?php }?>
                                                <?php } else { //$gesamt befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                                    if ($x < round($starvalue+0.25) ) { //wenn $gesamt mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                                    } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                    }
                                                }
                                            }
                                            if ( ( $x > $rezension['$bewertung_support'])) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                        <?php } ?>
                                    </div>
                                    <span class="rating-value"><?php print $rezension['$bewertung_support'];?>/5</span>
                                </div>
                            </div>
                            <div class="bewertung-zeile">
                                <span class="title">Eigenschaften & Funktionalitäten</span>
                                <div class="rating">
                                    <div class="stars-wrap">
                                        <?php for ($x = 0; $x < 5; $x++) { ?>
                                            <?php if ($x < floor($rezension['$bewertung_funktionalitaten'])) { ?><img class="rating " width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                            $starvalue = $rezension['$bewertung_funktionalitaten'];
                                            if  ( $x == floor($starvalue) ) {
                                                if ($x < round($starvalue))  { //1/2 und 3/4 sterne machen
                                                    if ($x < round($starvalue-0.24) ) { //wenn $gesamt mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                                    <?php } else { //dann hat $gesamt nur zwischen x,5 und x,74 => abrunden! ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                                    <?php }?>
                                                <?php } else { //$gesamt befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                                    if ($x < round($starvalue+0.25) ) { //wenn $gesamt mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                                    } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                    }
                                                }
                                            }
                                            if ( ( $x > $rezension['$bewertung_funktionalitaten'])) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                        <?php } ?>
                                    </div>
                                    <span class="rating-value"><?php print $rezension['$bewertung_funktionalitaten'];?>/5</span>
                                </div>
                            </div>
                            <div class="bewertung-zeile">
                                <span class="title">Preis-Leistungs-Verhältnis</span>
                                <div class="rating">
                                    <div class="stars-wrap">
                                        <?php for ($x = 0; $x < 5; $x++) { ?>
                                            <?php if ($x < floor($rezension['$bewertung_preisleistung'])) { ?><img class="rating " width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                            $starvalue = $rezension['$bewertung_preisleistung'];
                                            if  ( $x == floor($starvalue) ) {
                                                if ($x < round($starvalue))  { //1/2 und 3/4 sterne machen
                                                    if ($x < round($starvalue-0.24) ) { //wenn $gesamt mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                                    <?php } else { //dann hat $gesamt nur zwischen x,5 und x,74 => abrunden! ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                                    <?php }?>
                                                <?php } else { //$gesamt befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                                    if ($x < round($starvalue+0.25) ) { //wenn $gesamt mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                                    } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                    }
                                                }
                                            }
                                            if ( ( $x > $rezension['$bewertung_preisleistung'])) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                        <?php } ?>
                                    </div>
                                    <span class="rating-value"><?php print $rezension['$bewertung_preisleistung'];?>/5</span>
                                </div>
                            </div>
                            <div class="bewertung-zeile">
                                <span class="title">Wahrscheinlichkeit der Weiterempfehlung</span>
                                <div class="rating">
                                    <div class="stars-wrap">
                                        <?php for ($x = 0; $x < 5; $x++) { ?>
                                            <?php if ($x < floor($rezension['$bewertung_wahrscheinlichkeit_weiterempfehlung'])) { ?><img class="rating " width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                            $starvalue = $rezension['$bewertung_wahrscheinlichkeit_weiterempfehlung'];
                                            if  ( $x == floor($starvalue) ) {
                                                if ($x < round($starvalue))  { //1/2 und 3/4 sterne machen
                                                    if ($x < round($starvalue-0.24) ) { //wenn $gesamt mindestens x,75 hat, wird aufgerundet => 3/4 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-75.svg"/>
                                                    <?php } else { //dann hat $gesamt nur zwischen x,5 und x,74 => abrunden! ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/>
                                                    <?php }?>
                                                <?php } else { //$gesamt befindet sich im Bereich 0 bis 0,49 = 0 oder 1/4 sterne
                                                    if ($x < round($starvalue+0.25) ) { //wenn $gesamt mindestens x,25 hat, wird ein Wert >x,5 erreicht und somit aufgerundet => 1/4 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-25.svg"/><?php
                                                    } else { //der Wert muss unter x.25 liegen, wenn weiterhin abgerundet wird => 0 Sterne ?>
                                                        <img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                    }
                                                }
                                            }
                                            if ( ( $x > $rezension['$bewertung_wahrscheinlichkeit_weiterempfehlung'])) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                        <?php } ?>
                                    </div>
                                    <span class="rating-value"><?php print $rezension['$bewertung_wahrscheinlichkeit_weiterempfehlung'];?>/5</span>
                                </div>
                            </div>
                        </div>
                        <div class="tool-bewerten">
                            <a data-effect="lightbox" data-id="form-45" class="activate-form button button-red" href="#"><?php print get_the_title();?> jetzt bewerten</a>
                            <div id="form-45" class="contact-lightbox hidden">
                                <?php echo do_shortcode( '[gravityform ajax=true id="48" title="true" description="true" tabindex="0"]' ); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (USE_JSON_POSTS_SYNC) : ?>
                    <?php if (count($toolReviews)) { ?>
                        <div class="omt-row tool-abschnitt tool-rezensionen">
                            <span class="anchor" id="rezensionen"></span>
                            <h2 class="no-ihv"><?php print get_the_title();?> Rezensionen</h2>
                            <div class="rezensionen"> <?php //https://codepen.io/andreacrawford/pen/NvqJXW
                                ?>
                                <?php foreach ($toolReviews as $rezension) { ?>
                                    <div class="rezension clearfix">
                                        <div class="half left-half">
                                            <h3> <?php
                                                $name_length = strlen($rezension['$vorname']);
                                                $surname_length = strlen($rezension['$nachname']);
                                                $result_length = $name_length + $surname_length;
                                                $seperator = '';
                                                //Check if name and lastname combined is more than 15 character
                                                //if character number is more than 15 use <br> tag else use &nbsp
                                                if(omt_check_string_length($result_length)){$seperator = "<br>";}else{$seperator = "&nbsp;";}
                                                print $rezension['$vorname'] . $seperator . $rezension['$nachname']; ?>
                                            </h3>
                                            <div class="social-media">
                                                <?php if (strlen($rezension['$facebook'])>0) { ?><a rel=“nofollow“ target="_blank" class="social-icon" href="<?php print trim($rezension['$facebook']) ?>"><i class="fa fa-facebook"></i></a><?php } ?>
                                                <?php if (strlen($rezension['$xing'])>0) { ?><a rel=“nofollow“ target="_blank" class="social-icon" href="<?php print trim($rezension['$xing']) ?>"><i class="fa fa-xing"></i></a><?php } ?>
                                                <?php if (strlen($rezension['$linkedin'])>0) { ?><a rel=“nofollow“ target="_blank" class="social-icon" href="<?php print trim($rezension['$linkedin']) ?>"><i class="fa fa-linkedin"></i></a><?php } ?>
                                                <!--                                            --><?php //if (strlen($rezension['$twitter'])>0) { ?><!--<a target="_blank" class="social-icon" href="--><?php //print $rezension['$twitter'];?><!--"><i class="fa fa-twitter"></i></a>--><?php //} ?>
                                                <!--                                            --><?php //if (strlen($rezension['$instagram'])>0) { ?><!--<a target="_blank" class="social-icon" href="--><?php //print $rezension['$instagram'];?><!--"><i class="fa fa-instagram"></i></a>--><?php //} ?>
                                                <!--                                            --><?php //if (strlen($rezension['$tiktok'])>0) { ?><!--<a target="_blank" class="social-icon" href="--><?php //print $rezension['$tiktok'];?><!--"><i class="fa fa-home"></i></a>--><?php //} ?>
                                            </div>
                                            <ul>
                                                <li><?php print $rezension['$jobbezeichnung'];?></li>
                                                <?php if (strlen($rezension['$website'])>0) {
                                                    $rezension_website_nohttps = str_replace("https://", "", $rezension['$website']);
                                                    $rezension_website_nohttp = str_replace("http://", "", $rezension_website_nohttps);
                                                    $rezension_website = "https://" . $rezension_website_nohttp;
                                                    ?><li><a rel=“nofollow“ target="_blank" href="<?php print trim($rezension_website) ?>"><?php print $rezension['$unternehmen'];?></a></li><?php } else { ?>
                                                    <li><?php print $rezension['$unternehmen'];?></li> <?php }?>
                                            </ul>
                                        </div>
                                        <div class="half right-half">
                                            <div class="rezensionen-wrap"> <?php //https://codepen.io/andreacrawford/pen/NvqJXW ?>
                                                <div class="bewertung-zeile">
                                                    <span class="title"><b>Gesamt</b></span>
                                                    <div class="rating">
                                                        <div class="stars-wrap">
                                                            <?php for ($x = 0; $x < 5; $x++) { ?>
                                                                <?php if ($x < floor($rezension['$bewertungsschnitt'])) { ?><img class="rating " width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                                                if  ( $x == floor($rezension['$bewertungsschnitt']) ) {
                                                                    if ($x < round($rezension['$bewertungsschnitt']))  {
                                                                        ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/><?php } else {
                                                                        ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                                    }
                                                                }
                                                                if ( ( $x > $rezension['$bewertungsschnitt'])) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bewertung-zeile">
                                                    <span class="title">Benutzerfreundlichkeit</span>
                                                    <div class="rating">
                                                        <div class="stars-wrap">
                                                            <?php for ($x = 0; $x < 5; $x++) { ?>
                                                                <?php if ($x < floor($rezension['$bewertung_benutzerfreundlichkeit'])) { ?><img class="rating " width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                                                if  ( $x == floor($rezension['$bewertung_benutzerfreundlichkeit']) ) {
                                                                    if ($x < round($rezension['$bewertung_benutzerfreundlichkeit']))  {
                                                                        ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/><?php } else {
                                                                        ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                                    }
                                                                }
                                                                if ( ( $x > $rezension['$bewertung_benutzerfreundlichkeit'])) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bewertung-zeile">
                                                    <span class="title">Kundenservice</span>
                                                    <div class="rating">
                                                        <div class="stars-wrap">
                                                            <?php for ($x = 0; $x < 5; $x++) { ?>
                                                                <?php if ($x < floor($rezension['$bewertung_support'])) { ?><img class="rating " width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                                                if  ( $x == floor($rezension['$bewertung_support']) ) {
                                                                    if ($x < round($rezension['$bewertung_support']))  {
                                                                        ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/><?php } else {
                                                                        ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                                    }
                                                                }
                                                                if ( ( $x > $rezension['$bewertung_support'])) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bewertung-zeile">
                                                    <span class="title">Funktionen</span>
                                                    <div class="rating">
                                                        <div class="stars-wrap">
                                                            <?php for ($x = 0; $x < 5; $x++) { ?>
                                                                <?php if ($x < floor($rezension['$bewertung_funktionalitaten'])) { ?><img class="rating " width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                                                if  ( $x == floor($rezension['$bewertung_funktionalitaten']) ) {
                                                                    if ($x < round($rezension['$bewertung_funktionalitaten']))  {
                                                                        ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/><?php } else {
                                                                        ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                                    }
                                                                }
                                                                if ( ( $x > $rezension['$bewertung_funktionalitaten'])) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bewertung-zeile">
                                                    <span class="title">Preis-Leistung</span>
                                                    <div class="rating">
                                                        <div class="stars-wrap">
                                                            <?php for ($x = 0; $x < 5; $x++) { ?>
                                                                <?php if ($x < floor($rezension['$bewertung_preisleistung'])) { ?><img class="rating " width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                                                if  ( $x == floor($rezension['$bewertung_preisleistung']) ) {
                                                                    if ($x < round($rezension['$bewertung_preisleistung']))  {
                                                                        ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/><?php } else {
                                                                        ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                                    }
                                                                }
                                                                if ( ( $x > $rezension['$bewertung_preisleistung'])) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bewertung-zeile">
                                                    <span class="title">Weiterempfehlung</span>
                                                    <div class="rating">
                                                        <div class="stars-wrap">
                                                            <?php for ($x = 0; $x < 5; $x++) { ?>
                                                                <?php if ($x < floor($rezension['$bewertung_wahrscheinlichkeit_weiterempfehlung'])) { ?><img class="rating " width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-full.svg"/><?php }
                                                                if  ( $x == floor($rezension['$bewertung_wahrscheinlichkeit_weiterempfehlung']) ) {
                                                                    if ($x < round($rezension['$bewertung_wahrscheinlichkeit_weiterempfehlung']))  {
                                                                        ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-half.svg"/><?php } else {
                                                                        ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php
                                                                    }
                                                                }
                                                                if ( ( $x > $rezension['$bewertung_wahrscheinlichkeit_weiterempfehlung'])) { ?><img class="rating" width="158" height="150" src="/wp-content/themes/omt/library/images/svg/icon-star-empty.svg"/><?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rezension-text">
                                            <h3 class="h4">„<?php print strip_tags($rezension['$wenn_du_das_tool_beschreiben_musstest']);?>“</h3>
                                            <strong>Vorteile von <?php print get_the_title();?></strong>
                                            <?php print $rezension['$vorteile_des_tools'];?>
                                            <strong>Nachteile von <?php print get_the_title();?></strong>
                                            <?php print $rezension['$nachteile_des_tools'];?>
                                            <strong>Beste Funktionen von <?php print get_the_title();?></strong>
                                            <?php print $rezension['$welche_funktionen_des_tools_nutzt_du_am_liebsten'];?>
                                            <strong>Allgemeines Fazit zu <?php print get_the_title();?></strong>
                                            <?php print $rezension['$allgemeines_fazit_zu_dem_tool'];?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php else : ?>
                    <?php echo ToolView::loadTemplate('reviews', [
                        'reviews' => $toolReviews
                    ]) ?>
                <?php endif ?>

                <?php if ($show > 0) { ?>
                    <div class="omt-row tool-abschnitt tool-alternativen wrap grid-wrap">
                        <span class="anchor" id="alternativen"></span>
                        <?php if (1 == $alternativseite_anzeigen) { ?>
                            <h2 class="no-ihv"><a href="<?php print $_SERVER['REQUEST_URI'];?>alternativen/"><?php print get_the_title();?> Alternativen</a></h2>
                        <?php } else { ?>
                            <h2 class="no-ihv"><?php print get_the_title();?> Alternativen</h2>
                        <?php } ?>
                        <div class="omt-module teaser-modul">
                            <?php
                            $currentID = get_the_ID();
                            $terms = get_the_terms(get_the_ID(), 'tooltyp');
                            $termids = array();
                            foreach ($terms as $term) {
                                $termids[] = $term->term_id;
                            }
                            $category_id = $terms[0]->cat_ID;

                            if (is_array($manuell_ausgewahlte_alternativen)) {
                                foreach ($manuell_ausgewahlte_alternativen as $alternative) {
                                    $logofield = get_field('logo', $alternative);
                                    $logo = $logofield['sizes']['350-180'];
                                    $gesamt = get_field('gesamt', $alternative);
                                    $anzahl_bewertungen = get_field('anzahl_bewertungen', $alternative);
                                    $title = get_field('vorschautitel_fur_index', $alternative);
                                    $link = get_the_permalink($alternative);
                                    if (!isset($anzahl_bewertungen)) {
                                        $anzahl_bewertungen = 0;
                                    }

                                    include('library/templates/single-tool-alternativen.php');
                                }
                            } else {
                                if (USE_JSON_POSTS_SYNC) {
                                    $url = get_template_directory() . '/library/json/tools.json';
                                    $content_json = file_get_contents($url);
                                    $json = json_decode($content_json, true);
                                    $show = 0;

                                    ArraySort::toolsBySponsored($json);

                                    foreach ($json as $jsontool) {
                                        $post_status = $jsontool['$post_status'];
                                        $jsonID = $jsontool['ID'];
                                        $is_term = 0;

                                        if (is_array($jsontool['$terms'])) {
                                            foreach ($jsontool['$terms'] as $term) {
                                                if (in_array($term['term_id'], $termids)) {
                                                    $is_term = 1;
                                                }
                                            }
                                        }

                                        if ((1 == $is_term) AND ($show < 3) AND ("private" != $post_status) AND ($jsonID != $post_id)) {
                                            $show++;
                                            $logo = $jsontool['$logo'];
                                            $gesamt = $jsontool['$wertung_gesamt'];
                                            $anzahl_bewertungen = $jsontool['$anzahl_bewertungen'];
                                            $title = $jsontool['$title'];
                                            $link = $jsontool['$link'];
                                            if (!isset($anzahl_bewertungen)) {
                                                $anzahl_bewertungen = 0;
                                            }
                                            include('library/templates/single-tool-alternativen.php');
                                        }
                                    }
                                } else {
                                    foreach ($alternativeTools as $alternativeTool) {
                                        echo ToolView::loadTemplate('alternative-tool', [
                                            'tool' => $alternativeTool
                                        ]);
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php }?>
                <?php if ( ( strlen($h1)>0 ) ) {
                $autor=get_field('autor');
                $autor_2=get_field('autor_2');
                $testbericht_lesezeit=get_field('testbericht_lesezeit');
                $titelbild = get_field('titelbild');?>
                <span class="anchor" id="testbericht"></span>
                <?php
                if (strlen($titelbild['url'])>0) {?>
                    <img class="article-hero magazin-hero testbericht-hero" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $titelbild['url'];?>" style="margin-bottom: 0px !important;"/>
                <?php }
                if ($autor->ID > 0) {
                    $autor = get_field('autor');
                    $autor_2 = get_field('autor_2');
                    $titel = get_field('titel', $autor->ID);
                    $profilbild = get_field('profilbild', $autor->ID);
                    $firma = get_field('firma', $autor->ID);
                    $speaker_galerie = get_field('speaker_galerie', $autor->ID);
                    $beschreibung = get_field('beschreibung', $autor->ID);
                    $social_media = get_field('social_media', $autor->ID);
                    $speaker_name = get_the_title($autor->ID);
                    $social_media = get_field('social_media', $autor->ID);
                    ?>
                    <div class="info-wrap" style="max-width: 730px;margin:60px auto 0 auto;">
                        <p class="text-red" style="margin-bottom: 0px;"><?php if ($testbericht_lesezeit>0) { ?><strong>Lesezeit: <?php print $testbericht_lesezeit;?> Min</strong> <span class="artikel-divider">|</span>&nbsp;<?php } ?><span class="artikel-autor">Autor:
                                <a target="_blank" href="<?php print get_the_permalink($autor->ID); ?>"><?php print $speaker_name; ?></a>
                            </span>  </p>
                    </div>
                <?php }
                if (is_array($testbericht_zeilen)) { ?>
                <div class="omt-row tool-abschnitt tool-testbericht wrap" style="margin-top: 30px !important;">
                    <h2><?php print $h1; ?></h2>
                    <div class="inhaltsverzeichnis-wrap">
                        <div class="omt-row wrap no-margin-bottom no-margin-top placeholder-730"></div>
                    </div>
                    <?php foreach ($testbericht_zeilen as $zeile) {
                    $rowclass = "";
                    $color_area = true;
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
                    <div class="omt-row wrap tool-abschnitt tool-zeile layout-730 <?php print $rowclass;?> <?php if (false != $color_area ) { ?>color-area-<?php print $zeile['color_embed']; } ?> <?php if (1==$zeile['content_rotate']) { print "content-rotate"; } ?>">
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
                </div>
            <?php }
            if ($autor->ID > 0) {

                ?>
                <div class="testimonial card clearfix speakerprofil">
                    <h3 class="experte"><a target="_self"
                                           href="<?php print get_the_permalink($autor->ID); ?>"><?php print $speaker_name; ?></a>
                    </h3>
                    <div class="testimonial-img">
                        <a target="_self" href="<?php print get_the_permalink($autor->ID); ?>">
                            <?php if (strlen($profilbild['sizes']['350-180'])>0) { ?>
                            <img class="teaser-img" alt="<?php print $speaker_name; ?>"
                                 title="<?php print $speaker_name; ?>"
                                 src="<?php print $profilbild['sizes']['350-180']; ?>"/>
                    <?php } ?>
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
                                    <a target="_blank" class="social-icon" href="<?php print trim($social['link']) ?>">
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
            if ($autor_2->ID > 0) {
                $titel = get_field('titel', $autor_2->ID);
                $profilbild = get_field('profilbild', $autor_2->ID);
                $firma = get_field('firma', $autor_2->ID);
                $speaker_galerie = get_field('speaker_galerie', $autor_2->ID);
                $beschreibung = get_field('beschreibung', $autor_2->ID);
                $social_media = get_field('social_media', $autor_2->ID);
                $speaker_name = get_the_title($autor_2->ID);
                $social_media = get_field('social_media', $autor_2->ID);
                ?>
                <div class="testimonial card clearfix speakerprofil">
                    <h3 class="experte"><a target="_self"
                                           href="<?php print get_the_permalink($autor_2->ID); ?>"><?php print $speaker_name; ?></a>
                    </h3>
                    <div class="testimonial-img">
                        <a target="_self" href="<?php print get_the_permalink($autor_2->ID); ?>">
                            <img class="teaser-img" alt="<?php print $speaker_name; ?>"
                                 title="<?php print $speaker_name; ?>"
                                 src="<?php print $profilbild['sizes']['350-180']; ?>"/>
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
                                    <a target="_blank" class="social-icon" href="<?php print trim($social['link']) ?>">
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
            <?php } ?>
            </div><?php
            } else {
                ?>
                <div class="omt-row tool-abschnitt tool-testbericht wrap" style="margin-top: 30px !important;">
                    <span class="anchor" id="testbericht"></span>
                    <h2><?php echo $h1; ?></h2>
                    <?php echo $inhalt; ?>

                    <?php echo AuthorView::loadTemplate('profile-box', ['author' => $autor]) ?>
                    <?php echo AuthorView::loadTemplate('profile-box', ['author' => $autor_2]) ?>
                </div> <?php //end of testbericht-row
            }?>
            <?php }  ?>
            <?php if (is_array($anwendungstipps)) { ?>
                <div class="omt-row tool-abschnitt tool-funktionen">
                    <span class="anchor" id="anwendungstipps"></span>
                    <div class="omt-module anwendungstipps-wrap tool-testbericht wrap">
                        <?php if ($anwendungstipps_autor) : ?>
                            <span class="artikel-autor">
                                Autor: <a target="_blank" href="<?php echo get_the_permalink($anwendungstipps_autor->ID); ?>"><?php echo get_the_title($anwendungstipps_autor->ID) ?></a>
                            </span>
                        <?php endif ?>

                        <?php echo ToolView::loadTemplate('application-tips', ['applicationTips' => $anwendungstipps]) ?>
                    </div>

                    <?php echo AuthorView::loadTemplate('profile-box', ['author' => $anwendungstipps_autor]) ?>
                </div>
            <?php } ?>

            <?php if ($flexibleAreaEnabled) : ?>
                <span class="anchor" id="<?php echo str_replace("#", "", get_field('flexible_area_anchor')) ?>"></span>

                <?php $flexibleAreaAuthor = get_field('flexible_area_author'); ?>
                <?php if ($flexibleAreaAuthor) : ?>
                    <div class="info-wrap" style="max-width: 730px;margin:60px auto 0 auto;">
                        <p class="text-red" style="margin-bottom: 0px;">
                            <span class="artikel-autor">
                                Autor: <a target="_blank" href="<?php echo get_the_permalink($flexibleAreaAuthor->ID) ?>"><?php echo get_the_title($flexibleAreaAuthor->ID) ?></a>
                            </span>
                        </p>
                    </div>
                <?php endif ?>

                <div class="omt-row tool-abschnitt tool-testbericht wrap" style="margin-top: 30px !important;">
                    <h2><?php echo get_field('flexible_area_headline') ?></h2>
                    <?php echo get_field('flexible_area_content') ?>

                    <?php echo AuthorView::loadTemplate('profile-box', ['author' => $flexibleAreaAuthor]) ?>
                </div>
            <?php endif ?>

            <?php
            if (is_array($experten_agenturen)) { ?>
                <div class="omt-row tool-abschnitt tool-experten">
                    <span class="anchor" id="agenturen"></span>
                    <h2><?php print get_the_title();?> Agenturen</h2>
                    <?php foreach($experten_agenturen as $agentur) {
                        $ID = $agentur;
                        $logo = get_field('logo', $ID);
                        $logo_attachment = get_field('logo_attachment', $ID);
                        $title = get_the_title($ID);
                        $kompetenzen = get_field('branchen', $ID);
                        $services = get_field('services', $ID);
                        $anzahl_der_mitarbeiter = get_field('anzahl_der_mitarbeiter', $ID);
                        $adresse_stadt = get_field('adresse_stadt', $ID);
                        $omt_zertifiziert = get_field('omt_zertifiziert', $ID);
                        $beschreibung = get_field('beschreibung', $ID);
                        $vorschautext = get_field('vorschautext', $ID);
                        $permalink = get_the_permalink($ID);
                        ?>
                        <div class="card agentur-preview tool-agentur">
                            <?php if (1 == $omt_zertifiziert) { ?>
                                <div class="ribbon"><span>Zertifiziert</span></div><?php } ?>
                            <div class="logo-wrap">
                                <img class="agentur-logo" src="<?php print $logo['url']; ?>"
                                     alt="<?php print $title; ?>" title="<?php print $title; ?>"/>
                            </div>
                            <div class="content-wrap">
                                <h3><?php print $title; ?></h3>
                                <div class="meta-wrap">
                                    <?php print "Agentur in " . $adresse_stadt . " | ";
                                    foreach ($services as $service) { ?>
                                        <?php print $service['label'] . " | "; ?>
                                    <?php } ?>
                                    <?php print $anzahl_der_mitarbeiter . " Mitarbeiter"; ?>
                                </div>
                                <div class="kompetenzen">
                                    <?php foreach ($kompetenzen as $kompetenz) { ?>
                                        <div class="button button-grey kompetenz"><?php print $kompetenz['label']; ?></div>
                                    <?php } ?>
                                </div>
                                <div style="align-self:flex-end;"><?php if (strlen($vorschautext) > 0) {
                                        print $vorschautext . "...";
                                    } else {
                                        print showBeforeMore($beschreibung);
                                    } ?></div>
                                <a class="button button-blue" style="align-self:flex-end;"
                                   href="<?php print $permalink; ?>">Zur Agentur</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php }
            ?>
        </div>
    <?php } ?>
<?php } else if ( ( $current_fp == 'alternativen' ) OR (false != strpos($current_fp, "alternativen"))) { include ('single-tool-alternativen.php'); } ?>
    <!--    <div class="socials-floatbar-mobile">-->
    <!--        --><?php //echo do_shortcode('[shariff services="facebook|twitter|googleplus|linkedin|xing" backend="on" lang="de" theme="round" borderradius="1" buttonstretch="1"]'); ?>
    <!--    </div>-->
<?php get_footer(); ?>