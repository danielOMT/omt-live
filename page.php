<?php

use OMT\Model\Datahost\Article;
use OMT\Model\PostModel;
use OMT\Module\Articles as ArticlesModule;
use OMT\View\TeamView;

if (is_user_logged_in()) {
    if (is_page(4428) OR is_page(4285)) {
        header("Location:https://www.omt.de/account/", true, 301);
        exit;
    }
}
get_header();?>
<?php
$is_weihnachts = get_field('is_weihnachts');
if (1 == $is_weihnachts) {
    wp_enqueue_script('snowfall', get_template_directory_uri() . '/library/js/snowfall.jquery.js');
}
$paginierung_aktivieren = get_field('paginierung_aktivieren');
$paginierung_post_type = get_field('paginierung_post_type');
$paginierung_posts_pro_seite = get_field('paginierung_posts_pro_seite');
$page_2_start_ab = get_field('page_2_start_ab');

$magazin_filter = get_field('magazin_filter');

$zeilen = get_field('zeilen');
$header_hero_hintergrundbild = get_field('header_hero_hintergrundbild');
$header_hero_h1 = get_field('header_hero_h1');
$intro_headline = get_field('intro_headline');
$intro_text = get_field('intro_text');
if (is_page(44272) OR $post->post_parent == 44272) {
    $intro_headline = "";
    $intro_text = "";
}
$has_sidebar = get_field('has_sidebar');
$themenwelt_alternativ = get_field('themenwelt_alternatives_layout');
//$header_footer_2020 = get_field('header_footer_2020');
$header_footer_2020 = 1;
$kommentarfunktion_aktivieren = get_field('kommentarfunktion_aktivieren');
$bewertungen_aktivieren = get_field('bewertungen_aktivieren');
$header_deaktivieren = get_field('header_deaktivieren');
$inhaltsverzeichnis_deaktivieren = get_field('inhaltsverzeichnis_deaktivieren');
$shariff_aktivieren = get_field('shariff_aktivieren');
$shariff_headline = get_field('shariff_headline');
$sidebar_welche = get_field('sidebar_welche');
$sticky_button_text = get_field('sticky_button_text');
$produkt_sticky = get_field('produkt_sticky');
$sticky_button_text_nach_counter = get_field('sticky_button_text_nach_counter');
$sticky_button_link = get_field('sticky_button_link');
$hero_background = get_field('standardseite', 'options');
$bannerbild = get_field('bannerbild');
$bannerlink = get_field('bannerlink');
$mobile_banner_link = get_field('mobile_banner_link');
$mobile_banner_bild = get_field('mobile_banner_bild');
$globales_banner_verwenden_desktop = get_field('globales_banner_verwenden_desktop');
$globales_banner_verwenden_mobile = get_field('globales_banner_verwenden_mobile');
$standardbanner_fur_alle_seiten_ausspielen = get_field('standardbanner_fur_alle_seiten_ausspielen', 'options');
$standardbanner_fur_alle_seiten_ausspielen = 0;
$desktop_standardbanner_alternativen = get_field('desktop_standardbanner_alternativen', 'options');
$topLeftBannerUrl = getPost()->field('banner_top_left_url');

if ( (1 == $globales_banner_verwenden_desktop) OR (1 == $standardbanner_fur_alle_seiten_ausspielen) ) {
    $bannerbild = get_field('desktop_standardbanner_seiten', 'options');
    $bannerlink = get_field('desktop_standardbanner_seiten_link', 'options');
    if (is_array($desktop_standardbanner_alternativen)) {
        $banneritem = rand(0, count($desktop_standardbanner_alternativen));
        if (0 != $banneritem) {
            $bannerbild = $desktop_standardbanner_alternativen[$banneritem-1]['banner_desktop'];
            $bannerlink = $desktop_standardbanner_alternativen[$banneritem-1]['banner_desktop_link'];
        }
    }
}
if ( (1 == $globales_banner_verwenden_mobile) OR (1 == $standardbanner_fur_alle_seiten_ausspielen) ) {
    $mobile_banner_bild = get_field('mobile_standardbanner_seiten', 'options');
    $mobile_banner_link = get_field('mobile_standardbanner_seiten_link', 'options');
}

if ( is_user_logged_in() ) {
    $user = wp_get_current_user();
}
$alles_730 = get_field('alles_730');

if (is_array($header_hero_hintergrundbild)) { if (strlen($header_hero_hintergrundbild['url'])>0) { $hero_background = $header_hero_hintergrundbild;} }
if (strlen($header_hero_h1)>0) { $h1 = $header_hero_h1;} else { $h1 = get_the_title(); }
?>
<?php if ($has_sidebar != false) {
    $extraclass="has-sidebar";
} else { $extraclass = "fullwidth"; } ?>

<?php if (getPost()->field('ist_themenwelt', 'bool')) {
    $class_themenwelt = " wrap template-themenwelt";
    $extraclass .= " content-themenwelt-layout";
}

if ( 1 == $header_footer_2020) {
    $extraclass .= " content-flat";
}
?>
<?php if (1 == $alles_730) { $class_themenwelt .=" layout-730"; } ?>
<?php if (1 == $header_footer_2020) { $class_themenwelt .=" layout-flat"; } ?>

<?php if (1 == $shariff_aktivieren) { ?>
    <div class="socials-floatbar-left">
        <?php print do_shortcode('[shariff headline="<p>' . $shariff_headline . '</p>" borderradius="1" services="facebook|twitter|googleplus|linkedin|xing" theme="round" orientation="vertical"]');?>
    </div>
<?php } ?>
<?php if (1 == $themenwelt_alternativ) { ?>
    <div class="header-themenwelt header-themenwelt-flat">
        <?php
        $artikel = false;
        $wasist = false;
        $webinare = false;
        $seminare  = false;
        $podcasts = false;
        $expertenstimmen = false;
        $buchempfehlungen = false;
        $tools = false;
        $ebooks = false;
        ?>
        <?php
        if (is_array($zeilen)) {
            $artikelname = "Artikel";
            $webinarname = "Webinare";
            $seminarname = "Seminare";
            $podcastname = "Podcasts";
            $expertsname = "Expertenstimmen";
            $buchname = "Buchempfehlungen";
            $wasistmenutitle = "Was ist...";
            $tooltitle = "Tools";
            $ebookstitle = "eBooks";

            foreach ($zeilen as $zeile) {
                if ("wasist" == $zeile['sticky_header_abschnitt']) { $wasist = true;
                    if (strlen($zeile['individueller_menuname'])>0) { $wasistmenutitle = $zeile['individueller_menuname']; }
                }
                if ("artikel" == $zeile['sticky_header_abschnitt']) { $artikel = true;
                    if (strlen($zeile['individueller_menuname'])>0) { $artikelname = $zeile['individueller_menuname']; }
                }
                if ("webinare" == $zeile['sticky_header_abschnitt']) { $webinare = true;
                    if (strlen($zeile['individueller_menuname'])>0) { $webinarname = $zeile['individueller_menuname']; }
                }
                if ("seminare" == $zeile['sticky_header_abschnitt']) { $seminare = true;
                    if (strlen($zeile['individueller_menuname'])>0) { $seminarname = $zeile['individueller_menuname']; }
                }
                if ("podcasts" == $zeile['sticky_header_abschnitt']) { $podcasts = true;
                    if (strlen($zeile['individueller_menuname'])>0) { $podcastname = $zeile['individueller_menuname']; }
                }
                if ("tools" == $zeile['sticky_header_abschnitt']) { $tools = true;
                    if (strlen($zeile['individueller_menuname'])>0) { $tooltitle = $zeile['individueller_menuname']; }
                }
                if ("expertentipps" == $zeile['sticky_header_abschnitt']) { $expertenstimmen = true;
                    if (strlen($zeile['individueller_menuname'])>0) { $expertsname = $zeile['individueller_menuname']; }
                }
                if ("buchempfehlungen" == $zeile['sticky_header_abschnitt']) { $buchempfehlungen = true;
                    if (strlen($zeile['individueller_menuname'])>0) { $buchname = $zeile['individueller_menuname']; }
                }
                if ("ebooks" == $zeile['sticky_header_abschnitt']) { $ebooks = true;
                    if (strlen($zeile['individueller_menuname'])>0) { $ebookstitle = $zeile['individueller_menuname']; }
                }
            }
        } ?>

        <div class="header-themenwelt-inner">
            <?php
            $themenwelt_autor = get_field('themenwelt_autor');
            $autor_id = $themenwelt_autor->ID;
            ?>
            <div class="sticky-buttons">
                <?php if (true == $wasist) { ?><a href="#wasist" class="button-active"><?php print $wasistmenutitle;?></a><?php } ?>
                <?php if (true == $webinare) { ?><a href="#webinare"><?php print $webinarname;?></a><?php } ?>
                <?php if (true == $artikel) { ?><a href="#artikel"><?php print $artikelname;?></a><?php } ?>
                <?php if (true == $podcasts) { ?><a href="#podcasts"><?php print $podcastname;?></a><?php } ?>
                <?php if (true == $seminare) { ?><a href="#seminare"><?php print $seminarname;?></a><?php } ?>
                <?php if (true == $tools) { ?><a href="#tools"><?php print $tooltitle;?></a><?php } ?>
                <?php if (true == $expertenstimmen) { ?><a href="#expertenstimmen"><?php print $expertsname;?></a><?php } ?>
                <?php if (true == $buchempfehlungen) { ?><a href="#buchempfehlungen"><?php print $buchname;?></a><?php } ?>
                <?php if (true == $ebooks) { ?><a href="#ebooks"><?php print $ebookstitle;?></a><?php } ?>
            </div>
        </div>
    </div>
<?php } ?>


<div id="content" class="<?php print $extraclass;?>" xmlns:background="http://www.w3.org/1999/xhtml">
<?php if (1 != $header_deaktivieren) {
    if (1 == $header_footer_2020) {
        $ID = $post->ID;
        //get_template_part('library/templates/hero-flat', 'page');
    } elseif (is_page(44272) OR $post->post_parent == 44272){
        get_template_part('library/templates/hero-agenturfinder', 'page');
    } elseif (311677==$ID OR $post->post_parent == 311677){
        get_template_part('library/templates/hero-freelancervermittlung', 'page');
    } else { ?>
        <div class="omt-row hero-header <?php if (1 == $themenwelt_alternativ) { print "hero-themenwelt-alternativ"; } ?>" style="background: url('<?php print $hero_background['url'];?>') no-repeat 50% 0;">
            <div class="wrap">
                <h1><?php print $h1;?></h1>
            </div>
        </div>
    <?php } ?>
<?php } else { //header IS deactivated!?>
    <div class="omt-row" style="margin: 100px 0 0 0;">
        <div class="wrap">
            <?php if (is_page(44272) OR $post->post_parent == 44272){ //if header is deactivated for agenturfinder templates or children?>
                <div id="kontakt" class="mfp-hide" data-effect="mfp-zoom-out">
                    <?php //echo do_shortcode( '[contact-form-7 id="128" title="Kontaktformular 1"]' ); ?>
                    <?php echo do_shortcode( '[gravityform id="35" title="true" description="true" tabindex="0" ajax=true ]' ); ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<?php if (strlen($sticky_button_text)>0) {
    $handle=new WC_Product_Variable($produkt_sticky->ID);
    $available_variations = $handle->get_available_variations();
    $variations1=$handle->get_children();
    $ticketanzahl = 0;
    $gotlager = false;
    foreach ($variations1 as $ticketvariation) {   /*build array with all seminars and all repeater date fields*/
//collecting data
        $single_variation = new WC_Product_Variation($ticketvariation);
        ?>
        <?php
        $lager = $single_variation->stock_quantity;
        if ($lager > 0 AND $gotlager != true) {
            $ticketanzahl = $lager;
            $gotlager = true;
        }
    }
    if ($ticketanzahl > 0) { $sticky_button_text = $sticky_button_text . " " . $ticketanzahl . " " . $sticky_button_text_nach_counter; }
    ?>
    <p class="button-termine"><a class="button button-red button-730px centered" href="<?php print $sticky_button_link;?>"><?php print $sticky_button_text;?></a></p>
<?php } ?>
<?php if (getPost()->field('ist_themenwelt', 'bool') && strlen($sticky_button_text)<1) { //Inhaltsverzeichnis einblenden, falls Themenwelt Checkbox angeklickt wurde?>
    <?php if (1 != $inhaltsverzeichnis_deaktivieren) { ?>
        <div class="omt-row no-margin-bottom">
            <div class="inhaltsverzeichnis-wrap">
                <ul class="caret-right inhaltsverzeichnis">
                    <p class="index_header">Inhaltsverzeichnis:</p>
                </ul>
            </div>
        </div>
    <?php } else {
        if ( ( 1 == $alles_730 ) OR (1 == $inhaltsverzeichnis_deaktivieren) ) { ?>
            <div class="inhaltsverzeichnis-wrap">
                <div class="omt-row wrap no-margin-bottom no-margin-top placeholder-730"></div>
            </div>
        <?php } ?>
    <?php } ?>
<?php } ?>

<?php if (strlen($mobile_banner_link)>0) { ?>
    <div class="omt-row tool-info-mobile">
        <a rel="nofollow" href="<?php print $mobile_banner_link;?>" target="_blank"><img src="<?php print $mobile_banner_bild['url'];?>" alt="<?php print $mobile_banner_bild['alt'];?> title=<?php print $mobile_banner_bild['alt'];?>"/></a>
    </div>
<?php } ?>

<?php // Top left banner section on the Pages ?>
<?php if (!empty($topLeftBannerUrl)) : ?>
    <div class="top-left-banner-section page-top-left-banner x-overflow-hidden x-hidden">
        <a href="<?php echo $topLeftBannerUrl ?>" target="_blank" rel="nofollow">
            <img src="<?php echo getPost()->field('banner_top_left', 'image_url') ?>" class="x-m-0 x-w-full" alt="Banner" />
        </a>
    </div>
<?php endif ?>

<?php if (isset($_GET['redirect_to']) && strpos($_GET['redirect_to'], '/account/resume/') !== false) : ?>
    <div class="omt-intro wrap">
        <?php echo getOption('resume_login_text', 'content') ?>
    </div>
<?php endif ?>

<?php if (strlen($intro_headline) > 0 || strlen($intro_text) > 0) { ?>
    <div class="omt-row omt-intro wrap article-header page-intro">
        <?php if (strlen($intro_headline) >0) { ?><h2><?php print $intro_headline;?></h2><?php } ?>
        <?php if($themenwelt_autor) {?>
        <p class="artikel-autor clear-both">Autor:
            <a target="_blank" href="<?php print get_the_permalink($themenwelt_autor->ID);?>"><?php print get_the_title($themenwelt_autor->ID); ?></a>
        </p>
        <?php }?>

        <?php // Replace "Intro text" for the /club page if it's the redirect-version ?>
        <?php if (isset($_GET['redirect_to']) && strpos($_GET['redirect_to'], '/account/resume/') !== false && !empty(getOption('resume_login_intro_text'))) : ?>
            <?php echo getOption('resume_login_intro_text', 'content') ?>
        <?php else : ?>
            <?php if (strlen($intro_text) > 0) : ?> 
                <?php echo $intro_text ?>
            <?php endif ?>
        <?php endif ?>
    </div>
    <?php } else{?>
        <?php if($themenwelt_autor) {?>
        <p class="artikel-autor clear-both">Autor:
            <a target="_blank" href="<?php print get_the_permalink($themenwelt_autor->ID);?>"><?php print get_the_title($themenwelt_autor->ID); ?></a>
        </p>
        <?php }?>
   <?php } ?>


<?php if ($has_sidebar != false) { ?>
    <div id="" class="clearfix wrap omt-main" role="main">
    <main>
<?php } ?>
<?php if (is_array($zeilen)) {
    $rowcount=0;
    ?>
    <?php

    ///////////IF IS PAGNIATION AND PAGE 2+
    $page = $wp_query->query_vars['mpage'];
    if ($paginierung_aktivieren == 1 && $page > 1 && $page < 5) {
        if(empty($page)) $page = 1;
        $rowclass = "wrap grid-wrap";
        $columnclass  = "artikel-wrap teaser-modul";
        ?>
        <section class="omt-row <?php print $rowclass;?>">
            <?php if (1 == $header_footer_2020) { ?><div class="row-inner wrap"><?php }?>
                <div class="omt-module <?php print $columnclass . " "; ?>">
                    <?php
                        if (USE_JSON_POSTS_SYNC) {
                            $zeile['inhaltstyp'][0]['anzahl_angezeigter_artikel'] = $paginierung_posts_pro_seite;
                            $zeile['inhaltstyp'][0]['kategorie'] = "alle";
                            $zeile['inhaltstyp'][0]['anzahl'] = $paginierung_posts_pro_seite;
                            $zeile['inhaltstyp'][0]['ab_x'] = $page_2_start_ab + ($paginierung_posts_pro_seite * ($page - 2));
                            $zeile['inhaltstyp'][0]['format'] = "mixed";

                            include('library/modules/module-artikel-anzeigen.php');
                        } else {
                            echo (new ArticlesModule([
                                'anzahl_angezeigter_artikel' => $paginierung_posts_pro_seite,
                                'kategorie' => 'alle',
                                'anzahl' => $paginierung_posts_pro_seite,
                                'ab_x' => $page_2_start_ab + ($paginierung_posts_pro_seite * ($page - 2)),
                                'format' => 'mixed'
                            ]))->render();
                        }
                    ?>
                </div>
                <?php if (1 == $header_footer_2020) { ?></div><?php }?>
        </section>
        <?php /// END OF PAGINIERUNG ?>
    <?php } else {
    
    if ($paginierung_aktivieren == 1 && $page == 5) {
        $zeilen = get_field('magazine_modules_page_5');
    }

    if (getPost()->field('team_members_gallery', 'bool')) {
        echo TeamView::loadTemplate('gallery', ['rows' => $zeilen]);
    }

    foreach ($zeilen as $zeile) {
    $rowcount++;
    ?>
    <?php $rowclass = ""; ?>
    <?php $color_area = true;
    $headline = $zeile['headline'];
    $headline_typ = $zeile['headline_typ'];
    $introtext = $zeile['introtext'];
    $headline_noindex = $zeile['headline_noindex'];
    $headline_set = $zeile['headline_&_introtext_vor_dem_modul'];
    if (1 == $themenwelt_alternativ) { $sticky_header_abschnitt = $zeile['sticky_header_abschnitt']; }
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
    if ($zeile['inhaltstyp'][0]['timetable_verstecken'] == 1) { $rowclass .= " display-none-imp";}

    ?>
    <section id="abschnitt-<?php print $rowcount;?>" class="omt-row <?php print $rowclass;?> <?php print $class_themenwelt;?> <?php if (false != $color_area ) { ?>color-area-<?php print $zeile['color_embed']; } ?> <?php if (1==$zeile['content_rotate']) { print "content-rotate"; } ?>">
        <?php if ( (1 == $themenwelt_alternativ) AND (strlen($sticky_header_abschnitt)>0) ) { ?>
            <span class="anchor anchor-themenwelt" id="<?php print $sticky_header_abschnitt;?>"></span> <?php } ?>
        <?php if (false != $color_area ) { ?><div class="color-area-inner"></div><?php } ?>
        <?php
        if (strlen($headline)>0 OR strlen($introtext)>0) { ?><div class="wrap module-headline-wrap <?php /*if ("h2" == $headline_typ) { print "align-left"; }*/ ?>"><?php }
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
<?php if (1 == $header_footer_2020) { ?>
        <?php if($zeile['inhaltstyp'][0]['acf_fc_layout'] == 'konferenzticket'):?>
            <div class="omt-ticket-row">
        <?php elseif($zeile['inhaltstyp'][0]['acf_fc_layout'] == 'autojobs'):?>
            <div class="omt-ticket-auto-row">
        <?php elseif($zeile['inhaltstyp'][0]['acf_fc_layout'] == 'partner_full_width'):?>
            <div class="omt-full-width">
        <?php elseif($zeile['inhaltstyp'][0]['acf_fc_layout'] == 'highlighted-jobs'):?>
            <div class="omt-full-highlighted-jobs">
        <?php else:?>
            <div class="row-inner wrap">
        <?php endif;?>
    <?php }?>

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
<?php if (1 == $header_footer_2020) { ?></div><?php }?>
    </section><?php } // end of foreach ROW ?>
<?php } ///end of if pagination and page 2+ (else-query) ?>
<?php } ///end of if is_array($zeilen)
///
///
/// PAGINIERUNG
if ($paginierung_aktivieren == 1) {
    if (USE_JSON_POSTS_SYNC) {
        require_once get_template_directory() . '/library/functions/json-magazin/json-magazin-alle.php';
        $totalPosts = display_magazinartikel_json(99999, "alle", NULL, true);
    } else {
        $totalPosts = Article::init()->itemsCount([
            'status' => PostModel::POST_STATUS_PUBLISH,
            'recap' => false
        ]);
    }

    // Limit the pagination to 5 pages
    if ($totalPosts > $page_2_start_ab + ($paginierung_posts_pro_seite * 4)) {
        $totalPosts = $page_2_start_ab + ($paginierung_posts_pro_seite * 4);
    }
    ?>
    <section class="omt-row pagination-wrap">
        <div class="omt-module wrap pagination">
            <?php
            $page = $wp_query->query_vars['mpage'];

            if(empty($page)) $page = 1;
            $type = $_GET['type'];
            if (!isset($page)) { $page = 1; }
            if (!isset($type)) { $type= $paginierung_post_type; }

            ?>
            <?php if (2 == $page) { ?><a href="<?php print get_the_permalink();?>">Neuere Artikel</a><?php } ?>
            <?php if ($page>2) { ?><a href="<?php print get_the_permalink();?><?php print $page-1;?>/">Neuere Artikel</a><?php } ?>
            <?php if (1 == $page) {?><div style="width:100%;text-align:right;"><?php }?>
            
            <?php if ($totalPosts > $page_2_start_ab + ($paginierung_posts_pro_seite * ($page - 1))) : ?>
                <a href="<?php print get_the_permalink();?><?php print $page+1;?>/">Ältere Artikel</a>
            <?php endif ?>

            <?php if (1 == $page) {?></div><?php } ?>
        </div>
    </section>
<?php }
/// END OF PAGINIERUNG
/// ?>
<?php //Kontaktbereich vom Agenturfinder, falls entsprechende Seite ?>
<?php /*if (is_page(44272) OR $post->post_parent == 44272){
    get_template_part('library/templates/footer-agenturfinder', 'page');
}*/
//Agenturfinder Kontaktbereich Ende?>
<?php if (1 == $bewertungen_aktivieren) { ?>
    <section class="omt-row color-area-weiss wrap layout-730 ">
        <div class="omt-module card">
            <h2 class="no-ihv">Diesen Artikel bewerten</h2>
            <?php if(function_exists('the_ratings')) { the_ratings(); } ?>


        </div>
    </section>
<?php } ?>

<?php if (1 == $kommentarfunktion_aktivieren) { ?>
    <section class="omt-row color-area-weiss">
        <?php
        comments_template();
        ?>
    </section>
<?php }
if (strlen($bannerlink)>0) {
    ?>
    <a class="tool-info-image" href="<?php print $bannerlink;?>" target="_blank" rel="nofollow">
        <img src="<?php print $bannerbild['url'];?>" alt="<?php print $bannerbild['alt'];?>" title="<?php print $bannerbild['alt'];?>"/>
    </a>
<?php } ?>
<?php if ($has_sidebar != false) { ?>
    </main>
    <?php get_sidebar($sidebar_welche);?>
    </div> <?php //end of omt-main ?>
<?php } ?>
    </div> <?php //end of #content ?>
<?php if (1 == $shariff_aktivieren) { ?>
    <div class="socials-floatbar-mobile">
        <?php echo do_shortcode('[shariff services="facebook|twitter|googleplus|linkedin|xing" backend="on" lang="de" theme="round" borderradius="1" buttonstretch="1"]'); ?>
    </div>
<?php } ?>
<?php if (1 == $is_weihnachts) {?>
    <script type='text/javascript'> 
        $(document).ready(function() {
            $(document).snowfall({deviceorientation : true, round : true, minSize: 1, maxSize:8,  flakeCount : 250});
        });
    </script>   
<?php } ?>
<?php get_footer(); ?>