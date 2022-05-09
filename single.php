<?php

use OMT\Module\Webinars;

?>
<?php get_header(); ?>
<?php
$post_id = get_the_ID();
$featured_img_url = get_the_post_thumbnail_url($post_id, '730-380');
$hero_image = get_field('hero_image');
$zeilen = get_field('zeilen');

$lesen = 'content';
$schauen = get_field('webinar_id');
$horen = get_field('soundcloud_id');
    
?>

<?php if (!is_array($zeilen)) { // check if this is a regular tool or a page-like build ?>
    <div id="content">
        <div id="inner-content" class="wrap clearfix">
            <div id="main" class="twelvecol first blog-single  clearfix" role="main">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" class="container-small" role="article">
                        <div class="article-header">
                            <?php if (strlen($hero_image['url'])>0) { ?>
                                <img class="article-hero" alt="<?php print $hero_image['alt'];?>" title="<?php print $hero_image['alt'];?>" src="<?php print $hero_image['post-image'];?>" />
                            <?php } ?>
                            <h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
                            <?php if(isset($schauen) && $schauen != '' || isset($horen) && $horen):?>

                                <select id="article_select">
                                    <option value="0">Möchtest Du den Artikel Lesen, Schauen oder Hören?</option>
                                     <?php if(isset($schauen) && $schauen != ''): ?>
                                        <option value="schauen">Schauen</option>
                                     <?php endif;?>
                                     <?php if(isset($horen) && $horen != ''): ?>
                                        <option value="horen">Hören</option>
                                     <?php endif;?>
                                     <option value="Lesen">Lesen</option>
                                </select>

                            <?php endif;?>
                            
                        </div>
                        <section class="entry-content clearfix" itemprop="articleBody">
                            <div id="art_content">
                                <?php the_content(); ?>
                            </div>
                            <div id="soundcloud_content" class="hide_article">
                                <?php echo do_shortcode( '[soundcloud podcast="'.$horen.'"]' );   ?>
                            </div>
                            <div id="webinar_content" class="hide_article">
                                <?php echo do_shortcode( '[webinar_widget webinar="'.$schauen.'"]' );   ?>
                            </div>
                            
                        </section>
                        <?php //comments_template(); ?>
                    </article>
                <?php endwhile; ?>
                <?php else : ?>
                    <article id="post-not-found" class="hentry clearfix">
                        <header class="article-header">
                            <h1><?php _e('Oops, Post Not Found!', 'bonestheme'); ?></h1>
                        </header>
                        <section class="entry-content">
                            <p><?php _e('Uh Oh. Something is missing. Try double checking things.', 'bonestheme'); ?></p>
                        </section>
                        <footer class="article-footer">
                            <p><?php _e('This is the error message in the single.php template.', 'bonestheme'); ?></p>
                        </footer>
                    </article>
                <?php endif; ?>
            </div>
            <?php //get_sidebar(); ?>
        </div>
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
    <?php 
    if ($has_sidebar != false) {
        $extraclass="has-sidebar";
    } else { 
        $extraclass = "fullwidth"; 
    } 

    $class_themenwelt = " template-themenwelt";
    ?>

<div id="content" class="<?php print $extraclass;?>" xmlns:background="http://www.w3.org/1999/xhtml">
    <div class="omt-row hero-header" style="background: url('<?php print $hero_background['url'];?>') no-repeat 50% 0;">
        <div class="wrap">
            <h1><?php print $h1;?></h1>
        </div>
    </div>
    <?php if (strlen($sticky_button_text)>0) { ?>
        <p class="button-termine"><a class="button button-red button-730px centered" href="<?php print $sticky_button_link;?>"><?php print $sticky_button_text;?></a></p>
    <?php } ?>
    <?php if (strlen($sticky_button_text)<1) { //Inhaltsverzeichnis einblenden, falls Themenwelt Checkbox angeklickt wurde?>
        <div class="omt-row no-margin-bottom">
            <div class="inhaltsverzeichnis-wrap">
                <ul class="caret-right inhaltsverzeichnis">
                    <p class="index_header">Inhaltsverzeichnis:</p>
                </ul>
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
    <div id="" class="clearfix wrap omt-main" role="main">
    <main>
<?php } ?>
    <?php foreach ($zeilen as $zeile) {
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
    ?>
    <?php switch ($zeile['inhaltstyp'][0]['acf_fc_layout']) {
        case "header_hero_modul":
            $rowclass = "hero-header";
            break;
        case "banner_bg":
            //$farbschema = $zeile['inhaltstyp'][0]['farbschema'];
            //$rowclass = $farbschema;
            $rowclass .= "wrap banner-bg";
            //$color_area = false;
            break;
        case "teaser_highlight":
            $rowclass = "wrap container-small";
            break;
        case "webinare_anzeigen":
            $rowclass = "wrap grid-wrap";
            break;
        case "vortrage_anzeigen":
            $rowclass = "wrap grid-wrap";
            break;
        case "artikel_anzeigen":
            $rowclass = "wrap grid-wrap";
            break;
        case "seminare_anzeigen":
            $rowclass = "wrap grid-wrap";
            break;
        case "seminartypen_anzeigen":
            $rowclass = "wrap grid-wrap";
            break;
        case "artikel_auswahlen":
            $rowclass = "wrap grid-wrap";
            break;
        case "jobs_anzeigen":
            $rowclass = "wrap grid-wrap jobs-section";
            break;
        case "inhaltseditor":
            $rowclass = "wrap inhaltseditor";
            if ($zeile['inhaltstyp'][0]['highlight_text'] != false) { $rowclass .= " text-highlight"; }
            if ($zeile['inhaltstyp'][0]['intro_text'] != false) { $rowclass .= " omt-intro"; }
            break;
        case "webinar_zusammenfassungen":
            $rowclass = "webinar-zusammenfassungen wrap";
            break;
        case "slider":
            $rowclass = "slider-wrap";
            break;
        case "speakerprofil":
            $rowclass = "wrap autor-wrap";
            break;
        default:
            if (($has_sidebar != false)) {
                $rowclass = ""; } else { $rowclass="wrap"; }
            break;
    }
    if ($zeile['no_margin_bottom'] != false) { $rowclass .= " no-margin-bottom"; }
    ?>
    <section class="omt-row <?php print $rowclass;?> <?php print $class_themenwelt;?> <?php if (false != $color_area ) { ?>color-area-<?php print $zeile['color_embed']; } ?> <?php if (1==$zeile['content_rotate']) { print "content-rotate"; } ?>">
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
<?php $i++; ?>
<?php switch ($zeile['inhaltstyp'][0]['acf_fc_layout']) {
    case "header_hero_modul":
        $columnclass = "header-hero-modul";
        break;
    case "hero_modul":
        $columnclass = "hero-modul";
        break;
    case "inhaltseditor":
        $columnclass = "inhaltseditor";
        break;
    case "inhaltseditor_3er":
        $columnclass = "teaser-modul inhaltseditor_3er";
        break;
    case "inhaltseditor_2er":
        $columnclass = "teaser-modul inhaltseditor_2er";
        break;
    case "jquery_skript":
        $columnclass = "script";
        break;
    case "headline":
        $columnclass = "headline";
        break;
    case "accordion":
        $columnclass = "accordion";
        break;
    case "galerie":
        $columnclass = "galerie teaser-modul";
        break;
    case "slider":
        $columnclass = "slider";
        break;
    case "paragraph_image":
        $columnclass = "paragraph-image teaser-modul";
        break;
    case "teaser_modul":
        $columnclass = "teaser-modul";
        break;
    case "testimonial":
        $testimonial_count = count($zeile['inhaltstyp'][0]['testimonials']);
        $columnclass = "testimonial-wrap";
        if ($testimonial_count>1) { $columnclass .= " testimonial-slider"; }
        break;
    case "tabelle":
        $columnclass = "tabelle overflow-auto";
        break;
    case "timetable":
        $columnclass = "tabelle overflow-auto";
        break;
    case "vergleichstabelle_tools":
        $columnclass = "tabelle overflow-auto";
        break;
    case "instagram":
        $columnclass = "instagram";
        break;
    case "call_to_action":
        $columnclass = "call-to-action";
        break;
    case "blog_grid":
        $columnclass = "blog-grid";
        break;
    case "google_map":
        $columnclass = "google-map";
        break;
    case "kontaktformular":
        $columnclass = "kontaktformular";
        break;
    case "video":
        $columnclass = "video_wrap";
        break;
    case "video_wistia":
        $columnclass = "video_wrap";
        break;
    case "banner_bg":
        $columnclass = "banner-bg-inner";
        break;
    case "teaser_modul_highlight":
        $columnclass = "teaser_modul_highlight";
        break;
    case "webinare_anzeigen":
        $columnclass = "webinare-wrap teaser-modul";
        break;
    case "vortrage_anzeigen":
        $columnclass = "webinare-wrap vortraege-wrap teaser-modul";
        break;
    case "artikel_anzeigen":
        $columnclass  = "artikel-wrap teaser-modul";
        break;
    case "artikel_auswahlen":
        $columnclass  = "artikel-wrap teaser-modul";
        break;
    case "seminare_anzeigen":
        $columnclass = "seminare-wrap teaser-modul";
        break;
    case "seminartypen_anzeigen":
        $columnclass = "seminare-wrap teaser-modul";
        break;
    case "jobs_anzeigen":
        $columnclass = "jobs-wrap";
        break;
    case "teaser_highlight":
        $columnclass = "teaser-highlight ";
        $columnclass .= $zeile['inhaltstyp'][0]['farbschema'];
        break;
    case "branchenbuch_agentursuche":
        $columnclass = "branchenbuch branchenbuch-suche";
        break;
    case "branchenbuch_premium":
        $columnclass = "branchenbuch branchenbuch-agenturen";
        break;
    case "branchenbuch_liste":
        $columnclass = "branchenbuch branchenbuch-liste";
        break;
    case "trends_anzeigen":
        $columnclass = "trends-wrap";
        break;
    case "tools_anzeigen":
        $columnclass = "tools-wrap";
        break;
    case "webinare_teaser_wiederholungsfeld":
        $columnclass = "webinare_ctas";
        break;
    case "webinar_zusammenfassungen":
        $columnclass = "webinar-zusammenfassungen";
        break;
    case "konferenzticket":
        $columnclass = "teaser-modul konferenzticket";
        break;
    case "partner":
        $columnclass = "teaser-modul omt-partner";
        break;
    case "speakerprofil":
        $columnclass = "testimonial card clearfix speakerprofil";
        break;
    default:
        $columnclass = "";
        break;
} ?>
    <div class="omt-module <?php print $columnclass . " "; ?>"
         <?php if ($columnclass == "header_hero_modul") { ?>style="background: url('<?php print $zeile['inhaltstyp'][0]['hero_background_image']['url'];?>');" <?php } ?>
    >
        <?php switch ($zeile['inhaltstyp'][0]['acf_fc_layout']) {
        case "header_hero_modul":
            ?>
            <h1><?php print $zeile['inhaltstyp'][0]['hero_title_h1'];?></h1>
            <?php break;
        case "hero_modul":
            ?>
            <?php if (strlen($zeile['inhaltstyp'][0]['image']['url'])>0) { ?> <img src="<?php print $zeile['inhaltstyp'][0]['image']['url']; ?>" alt="<?php print $zeile['inhaltstyp'][0]['image']['alt']; ?>" title="<?php print $zeile['inhaltstyp'][0]['image']['alt']; ?>"/> <?php } ?>
            <?php if (strlen($zeile['inhaltstyp'][0]['headline']) >0) { ?><h3><?php print $zeile['inhaltstyp'][0]['headline']; ?></h3> <?php } ?>
            <?php if (strlen($zeile['inhaltstyp'][0]['intro_text']) >0) { ?><?php print $zeile['inhaltstyp'][0]['intro_text']; ?> <?php } ?>
            <?php if (strlen($zeile['inhaltstyp'][0]['text']) >0) { ?><?php print $zeile['inhaltstyp'][0]['text']; ?> <?php } ?>
            <?php break;
        case "hero_slider":
            ?>
            <?php if (strlen($zeile['inhaltstyp'][0]['hero_titel'])>0) { ?> <h2><?php print $zeile['inhaltstyp'][0]['hero_titel']; ?></h2> <?php } ?>
            <?php if (strlen($zeile['inhaltstyp'][0]['hero_subtitel']) >0) { ?><h3><?php print $zeile['inhaltstyp'][0]['hero_subtitel']; ?></h3> <?php } ?>
            <?php foreach($zeile['inhaltstyp'][0]['hero_images'] as $image) { ?>
            <?php if (strlen($image['link'])>0) { ?><a href="<?php print $image['link'];?>"><?php } ?>
            <img class="slider-image" src="<?php print $image['image']['url'];?>" alt="<?php print $image['image']['alt'];?>" title="<?php print $image['image']['title'];?>"/>
            <?php if (strlen($image['link'])>0) { ?></a><?php } ?>
        <?php } ?>
            <?php break;

        //Inhaltseditor
        case "inhaltseditor": ?>
            <?php $inhalt =  $zeile['inhaltstyp'][0]['inhaltseditor_feld'];?>
            <?php print $inhalt;?>

            <?php break;

        //Jquery Skripte
        case "jquery_skript": ?>
            <?php print $zeile['inhaltstyp'][0]['skript'];?>
            <?php break;

        //Inhaltseditor 3er 1/3 + 1/3 + 1/3
        case "inhaltseditor_3er": ?>
            <div class="teaser-small"><?php print $zeile['inhaltstyp'][0]['inhaltseditor_1'];?></div>
            <div class="teaser-small"><?php print $zeile['inhaltstyp'][0]['inhaltseditor_2'];?></div>
            <div class="teaser-small"><?php print $zeile['inhaltstyp'][0]['inhaltseditor_3'];?></div>
            <?php break;

        //Inhaltseditor 2er 1/2 + 1/2
        case "inhaltseditor_2er": ?>
            <div class="teaser-medium"><?php print $zeile['inhaltstyp'][0]['inhaltseditor_1'];?></div>
            <div class="teaser-medium"><?php print $zeile['inhaltstyp'][0]['inhaltseditor_2'];?></div>
            <?php break;

        //Accordion
        case "accordion": ?>
            <?php if (strlen($zeile['inhaltstyp'][0]['accordion_headline'])>0) { ?>
                <h3 class="accordion-headline"><?php print $zeile['inhaltstyp'][0]['accordion_headline'];?></h3>
            <?php } ?>
            <?php foreach ($zeile['inhaltstyp'][0]['items'] as $item) { ;?>
                <div class="accordion-item">
                    <h3 class="accordion-title"><?php print $item['headline'];?><span class="fa fa-plus"></span></h3>
                    <div class="accordion-content">
                        <?php print $item['text'];?>
                    </div>
                </div>
            <?php } ?>
            <?php break;
        case "headline": ?>
        <?php if ($zeile['inhaltstyp'][0]['ausrichtung'] == "gerade") { $ausrichtung = "has-0-degrees"; } else { $ausrichtung = "has-5-degrees"; } ?>
        <<?php print $zeile['inhaltstyp'][0]['headline_typ'];?> class="<?php print $ausrichtung;?>">
        <?php print $zeile['inhaltstyp'][0]['headline'];?>
    </<?php print $zeile['inhaltstyp'][0]['headline_typ'];?>>
<?php break;

//Call to Action / Buttons
case "call_to_action":
?>
    <a class="button <?php print $zeile['inhaltstyp'][0]['breite'] . " ";?> <?php print $zeile['inhaltstyp'][0]['grundfarbe'];?>"
       href="<?php print $zeile['inhaltstyp'][0]['cta_linkziel'];?>">
        <?php print $zeile['inhaltstyp'][0]['cta_text'];?>
    </a>
<?php break;

//Galerie
case "galerie": ?>
<?php foreach($zeile['inhaltstyp'][0]['galerie'] as $image) { ?>
    <div class="teaser teaser-small">
        <img class="galerie-image" src="<?php print $image['bild']['url'];?>" alt="<?php print $image['bild']['alt'];?>" title="<?php print $image['bild']['alt'];?>"/>
        <?php if (strlen($image['link'])>0) { ?><a href="<?php print $image['link'];?>"><?php } ?>
            <?php if (strlen($image['bild_untertitel'])>0) { print $image['bild_untertitel']; } ?>
            <?php if (strlen($image['link'])>0) { ?></a><?php } ?>
    </div>
<?php } ?>
<?php break;

case "slider": ?>
<?php foreach($zeile['inhaltstyp'][0]['slider'] as $image) { ?>
    <div><img class="teaser-img" src="<?php print $image['sizes']['350-180'];?>" alt="<?php print $image['alt'];?>" title="<?php print $image['alt'];?>"/></div>
<?php } ?>
<?php break;


//teaser modul
case "teaser_modul":
//teaser_bild
//teaser_titel
//teaser_highlight_rot
//teaser_highlight_text
//teaser_text
//teaser_link
//teaser_button_text
//bildbreite
//bildhohe_begrenzen
//bildausrichtung
$bildgrose = $zeile['inhaltstyp'][0]['bildbreite'];
switch ($bildgrose) {
    case "20":
        $imageclass = "img-20";
        $textclass = "txt-80";
        break;
    case "25":
        $imageclass = "img-25";
        $textclass = "txt-75";
        break;
    case "33":
        $imageclass = "img-33";
        $textclass = "txt-67";
        break;
    default:
        $imageclass = "";
}
$imageclass .= " img" . $zeile['inhaltstyp'][0]['bildhohe_begrenzen'];
$imageclass .= " " . $zeile['inhaltstyp'][0]['bildausrichtung'];
if ($zeile['inhaltstyp'][0]['grose'] != "custom") { $imageclass = ""; }
?>
<?php foreach($zeile['inhaltstyp'][0]['teaser'] as $teaser) { ?>
<div class="teaser teaser-<?php print $zeile['inhaltstyp'][0]['grose'];?> <?php print $imageclass;?>">
    <img class="teaser-img" src="<?php print $teaser['teaser_bild']['url'];?>" alt="<?php print $teaser['teaser_bild']['alt'];?>" title="<?php print $teaser['teaser_bild']['alt'];?>"/>
<?php if ($zeile['inhaltstyp'][0]['grose'] == "large") { ?>
    </div>
    <div class="teaser teaser-large">
<?php } ?>
<?php if ($zeile['inhaltstyp'][0]['grose'] == "custom") { ?>
    </div>
    <div class="teaser teaser-custom <?php print $textclass;?>">
<?php } ?>
<?php if (strlen($teaser['teaser_highlight_rot'])>0) { ?><h4 class="teaser-cat"><?php print $teaser['teaser_highlight_rot'];?></h4><?php } ?>
    <h4>
        <?php if (strlen($teaser['teaser_link'])>0) { ?><a target="<?php print $teaser['link_blank'];?>" href="<?php print $teaser['teaser_link'];?>"> <?php } ?>
            <?php print $teaser['teaser_titel'];?>
            <?php if (strlen($teaser['teaser_link'])>0) { ?></a><?php } ?>
    </h4>
<?php if (strlen($teaser['teaser_highlight_text'])>0) { ?><p class="text-highlight"><?php print $teaser['teaser_highlight_text'];?></p> <?php } ?>
<?php print $teaser['teaser_text'];?>
<?php if (strlen($teaser['teaser_button_text'])>0 AND strlen($teaser['teaser_link'])>0) { ?>
    <a target="<?php print $teaser['link_blank'];?>" class="button button-full" title="<?php print $teaser['teaser_button_text'];?>" href="<?php print $teaser['teaser_link'];?>"><?php print $teaser['teaser_button_text'];?></a>
<?php } ?>
</div>
<?php } ?>
<?php break;
//teaser modul highlight //
case "teaser_modul_highlight":
?>
<?php foreach($zeile['inhaltstyp'][0]['teaser'] as $teaser) { ?>
    <div class="teaser-modul-highlight">
        <img class="teaser-img" src="<?php print $teaser['teaser_bild']['url'];?>" alt="<?php print $teaser['teaser_bild']['alt'];?>" title="<?php print $teaser['teaser_bild']['alt'];?>"/>
        <div class="textarea">
            <h4>
                <?php if (strlen($teaser['teaser_link'])>0) { ?><a href="<?php print $teaser['teaser_link'];?>"> <?php } ?>
                    <?php print $teaser['teaser_titel'];?>
                    <?php if (strlen($teaser['teaser_link'])>0) { ?></a><?php } ?>
            </h4>
            <?php if (strlen($teaser['teaser_highlight_text'])>0) { ?><p class="text-highlight"><?php print $teaser['teaser_highlight_text'];?></p> <?php } ?>
            <?php print $teaser['teaser_text'];?>
            <?php if (strlen($teaser['teaser_buttontext'])>0) { ?><a class="button" href="<?php print $teaser['teaser_link'];?>"><?php print $teaser['teaser_buttontext'];?></a> <?php } ?>
        </div>
    </div>
<?php } ?>
<?php break;

//Testimonial
case "testimonial":
//$zeile['inhaltstyp'][0]['bild']
//$zeile['inhaltstyp'][0]['headline']
//$zeile['inhaltstyp'][0]['autor']
//$zeile['inhaltstyp'][0]['autor_beschreibung']
//$zeile['inhaltstyp'][0]['autor_link']
//$zeile['inhaltstyp'][0]['link']
//$zeile['inhaltstyp'][0]['buttontext']
//$zeile['inhaltstyp'][0]['link_target']
foreach ($zeile['inhaltstyp'][0]['testimonials'] as $testimonial) { ?>
    <div class="testimonial testimonial-slide card clearfix">
        <div class="testimonial-img">
            <?php if (strlen($testimonial['autor_link'])>0) { ?>
            <a target="_blank" href="<?php print $testimonial['autor_link'];?>">
                <?php } ?>
                <img class="teaser-img" alt="<?php print $testimonial['autor']; ?>" title="<?php print $testimonial['autor']; ?>" src="<?php print $testimonial['bild']['url'];?>">
                <?php if (strlen($testimonial['autor_link'])>0) { ?>
            </a>
        <?php } ?>
        </div>
        <div class="testimonial-text">
            <div class="teaser-cat"><?php if (strlen($testimonial['autor_link'])>0) { ?>
                <a target="_blank" href="<?php print $testimonial['autor_link'];?>"><?php } ?>
                    <?php print $testimonial['autor'];?>
                    <?php if (strlen($testimonial['autor_link'])>0) { ?></a><?php } ?></div>
            <p><b><?php print $testimonial['autor_beschreibung'];?></b></p>
            <p><?php print $testimonial['headline'];?></p>
            <?php if (strlen($testimonial['buttontext'])>0) { ?>
                <a class="button button-red" target="<?php print $testimonial['link_target'];?>" href="<?php print $testimonial['link'];?>" ><?php print $testimonial['buttontext'];?></a>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<?php break;

//Content-CTA (Shortcode Webinar / Testimonials)
case "content_cta":
//$zeile['inhaltstyp'][0]['bild']
//$zeile['inhaltstyp'][0]['headline_red']
//$zeile['inhaltstyp'][0]['headline']
//$zeile['inhaltstyp'][0]['text']
//$zeile['inhaltstyp'][0]['link']
//$zeile['inhaltstyp'][0]['buttontext']
//$zeile['inhaltstyp'][0]['link_target']
?>
    <div class="webinar-teaser card clearfix">
        <div class="webinar-teaser-img">
            <a target="<?php print $zeile['inhaltstyp'][0]['link_target'];?>" href="<?php print $zeile['inhaltstyp'][0]['link'];?>" title="<?php print $zeile['inhaltstyp'][0]['headline']; ?>">
                <img class="teaser-img" alt="<?php print $zeile['inhaltstyp'][0]['headline']; ?>" title="<?php print $zeile['inhaltstyp'][0]['headline']; ?>" src="<?php print $zeile['inhaltstyp'][0]['bild']['url'];?>">
            </a>
        </div>
        <div class="webinar-teaser-text">
            <div class="teaser-cat"><?php print $zeile['inhaltstyp'][0]['headline_red'];?></div>
            <h3><?php print $zeile['inhaltstyp'][0]['headline'];?></h3>
            <?php print $zeile['inhaltstyp'][0]['text']; ?>
            <a target="<?php print $zeile['inhaltstyp'][0]['link_target'];?>" class="button button-red" href="<?php print $zeile['inhaltstyp'][0]['link'];?>" title="<?php print $zeile['inhaltstyp'][0]['headline']; ?>"><?php print $zeile['inhaltstyp'][0]['buttontext'];?></a>
        </div>
    </div>
<?php break;

//Textblock + Image Modul (paragraph image)
case "paragraph_image":
?>
    <div class="teaser teaser-large">
        <?php if ($zeile['inhaltstyp'][0]['ausrichtung'] == "bild") { ?>
            <img class="" src="<?php print $zeile['inhaltstyp'][0]['bild']['url'];?>" alt="<?php print $zeile['inhaltstyp'][0]['bild']['alt'];?>" title="<?php print $zeile['inhaltstyp'][0]['bild']['alt'];?>"/>
        <?php } else { print $zeile['inhaltstyp'][0]['text']; } ?>
    </div>
    <div class="teaser teaser-large">
        <?php if ($zeile['inhaltstyp'][0]['ausrichtung'] == "text") { ?>
            <img class="" src="<?php print $zeile['inhaltstyp'][0]['bild']['url'];?>" alt="<?php print $zeile['inhaltstyp'][0]['bild']['alt'];?>" title="<?php print $zeile['inhaltstyp'][0]['bild']['alt'];?>"/>
        <?php } else { print $zeile['inhaltstyp'][0]['text']; } ?>
    </div>
<?php break;
//teaser highlight module
case "teaser_highlight":
$standard_icon_teaser_highlight = get_field('standard_icon_teaser_highlight', 'options');
if ($zeile['inhaltstyp'][0]['link_target'] != false) { $target = "_blank"; } else { $target="_self"; } ?>
    <a class="teaser-highlight teaser-highlight-linkwrap"  href="<?php print $zeile['inhaltstyp'][0]['link'];?>" target="<?php print $target;?>">
        <div class="teaser-highlight-container">
            <!--starting teaser highlight content-->
            <div class="teaser-highlight-img">
                <img title="<?php print $standard_icon_teaser_highlight['alt'];?>" alt="<?php print $standard_icon_teaser_highlight['alt'];?>" src="<?php print $standard_icon_teaser_highlight['url'];?>" />
            </div>
            <div class="teaser-highlight-text">
                <h3><?php print $zeile['inhaltstyp'][0]['headline'];?></h3>
                <p><?php print $zeile['inhaltstyp'][0]['text'];?></p>
            </div>
            <!--ending teaser highlight content-->
        </div>
    </a>
<?php
break;
//banner / background module
case "banner_bg":
if (strlen($zeile['inhaltstyp'][0]['link'])>0) {
if ($zeile['inhaltstyp'][0]['link_target'] != false) { $target = "_blank"; } else { $target="_self"; } ?>
    <a href="<?php print $zeile['inhaltstyp'][0]['link'];?>" target="<?php print $target;?>">
<?php } ?>
<?php print $zeile['inhaltstyp'][0]['text'];
if (strlen($zeile['inhaltstyp'][0]['link'])>0) { ?>
    </a>
<?php }
break;

//Tabelle
case "tabelle":
?>
<?php if (strlen($zeile['inhaltstyp'][0]['headline'])>0) { ;?><h2><?php print $zeile['inhaltstyp'][0]['headline'];?></h2><?php } ?>
<?php if (strlen($zeile['inhaltstyp'][0]['introtext'])>0) { ;?><?php print $zeile['inhaltstyp'][0]['introtext'];?><?php } ?>
    <table>
        <?php $trcount = 0;
        $has_heading = false;
        $has_body = false;
        foreach($zeile['inhaltstyp'][0]['zeilen'] as $tr) {
        $trcount++;
        if ($trcount == 1 AND $tr['titelzeile'] == true) {
            $has_heading = true;
            ?>
            <thead>
            <?php foreach($tr['felder'] as $td) { ?>
                <th><?php print $td['feld'];?></th>
            <?php } ?>
            </thead>
        <?php } else { ?>
    <?php if (($has_body == false) AND (($trcount == 1 AND $tr['titelzeile'] == false) OR ($trcount == 2 AND $has_heading == true))) { ?>
        <tbody>
        <?php
        $has_body = true;
        } ?>
        <tr>
            <?php foreach($tr['felder'] as $td) { ?>
                <td>
                    <?php print $td['feld'];?>
                </td>
            <?php } ?>
        </tr>
        <?php } ?>
        <?php } ?>
        <?php if ($has_body == true) { ?> </tbody> <?php } ?>
    </table>
<?php break;

case "timetable":
//anzahl_raume
//moderator_raum_1
//moderator_raum_2
//moderator_raum_3
//freitext_raum_1
//freitext_raum_2
//freitext_raum_3
//timetable ?>
<?php $anzahl_raume = $zeile['inhaltstyp'][0]['anzahl_raume'];
$fullcolspan = $anzahl_raume;
?>
<?php if (strlen($zeile['inhaltstyp'][0]['headline'])>0) { ;?><h2><?php print $zeile['inhaltstyp'][0]['headline'];?></h2><?php } ?>
<?php if (strlen($zeile['inhaltstyp'][0]['introtext'])>0) { ;?><?php print $zeile['inhaltstyp'][0]['introtext'];?><?php } ?>
<?php if ($zeile['inhaltstyp'][0]['timetable_verstecken'] != 1) { ?>
    <div class="legend">

        <div class="table-cats">
            <b>Legende:</b>
            <i class="cat1 fa fa-circle"></i> Anfänger
            <i class="cat2 fa fa-circle"></i> Fortgeschrittene
            <i class="cat3 fa fa-circle"></i> Experten
        </div>
    </div>

    <table>
        <thead>
        <th class="time"><b>Uhrzeit</b></th>
        <th class="room"><b>Raum 1</b><br />Moderator: <?php print $zeile['inhaltstyp'][0]['moderator_raum_1']->post_title;?></th>
        <th class="room"><b>Raum 2</b><br />Moderator: <?php print $zeile['inhaltstyp'][0]['moderator_raum_2']->post_title;?></th>
        <?php if ($anzahl_raume >2) { ?>
            <th class="room"><b>Raum 3</b><br />Moderator: <?php print $zeile['inhaltstyp'][0]['moderator_raum_3']->post_title;?></th>
        <?php } ?>
        </thead>
        <tbody>
        <?php foreach ($zeile['inhaltstyp'][0]['timetable'] as $zeile) { ?>
            <tr>
                <td class="time"><b><?php print $zeile['uhrzeit'];?></b></td>
                <?php //find out if the other columns have entries, if not, increase colspan!
                if ( strlen($zeile['vortrag_raum_1']->ID)>0 OR strlen($zeile['freitext_raum_1'])>0) { $occupied1 = true; } else { $occupied1 = false; }
                if ( strlen($zeile['vortrag_raum_2']->ID)>0 OR strlen($zeile['freitext_raum_2'])>0) { $occupied2 = true; } else { $occupied2 = false; }
                if ( strlen($zeile['vortrag_raum_3']->ID)>0 OR strlen($zeile['freitext_raum_3'])>0) { $occupied3 = true; } else { $occupied3 = false; }

                if (true == $occupied1) {
                    if (false == $occupied2 AND false == $occupied3) {
                        $colspan1 = $fullcolspan;;
                        $alignment = "left";
                    } else {
                        $colspan1 = "1"; }
                }else {
                    $colspan1 = "0"; }

                if (true == $occupied2) {
                    if (false == $occupied1 AND false == $occupied3) {
                        $colspan2 = $fullcolspan;
                        $alignment = "center";
                    } else {
                        $colspan2 = "1"; }
                } else {
                    $colspan2 = "0"; }

                if (true == $occupied3) {
                    if (false == $occupied2 AND false == $occupied1) {
                        $colspan3 = $fullcolspan;
                        $alignment = "right";
                    } else {
                        $colspan3 = "1"; }
                } else {
                    $colspan3 = "0"; }

                ?>
                <?php if ($colspan1 != 0) { ?>
                    <td class="room" style="text-align:<?php print $alignment;?>;" colspan="<?php print $colspan1;?>"><?php if (strlen($zeile['freitext_raum_1'])>0) {
                            print $zeile['freitext_raum_1']; } else {
                            $vortrag_id = $zeile['vortrag_raum_1']->ID;
                            if (strlen($vortrag_id)>0) {
                                $titel = get_field('vorschautitel_des_vortrags', $vortrag_id);
                                $schwierigkeitsgrad = get_field('schwierigkeitsgrad', $vortrag_id);
                                $speaker = get_field('speaker', $vortrag_id);
                                $speaker_name =$speaker->post_title;
                                ?>
                                <b><?php print $speaker_name;?></b><br /><?php print $titel;?>
                                <div class="table-cats">
                                    <?php if (in_array(1, $schwierigkeitsgrad)) { ?><i class="cat1 fa fa-circle"></i><?php } ?>
                                    <?php if (in_array(2, $schwierigkeitsgrad)) { ?><i class="cat2 fa fa-circle"></i><?php } ?>
                                    <?php if (in_array(3, $schwierigkeitsgrad)) { ?><i class="cat3 fa fa-circle"></i><?php } ?>
                                </div>
                            <?php }
                        } ?>
                    </td> <?php } //end raum 1?>
                <?php if ($colspan2 != 0) { ?>
                    <td class="room" style="text-align:<?php print $alignment;?>;" colspan="<?php print $colspan2;?>"><?php if (strlen($zeile['freitext_raum_2'])>0) {
                            print $zeile['freitext_raum_2']; } else {
                            $vortrag_id = $zeile['vortrag_raum_2']->ID;
                            if (strlen($vortrag_id)>0) {
                                $titel = get_field('vorschautitel_des_vortrags', $vortrag_id);
                                $schwierigkeitsgrad = get_field('schwierigkeitsgrad', $vortrag_id);
                                $speaker = get_field('speaker', $vortrag_id);
                                $speaker_name =$speaker->post_title;
                                ?>
                                <b><?php print $speaker_name;?></b><br /><?php print $titel;?>
                                <div class="table-cats">
                                    <?php if (in_array(1, $schwierigkeitsgrad)) { ?><i class="cat1 fa fa-circle"></i><?php } ?>
                                    <?php if (in_array(2, $schwierigkeitsgrad)) { ?><i class="cat2 fa fa-circle"></i><?php } ?>
                                    <?php if (in_array(3, $schwierigkeitsgrad)) { ?><i class="cat3 fa fa-circle"></i><?php } ?>
                                </div>
                            <?php }
                        } ?>
                    </td> <?php } //end raum 2?>
                <?php if ($colspan3 != 0) { ?>
                    <td class="room" style="text-align:<?php print $alignment;?>;" colspan="<?php print $colspan3;?>"><?php if (strlen($zeile['freitext_raum_3'])>0) {
                            print $zeile['freitext_raum_3']; } else {
                            $vortrag_id = $zeile['vortrag_raum_3']->ID;
                            if (strlen($vortrag_id)>0) {
                                $titel = get_field('vorschautitel_des_vortrags', $vortrag_id);
                                $schwierigkeitsgrad = get_field('schwierigkeitsgrad', $vortrag_id);
                                $speaker = get_field('speaker', $vortrag_id);
                                $speaker_name =$speaker->post_title;
                                ?>
                                <b><?php print $speaker_name;?></b><br /><?php print $titel;?>
                                <div class="table-cats">
                                    <?php if (in_array(1, $schwierigkeitsgrad)) { ?><i class="cat1 fa fa-circle"></i><?php } ?>
                                    <?php if (in_array(2, $schwierigkeitsgrad)) { ?><i class="cat2 fa fa-circle"></i><?php } ?>
                                    <?php if (in_array(3, $schwierigkeitsgrad)) { ?><i class="cat3 fa fa-circle"></i><?php } ?>
                                </div>
                            <?php }
                        } ?>
                    </td> <?php } //end raum 3?>
            </tr>
        <?php } //end foreach Zeile ?>
        </tbody>
    </table>
<?php } //end of if timetable verstecken != 1?>
<?php break;

//Kontaktformular
case "kontaktformular":
//gravity_forms_id
//formular_button_text
//formular_effekt
$formular_button_text = $zeile['inhaltstyp'][0]['formular_button_text'];
if (strlen($formular_button_text)<1) { $formular_button_text = "Jetzt Formular ausfüllen!"; }
switch ($zeile['inhaltstyp'][0]['formular_effekt']) {
case "normal":
    echo do_shortcode( '[gravityform id="' . $zeile['inhaltstyp'][0]['gravity_forms_id'] . '" title="true" description="true" tabindex="0"]' );
    break;
case "lightbox": ?>
    <a data-effect="<?php print $zeile['inhaltstyp'][0]['formular_effekt'];?>" data-id="form-<?php print $zeile['inhaltstyp'][0]['gravity_forms_id'];?>" class="activate-form button button-red" href="#"><?php print $formular_button_text;?></a>
    <div id="form-<?php print $zeile['inhaltstyp'][0]['gravity_forms_id'];?>" class="contact-lightbox hidden">
        <?php echo do_shortcode( '[gravityform ajax=true id="' . $zeile['inhaltstyp'][0]['gravity_forms_id'] . '" title="true" description="true" tabindex="0"]' ); ?>
    </div>
<?php break;
case "fadein": ?>
    <a data-effect="<?php print $zeile['inhaltstyp'][0]['formular_effekt'];?>" class="activate-form button button-red" href="#"><?php print $formular_button_text;?></a>
    <div class="contact-fade">
        <?php echo do_shortcode( '[gravityform id="' . $zeile['inhaltstyp'][0]['gravity_forms_id'] . '" title="true" description="true" tabindex="0"]' ); ?>
    </div>
<?php break;
}
?>
<?php break;

case "blog_grid": ?>
    <h3 class="shbh_small"><?php print $zeile['inhaltstyp'][0]['headline_small'];?></h3>
    <h2 class="shbh_big"><?php print $zeile['inhaltstyp'][0]['headline_big'];?></h2>
    <div class="blog-wrap">
        <?php
        $args = array(
            'posts_per_page'    => $zeile['inhaltstyp'][0]['anzahl_angezeigter_artikel'],
            'cat' => $zeile['inhaltstyp'][0]['kategorie'],
            'author' => $zeile['inhaltstyp'][0]['autor']
        );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <?php
            $post_id = get_the_ID();
            //print $post_id;
            $featured_img_url = get_the_post_thumbnail_url($post_id, 'blog-thumb-500x-333');
            ?>
            <div class="blog-post">
                <a class="post-url" href="<?php print get_permalink($post_id);?>">
                    <div class="post-image-wrap">
                        <img class="post-image" src="<?php print $featured_img_url; ?>" alt="<?php print get_the_title($post_id);?>"/>
                    </div>
                    <h3 class="post-title"><?php print get_the_title();?></h3>
                    <?php if (1 != $zeile['inhaltstyp'][0]['only_title']) { ?>
                        <p class="post-excerpt"><?php print get_the_excerpt();?></p>
                    <?php } ?>
                </a>
                <?php $author__ID = "user_".get_post_field( 'post_author', $post_id );?>
                <?php $author_thumbnail = get_field('profilbild', $author__ID);?>
                <?php $post_cat = get_the_category();
                $category_id = $post_cat[0]->term_id;?>
                <?php if (1 != $zeile['inhaltstyp'][0]['only_title']) { ?>
                    <div class="author-thumbnail">
                        <img alt="<?php print get_the_author_meta( 'user_nicename' );?>" src="<?php print $author_thumbnail['sizes']['thumbnail'];?>"/>
                    </div>
                    <div class="post-meta">
                        <p class="post-date">Datum: <?php print get_the_time(get_option('date_format')); ?></p>
                        <p class="post-cat">Kategorie: <a href="<?php print get_term_link( $category_id ); ?>"><?php print $post_cat[0]->name;?></a></p>
                        <p class="post-author">Autor: <?php print bones_get_the_author_posts_link($author__ID);?></p>
                        <p class="post-length">Lesezeit: <?php echo reading_time(); ?></p>
                    </div>
                <?php } ?>
            </div>
        <?php endwhile;?>
    </div>
<?php break;
case "google_map": ?>
<?php
//karte
//marker_icon
//marker_text
//hohe_der_karte
$map_marker_text = $zeile["inhaltstyp"][0]["marker_text"];
$map_marker_image = $zeile["inhaltstyp"][0]["marker_icon"];
$zoom = $zeile["inhaltstyp"][0]["zoomlevel_der_karte"];
$lat=$zeile['inhaltstyp'][0]['karte']['lat'];
$lng=$zeile['inhaltstyp'][0]['karte']['lng'];
?>
    <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyD9Qw28M7pNw6mb0WfJwA1wVO10XzfC7RE&v=3.exp'></script>
    <div id='gmap_canvas' style='height: <?php print $zeile["inhaltstyp"][0]["hohe_der_karte"];?>px;width:100%;'></div>
    <style>#gmap_canvas img{max-width:none!important;background:none!important}</style>
    <script type='text/javascript'>
        function init_map(){
            var myOptions = {
                zoom: <?php print $zoom;?>,
                draggable: false,
                scrollwheel: false,
                center:new google.maps.LatLng(<?php print ($lat);?>,<?php print $lng;?>),
                //styles: [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}],
                mapTypeId: google.maps.MapTypeId.ROADMAP};
            map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
            marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(<?php print $lat;?>,<?php print $lng;?>)});
            <?php if (strlen($map_marker_text)>0) { ?>infowindow = new google.maps.InfoWindow({content:'<p class="marker-content"><img src="<?php print $map_marker_image['url'];?>"/><?php print $map_marker_text;?></p>'});<?php } ?>
            google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});
            <?php if (strlen($map_marker_text)>0) { ?>infowindow.open(map,marker);<?php } ?>
        }
        google.maps.event.addDomListener(window, 'load', init_map);
    </script>

<?php break;

//Video Youtube
case "video":
$embed_code = $zeile["inhaltstyp"][0]["video_embed_code"]; ?>
<?php /*    <div class="vidembed">
        <iframe title="YouTube video player" src="https://www.youtube.com/embed/<?php print $embed_code;?>?enablejsapi=1&origin=<?php print get_permalink();?>" frameborder="0"  allowfullscreen defer async></iframe>
    </div>*/ ?>
    <div class="youtube lazy-youtube" data-embed="<?php print $embed_code;?>">
        <div class="play-button"></div>
    </div>
<?php break;
case "kontaktformular":
    ?>
    <?php echo do_shortcode( '[gravityform id="' . $zeile['inhaltstyp'][0]['gravity_forms_id'] . '" title="true" description="true" tabindex="0"]' ); ?>
    <?php break;


//Video Wistia
case "video_wistia":
$embed_code = $zeile["inhaltstyp"][0]["video_embed_code"]; ?>
<?php /* <div class="vidembed_wrap rx-module<?php //print $zeile['inhaltstyp'][0]['vertikale_ausrichtung'];?>" <?php if (strlen($maximalbreite)>0) { ?>style="max-width:<?php print $maximalbreite;?>px;" <?php } ?>>*/?>
    <script src="//fast.wistia.com/embed/medias/<?php print $embed_code;?>.jsonp" async></script>
    <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
    <div class="wistia_responsive_padding">
        <div class="wistia_responsive_wrapper">
            <div class="wistia_embed wistia_async_<?php print $embed_code;?>">&nbsp;</div>
        </div>
    </div>

<?php break;
case "kontaktformular":
    ?>
    <?php echo do_shortcode( '[gravityform id="' . $zeile['inhaltstyp'][0]['gravity_forms_id'] . '" title="true" description="true" tabindex="0"]' ); ?>
    <?php break;

//Webinare Anzeigen
case "webinare_anzeigen":
    if (defined('USE_JSON_POSTS_SYNC') && USE_JSON_POSTS_SYNC) {
        require_once ('library/functions/function-webinare.php');
        $author = $zeile['inhaltstyp'][0]['autor'];
        $anzahl = $zeile['inhaltstyp'][0]['anzahl_angezeigter_webinare'];
        $status = $zeile['inhaltstyp'][0]['webinar_status'];
        $highlight_next = $zeile['inhaltstyp'][0]['highlight_next'];
        $reihenfolge = $zeile['inhaltstyp'][0]['reihenfolge'];
        $kategorie = $zeile['inhaltstyp'][0]['kategorie'][0];
        $headline = $zeile['inhaltstyp'][0]['headline'];
        $intro = $zeile['inhaltstyp'][0]['intro'];
        if (strlen($headline)>0) { print "<h2>" . $headline . "</h2>"; }
        if (strlen($intro)>0) { print $intro; }
        display_webinare($anzahl, $reihenfolge, $kategorie, $author,  $status, $highlight_next);
        $button_text = $zeile['inhaltstyp'][0]['button_text'];
        $button_link = $zeile['inhaltstyp'][0]['button_link'];
        if (strlen($button_text)>0) { ?>
            <a class="button after-grid" href="<?php print $button_link;?>"><?php print $button_text;?></a>
        <?php }
    } else {
        echo (new Webinars($zeile['inhaltstyp'][0]))->render();
    }

break;

//Vorträge Anzeigen
case "vortrage_anzeigen":
    require_once ('library/functions/function-vortrage_anzeigen.php');?>
    <?php
    $jahr = $zeile['inhaltstyp'][0]['jahr_auswahlen'];
    display_vortraege($jahr);
    break; //end of vortrage_anzeigen

//Seminare Anzeigen
case "seminare_anzeigen":
require_once ('library/functions/function-seminare.php');?>
<?php
$author = $zeile['inhaltstyp'][0]['autor'];
$anzahl = $zeile['inhaltstyp'][0]['anzahl_angezeigter_seminare'];
$kategorie = $zeile['inhaltstyp'][0]['kategorie'];
$headline = $zeile['inhaltstyp'][0]['headline'];
$intro = $zeile['inhaltstyp'][0]['intro'];
if (strlen($headline)>0) { print "<h2>" . $headline . "</h2>"; }
if (strlen($intro)>0) { print $intro; }
display_seminare($anzahl, $kategorie, $author, 'large', false);
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$button_link = $zeile['inhaltstyp'][0]['button_link'];
if (strlen($button_text)>0) { ?>
    <a class="button after-grid" href="<?php print $button_link;?>"><?php print $button_text;?></a>
<?php }
break; //end of seminare anzeigen

//Seminartypen / Seminarkategorien anzeigen
case "seminartypen_anzeigen":
$seminare = $zeile['inhaltstyp'][0]['seminare'];
foreach ($seminare as $seminar) {
$seminar_image = "asdf";
$seminar_link = get_the_permalink($seminar['seminar']->ID);
$seminar_title = get_the_title($seminar['seminar']->ID);
$seminar_woocommerce = get_field('seminar_woocommerce', $seminar['seminar']->ID);
$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($seminar_woocommerce->ID), 'full' );
$image = $featured_image[0];

?>
    <div class="teaser teaser-small">
        <img class="teaser-img seminar-image" alt="<?php print $seminar_title?>" title="<?php print $seminar_title;?>" src="<?php print $image;?>"/>
        <h4 class="seminarcat-title"><a  href="<?php print $seminar_link?>"><?php print $seminar_title; ?></a></h4>
        <div class="seminar-meta">
        </div>
        <a class="button" href="<?php print $seminar_link?>" title="<?php print $seminar_title; ?>">Termine & Anmeldung</a>
    </div>
<?php }
break;

//Magazinartikel Anzeigen
case "artikel_anzeigen":
require_once ('library/functions/function-magazin.php');?>
<?php
$author = $zeile['inhaltstyp'][0]['autor'];
$anzahl = $zeile['inhaltstyp'][0]['anzahl_angezeigter_artikel'];
$kategorie = $zeile['inhaltstyp'][0]['kategorie'];
$headline = $zeile['inhaltstyp'][0]['headline'];
$ab_x = $zeile['inhaltstyp'][0]['ab_x'];
if ((!isset($ab_x)) OR ($ab_x<1)) { $ab_x = 1; }
if (strlen($headline)>0) { print "<h2>" . $headline . "</h2>"; }
display_magazinartikel($anzahl, $kategorie, $author, false, $ab_x);
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$button_link = $zeile['inhaltstyp'][0]['button_link'];
if (strlen($button_text)>0) { ?>
    <a class="button after-grid" href="<?php print $button_link;?>"><?php print $button_text;?></a>
<?php }
break; //end of artikel anzeigen

//ausgewählte Magazinartikel anzeigen
case "artikel_auswahlen":
$format = $zeile['inhaltstyp'][0]['format'];
$artikelkategorie = $zeile['inhaltstyp'][0]['artikelkategorie'];
if (strlen($format)<1) { $format = "teaser-small"; }
$count = count($zeile['inhaltstyp'][0]['artikel']);
$first_id = $zeile['inhaltstyp'][0]['artikel'][0]['artikel']->ID;
if ($count <= 1 AND strlen($first_id)<1) {
    require_once ('library/functions/function-magazin.php');
    display_magazinartikel(-1, $artikelkategorie, NULL, false, 1, $format);
}
foreach ($zeile['inhaltstyp'][0]['artikel'] as $artikel) {
$artikel_id = $artikel['artikel']->ID;
$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($artikel_id), '350-180' );
$image = $featured_image[0];
$post_type = get_post_type($artikel_id);
$post_type_nice = "";
$autor = get_field('autor', $artikel_id);
$featured_image_teaser = wp_get_attachment_image_src( get_post_thumbnail_id($artikel_id), '350-180' );
$featured_image_highlight = wp_get_attachment_image_src( get_post_thumbnail_id($artikel_id), '550-290' );
$image_teaser = $featured_image_teaser[0];
$image_highlight = $featured_image_highlight[0];
$vorschau_350 = get_field('vorschau-350x180', $id);
if (strlen($vorschau_350['url'])>0) { $image_teaser = $vorschau_350['url']; }
$vorschau_550 = get_field('vorschau-550-290', $id);
if (strlen($vorschau_550['url'])>0) { $image_highlight = $vorschau_550['url']; }
$vorschautext = get_field('vorschautext', $artikel_id);
$image_overlay  = "/uploads/omt-banner-overlay-350.png";
$artikelkategorie = get_field('artikelkategorie', $artikel_id);
if ("teaser-medium" == $format) {
    $image_teaser = $image_highlight;
    $image_overlay  = "/uploads/omt-banner-overlay-550.png";
}

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
    case "inbound": $post_type_nice = "Inbound Marketing"; break;
    case "videomarketing": $post_type_nice = "Video Marketing"; break;
    case "pinterest": $post_type_nice = "Pinterest Marketing"; break;
    case "pagespeed": $post_type_nice = "Wordpress Pagespeed"; break;
    case "plugins": $post_type_nice = "Wordpress Plugins"; break;
}
$title = get_the_title($artikel_id);
$webinar_shorttitle = implode(' ', array_slice(explode(' ', $title), 0, 7));
$wordcount = str_word_count($title);
$post_type_data = get_post_type_object( $post_type );
$post_type_slug = $post_type_data->rewrite['slug'];
if ("wordpress" == $post_type_slug) {
    $post_type_slug = "/online-mrketing-tools/wordpress";
}
if ($wordcount > 7) { $title = $webinar_shorttitle . "..."; }
?>
    <div class="teaser <?php print $format;?> teaser-matchbuttons">
        <div class="teaser-image-wrap" style="">
            <img class="webinar-image teaser-img" alt="<?php print get_the_title($artikel_id);?>" title="<?php print get_the_title($artikel_id);?>" src="<?php print $image_teaser;?>"/>
            <img alt="OMT Magazin" title="OMT Magazin" class="teaser-image-overlay" src="<?php print $image_overlay;?>" style="">
        </div>
        <h2 class="h4 article-title no-ihv"><a href="<?php the_permalink($artikel_id)?>" title="<?php the_title_attribute($artikel_id); ?>"><?php print $title; ?></a></h2>
        <a class="teaser-cat category-link" href="/<?php print $post_type_slug;?>/"><?php print $post_type_nice;?></a>
        <p class="experte no-margin-top no-margin-bottom">
            <a target="_self" href="<?php print get_the_permalink($autor->ID);?>"><?php print get_the_title($autor->ID); ?></a>
            <span style="float:right;"><i class="fa fa-clock-o" style="vertical-align:middle;"></i> <?php echo reading_time($artikel_id);?></span>
        </p>
        <?php if ("teaser-medium" == $format) { ?>
            <div class="vorschautext">
                <?php print strip_tags(substr($vorschautext, 0, 200));
                if (strlen($vorschautext)>200) { print "..."; } ?>
            </div>
        <?php } ?>
        <a class="button" href="<?php the_permalink($artikel_id)?>" title="<?php the_title_attribute($artikel_id); ?>">Artikel lesen</a>
    </div>
<?php }
break;

//Jobs Anzeigen
case "jobs_anzeigen":
require_once ('library/functions/function-jobs.php');?>
<?php
$anzahl = $zeile['inhaltstyp'][0]['anzahl_angezeigter_jobs'];
$headline = $zeile['inhaltstyp'][0]['headline'];
$intro = $zeile['inhaltstyp'][0]['introtext'];
if (strlen($headline)>0) { print "<h2>" . $headline . "</h2>"; }
if (strlen($intro)>0) { print $intro; }
/*?>
    <form class="clearfix" id="jobs-filter" action="./jobs.html" method="POST">
        <div>
            <div class="select">
                <select id="jobs-location" name="jobs_location">
                    <option value="">Alle Standorte</option>
                    <option value="Berlin">Berlin</option>
                    <option value="Hannover">Hannover</option>
                    <option value="Hamburg">Hamburg</option>
                    <option value="München">München</option>
                    <option value="Nürnberg">Nürnberg</option>
                    <option value="Stuttgart">Stuttgart</option>
                </select>
            </div>
        </div>
        <div>
            <div class="select">
                <select id="jobs-category" name="jobs_categories">
                    <option value="">Alle Kategorien</option>
                    <option value="Suchmaschinenoptimierung">Suchmaschinenoptimierung</option>
                    <option value="Google Adwords (SEA)">Google Adwords (SEA)</option>
                    <option value="Linkbuilding">Linkbuilding</option>
                    <option value="Google Analytics">Google Analytics</option>
                    <option value="Content Marketing">Content Marketing</option>
                    <option value="Social Media Marketing">Social Media Marketing</option>
                </select>
            </div>
        </div>
    </form>
    <div class="margin-bottom-75">
        <a href="#" class="button button-full button-gradient">Zum Job-Newsletter anmelden!</a>
    </div>
<?php*/
display_jobs($anzahl);
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$button_link = $zeile['inhaltstyp'][0]['button_link'];
if (strlen($button_text)>0) { ?>
    <a class="button after-grid" href="<?php print $button_link;?>"><?php print $button_text;?></a>
<?php }
break; //end of jobs anzeigen

//Trends Anzeigen
case "trends_anzeigen":
    require_once ('library/functions/function-trends-anzeigen.php');
    $headline = $zeile['inhaltstyp'][0]['headline'];
    $intro = $zeile['inhaltstyp'][0]['introtext'];
    if (strlen($headline)>0) { print "<h2>" . $headline . "</h2>"; }
    if (strlen($intro)>0) { print $intro; }
    $auswahl = $zeile['inhaltstyp'][0]['trends_auswahlen'];
    trends_anzeigen($auswahl);
    break;

//tools anzeigen
case "tools_anzeigen":
//require_once ('library/functions/function-tools-anzeigen.php');
$toolabschnitte = $zeile['inhaltstyp'][0]['toolabschnitte'];
foreach ($toolabschnitte as $abschnitt) {
?>
<?php
$headline = $abschnitt['uberschrift'];
$intro = $abschnitt['introtext'];
$tools = $abschnitt['tools'];
$toolkategorie = $abschnitt['toolkategorie'];
if (strlen($toolkategorie) >0) {
    $tools = get_posts(array(
        'post_type' => 'tool',
        'posts_per_page'    => -1,
        'post_status' => array( 'publish', 'private'),
        'orderby' => array( 'meta_value_num' => 'DESC', 'title' => 'ASC' ),
        'meta_key'          => 'wert',
        'tax_query' => array(
            array(
                'taxonomy' => 'tooltyp',
                'field' => 'id',
                'terms' => $toolkategorie, // Where term_id of Term 1 is "1".
            )
        )
    ));
}

if (strlen($headline)>0) { print "<h2>" . $headline . "</h2>"; }
if (strlen($intro)>0) { print $intro; }
foreach ($tools as $tool) {
$ID = $tool->ID;
$logo = get_field('logo', $ID);
$vorschautitel_fur_index = get_field('vorschautitel_fur_index', $ID);
$vorschautext = get_field('vorschautext', $ID);
$zur_webseite = get_field('zur_webseite', $ID);
$test_verlinken = get_field('test_verlinken', $ID);
///
$zeilen = get_field('zeilen', $ID);

?>

<?php if (count($zeilen)<2) { // check if this is a regular tool or a page-like build ?>
    <div class="testimonial card clearfix expertenstimme">
        <div class="testimonial-img">
            <h3 class="experte tool"><?php print $vorschautitel_fur_index;?></h3>
            <img class="teaser-img" alt="<?php print $logo['alt'];?>" title="<?php print $logo['alt'];?>" src="<?php print $logo['url'];?>"/>
        </div>
        <div class="testimonial-text">
            <?php print $vorschautext;?>
            <?php if (strlen($zur_webseite)>0) { ?><a class="button no-clear button-red margin-right-30" rel="nofollow" href="<?php print $zur_webseite;?>" target="_blank">Zum Tool</a><?php } ?>
            <?php if (1 == $test_verlinken) { ?><a class="button no-clear" target="_self" href="<?php print get_permalink($ID);?>">Zum Testbericht</a><?php } ?>
        </div>
    </div>
<?php } ?>
<?php } ?>
<?php }
break;

//VIP Tool bzw. VIP Produkt / Tool

case "vip_produkt":
$name = $zeile['inhaltstyp'][0]['name'];
$bild = $zeile['inhaltstyp'][0]['bild'];
$link = $zeile['inhaltstyp'][0]['link'];
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$checkliste_linke_spalte = $zeile['inhaltstyp'][0]['checkliste_linke_spalte'];
$checkliste_rechte_spalte = $zeile['inhaltstyp'][0]['checkliste_rechte_spalte'];
//name
//wahr_falsch ?>
    <a href="<?php print $link;?>" class="testimonial card clearfix vip-produkt" target="_blank">
        <h3 class="experte"><?php print $name;?></h3>
        <h4 class="teaser-cat experte-info"><?php print $speakerbeschreibung;?></h4>
        <div class="testimonial-img">
            <img class="teaser-img" alt="<?php print $name; ?>" title="<?php print $name; ?>" src="<?php print $bild['sizes']['350-180'];?>">
            <span class="button has-margin-top-30 button-red"  ><?php print $button_text;?></span>

        </div>
        <div class="testimonial-text checklist-wrap">
            <div class="checklist checklist-left">
                <?php foreach ($checkliste_linke_spalte as $item) {?>
                    <div class="checklist-item">
                        <div class="name"><?php print $item['name'];?></div>
                        <div class="status"><?php if (1 == $item['wahr_falsch']) { ?><i class="fa fa-check"></i> <?php } else { ?> <i class="fa fa-times"></i><?php };?></div>
                    </div>
                <?php } ?>
            </div>
            <div class="checklist checklist-right">
                <?php foreach ($checkliste_rechte_spalte as $item_r) { ?>
                    <div class="checklist-item">
                        <div class="name"><?php print $item_r['name'];?></div>
                        <div class="status"><?php if (1 == $item_r['wahr_falsch']) { ?><i class="fa fa-check"></i> <?php } else { ?> <i class="fa fa-times"></i><?php };?></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </a>
<?php break;

//Vergleichstabelle wie beim Bettedeckentest
case "vergleichstabelle_tools":
$eigenschaften_titel = $zeile['inhaltstyp'][0]['eigenschaften_titel'];
$bewertungen_titel = $zeile['inhaltstyp'][0]['bewertungen_titel'];
$tools_auswahlen = $zeile['inhaltstyp'][0]['tools_auswahlen'];
//tool
//bewertung_text
//bewertung_datum
//bewertung_sterne
//eigenschaften__werte
//bewertungen__werte
//testsieger
?>
    <table class="vergleichstabelle">
        <tr>
            <th></th>
            <?php
            $count_with_pricelink = 0;
            $count_with_toollink = 0;
            ?>
            <?php foreach($tools_auswahlen as $tool) {
                $ID = $tool['tool']->ID;
                $tool_image = get_field('logo', $ID);
                $tool_title = str_replace('Privat: ', "", get_the_title($ID));
                if (strlen($tool['link_price'])>0) { $count_with_pricelink++; };
                if (strlen($tool['link'])>0) { $count_with_toollink++; };
                ?>
                <td class="logo-wrap">
                    <img class="tool-image" alt="<?php print $tool_title;?>" title="<?php print $tool_title;?>" src="<?php print $tool_image['url'];?>">
                </td>
            <?php } ?>
        </tr>
        <tr>
            <th>Tool</th>
            <?php foreach($tools_auswahlen as $tool) {
                $ID = $tool['tool']->ID;
                $tool_title = str_replace('Privat: ', "", get_the_title($ID));
                ?>
                <td><?php print $tool_title;?></td>
            <?php } ?>
        </tr>
        <?php $eigenschaften_i = 0;
        foreach($eigenschaften_titel as $titel) { ?>
            <tr>
                <th><?php print $titel['eigenschaft'];?></th>
                <?php foreach( $tools_auswahlen as $tool) { ?>
                    <td>
                        <?php if ("true" == $tool['eigenschaften__werte'][$eigenschaften_i]['wert']) { ?><i class="fa fa-check"></i> <?php } ?>
                        <?php if ("false" == $tool['eigenschaften__werte'][$eigenschaften_i]['wert']) { ?><i class="fa fa-times"></i> <?php } ?>
                        <?php if ("false" != $tool['eigenschaften__werte'][$eigenschaften_i]['wert'] AND "true" != $tool['eigenschaften__werte'][$eigenschaften_i]['wert']) { print $tool['eigenschaften__werte'][$eigenschaften_i]['wert']; } ?>
                    </td>
                <?php } ?>
            </tr>
            <?php
            $eigenschaften_i++;
        } ?>
        <?php if ($count_with_pricelink>0) { ?>
            <tr>
                <th>
                    Preise
                </th>
                <?php foreach($tools_auswahlen as $tool) { ?>
                    <td><?php if (strlen($tool['link_price'])>0) { ?><a href="<?php print $tool['link_price'];?>" target="_blank">zur Preisübersicht</a><?php } ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
        <?php if ($count_with_toollink>0) { ?>
            <tr>
                <th>
                    Website
                </th>
                <?php foreach($tools_auswahlen as $tool) { ?>
                    <td><?php if (strlen($tool['link'])>0) { ?><a class="button button-red" href="<?php print $tool['link'];?>" target="_blank">zum Tool</a><?php } ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>
<?php
//mobile Version
?>
    <div class="vergleichstabelle-mobile">
        <?php
        foreach($tools_auswahlen as $tool) {
            $ID = $tool['tool']->ID;
            $tool_image = get_field('logo', $ID);
            $tool_title = str_replace('Privat: ', "", get_the_title($ID));
            ?>
            <div class="tool card">
                <img class="tool-image" alt="<?php print $tool_title;?>" title="<?php print $tool_title;?>" src="<?php print $tool_image['url'];?>">
                <?php $eigenschaften_i = 0;
                foreach($eigenschaften_titel as $titel) { ?>
                    <p><strong><?php print $titel['eigenschaft'];?>: </strong>
                        <?php if ("true" == $tool['eigenschaften__werte'][$eigenschaften_i]['wert']) { ?><i class="fa fa-check"></i> <?php } ?>
                        <?php if ("false" == $tool['eigenschaften__werte'][$eigenschaften_i]['wert']) { ?><i class="fa fa-times"></i> <?php } ?>
                        <?php if ("false" != $tool['eigenschaften__werte'][$eigenschaften_i]['wert'] AND "true" != $tool['eigenschaften__werte'][$eigenschaften_i]['wert']) { print $tool['eigenschaften__werte'][$eigenschaften_i]['wert']; } ?>
                    </p>
                    <?php
                    $eigenschaften_i++;
                } ?>
                <p><?php if (strlen($tool['link_price'])>0) { ?><a href="<?php print $tool['link_price'];?>" target="_blank">zur Preisübersicht</a><?php } ?></p>
                <?php if (strlen($tool['link'])>0) { ?><a class="button button-red" href="<?php print $tool['link'];?>" target="_blank">zum Tool</a><?php } ?>
            </div>
        <?php }
        break;

        //Branchenbuch Agentursuche
        case "branchenbuch_agentursuche":
            require_once ('library/functions/function-branchenbuch-suche.php');
            $headline = $zeile['inhaltstyp'][0]['headline'];
            $intro = $zeile['inhaltstyp'][0]['introtext']; if (strlen($headline)>0) { print "<h2 class='has-0-degrees'>" . $headline . "</h2>"; }
            branchenbuch_suche();
            break;

        //Branchenbuch Premiumagenturen
        case "branchenbuch_premium":
            require_once ('library/functions/function-branchenbuch-premium.php');
            $headline = $zeile['inhaltstyp'][0]['headline'];
            $intro = $zeile['inhaltstyp'][0]['introtext'];if (strlen($headline)>0) { print "<h2 class='has-0-degrees'>" . $headline . "</h2>"; }
            branchenbuch_premiumagenturen();
            break;

        //Branchenbuch Liste
        case "branchenbuch_liste":
            require_once ('library/functions/function-branchenbuch-liste.php');
            $headline = $zeile['inhaltstyp'][0]['headline'];
            $intro = $zeile['inhaltstyp'][0]['introtext'];
            $typ = $zeile['inhaltstyp'][0]['art'];
            if (strlen($headline)>0) { print "<h2 class='has-0-degrees'>" . $headline . "</h2>"; }
            branchenbuch_liste($typ);
            break;

        //Webinar Zusammenfassungen
        case "webinar_zusammenfassungen":?>
            <?php foreach ($zeile['inhaltstyp'][0]['webinare'] as $webinar) {
                $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
                $webinar_ID = $webinar['webinar']->ID;
                $webinar_datum = get_field("webinar_datum", $webinar_ID);
                $webinar_time = get_field("webinar_uhrzeit_start");
                $webinar_compare = $webinar_day . " " . $webinar_time;
                $webinar_date_compare = strtotime($webinar_compare); //convert seminar date to unix string for future-check the entries
                $webinar_speaker = get_field("webinar_speaker", $webinar_ID);
                $speaker_image = get_field("profilbild", $webinar_speaker->ID);
                $webinar_zusammenfassung = get_field("webinar_zusammenfassung", $webinar_ID);
                $webinar_title = get_the_title($webinar_ID);
                $webinar_vorschautitel = get_field("webinar_vorschautitel", $webinar_ID);
                $webinar_video = get_field("webinar_youtube_embed_code", $webinar_ID);
                $webinar_type = "youtube";
                $wistia = get_field("webinar_wistia_embed_code", $webinar_ID);
                if (!is_user_logged_in() AND strlen($wistia)>0) { $webinar_video = $wistia; $webinar_type = "wistia"; }
                ?>
                <div class="webinar-zusammenfassung">
                    <h2><?php print $webinar_vorschautitel; ?></h2>
                    <div class="webinar-teaser card clearfix" data-id="<?php if ($today_date > $webinar_date_compare) { print $webinar_video; }?>">
                        <div class="webinar-teaser-img">
                            <a data-type="<?php print $webinar_type;?>" data-id="<?php print $webinar_video;?>" href="#webinar-anschauen" title="<?php print $webinar_title; ?>" class="open-video">
                                <img class="teaser-img" alt="<?php print $webinar_title; ?>" title="<?php print $webinar_title; ?>" src="<?php print $speaker_image['sizes']['350-180'];?>">
                            </a>
                        </div>
                        <div class="webinar-teaser-text">
                            <div class="teaser-cat">Webinar mit <?php print get_the_title($webinar_speaker->ID);?></div>
                            <p><?php showBeforeMore(get_field('webinar_beschreibung', $webinar_ID)); ?></p>
                            <?php /*<a href="<?php the_permalink($webinar_ID);?>" title="<?php print $webinar_title; ?>" class="button button-red">Gratis anschauen</a>*/?>
                            <a data-type="<?php print $webinar_type;?>" data-id="<?php print $webinar_video;?>" href="#webinar-anschauen" title="<?php print $webinar_title; ?>" class="open-video button button-red">Gratis anschauen</a>
                        </div>
                    </div>
                    <?php print $webinar_zusammenfassung;?>
                </div>
            <?php }
            break;
        //END OF Webinar Zusammenfassungen

        //Webinar Teaser Wiederholungsfeld
        case "webinare_teaser_wiederholungsfeld":
//webinare_auswahlen
//webinar
            foreach ($zeile['inhaltstyp'][0]['webinare_auswahlen'] as $webinar) {
                $webinar_ID = $webinar['webinar']->ID;
                $today_date = date(strtotime("now"));  ////****get current time as unix string for future-check the entries
                $webinar_datum = get_field("webinar_datum", $webinar_ID);
                $webinar_day = substr($webinar_datum,0,10);
                $webinar_time = get_field("webinar_uhrzeit_start", $webinar_ID);
                $webinar_time_ende = get_field("webinar_uhrzeit_ende", $webinar_ID);
                $webinar_speaker = get_field("webinar_speaker", $webinar_ID);
                $webinar_vorschautitel = get_field("webinar_vorschautitel", $webinar_ID);
                $webinar_beschreibung_temp = get_field("webinar_beschreibung", $webinar_ID);
                $webinar_beschreibung = str_replace('<h2 id="beschreibung">Beschreibung zum <strong>kostenlosen</strong> Online Marketing Webinar</h2>', '', $webinar_beschreibung_temp);
                $alternative_beschreibung_fur_themenwelten = get_field("alternative_beschreibung_fur_themenwelten", $webinar_ID);
                if ( strlen ($alternative_beschreibung_fur_themenwelten) < 1 ) {
                    //$alternative_beschreibung_fur_themenwelten = substr($webinar_beschreibung,0,220) . "...";
                    $pieces = explode(" ", strip_tags($webinar_beschreibung));
                    $alternative_beschreibung_fur_themenwelten = implode(" ", array_splice($pieces, 0, 25)) . " ...";
                }
                $link_zur_aufzeichnung = get_field("link_zur_aufzeichnung", $webinar_ID);
                $speaker_image = get_field("profilbild", $webinar_speaker->ID);
                $webinar_compare = $webinar_day . " " . $webinar_time;

                $webinar_date_compare = strtotime($webinar_compare); //convert seminar date to unix string for future-check the entries
                //Convert it into a timestamp.
                $timestamp = strtotime($webinar_day);
                //Convert it to DD-MM-YYYY
                $webinar_day = date("d.m.Y", $timestamp);
                $webinar_title = get_the_title($webinar_ID);
                $webinar_cta_bild = get_field("webinar_cta_bild", $webinar_ID);
                $webinare_standard_cta_vorschaubild = get_field('webinare_standard_cta_vorschaubild', '594');
                $webinar_video = get_field("webinar_youtube_embed_code", $webinar_ID);
                $webinar_type = "youtube";
                $wistia = get_field("webinar_wistia_embed_code", $webinar_ID);
                if (!is_user_logged_in() AND strlen($wistia)>0) { $webinar_video = $wistia; $webinar_type = "wistia"; }
                ?>
                <?php //*****NEW WEBINAR TEASER STRUCTURE///*****////?>
                <div class="webinar-teaser card clearfix" data-id="<?php if ($today_date > $webinar_date_compare) { print $webinar_video; }?>">
                    <div class="webinar-teaser-img">
                        <a data-type="<?php print $webinar_type;?>" data-id="<?php print $webinar_video;?>" href="#webinar-anschauen" title="<?php print $webinar_title; ?>" class="open-video">
                            <img class="teaser-img" alt="<?php print $webinar_title; ?>" title="<?php print $webinar_title; ?>" src="<?php print $speaker_image['sizes']['350-180'];?>">
                        </a>
                    </div>
                    <div class="webinar-teaser-text">
                        <div class="teaser-cat">Webinar</div>
                        <h3><?php print $webinar_vorschautitel; ?> — <?php print $webinar_speaker->post_title;?></h3>
                        <p><?php showBeforeMore(get_field('webinar_beschreibung', $webinar_ID)); ?></p>
                        <a data-type="<?php print $webinar_type;?>" data-id="<?php print $webinar_video;?>" href="#webinar-anschauen" title="<?php print $webinar_title; ?>" class="open-video button button-red">Gratis anschauen</a>
                    </div>
                </div>
            <?php }
            break;
        //END OF Webinar Teaser Wiederholungsfeld

        //Expertenstimmen Modul Ausgabe
        case "expertenstimmen":
//type: expertenstimmen
//kategorie
//stimmen_alternativ
////expertenstimme
//experte_speaker
//speakerbeschreibung
//inhalt
//kategorie
            if (strlen($zeile['inhaltstyp'][0]['stimmen_alternativ'][0]['expertenstimme']->ID)>0) {
                foreach ($zeile['inhaltstyp'][0]['stimmen_alternativ'] as $expertenstimme) {
                    $expertenstimme = $expertenstimme['expertenstimme'];
                    $experte = get_field('experte_speaker', $expertenstimme ->ID);
                    $speakerbeschreibung = get_field('speakerbeschreibung', $expertenstimme ->ID);
                    $inhalt = get_field('inhalt', $expertenstimme ->ID);
                    $kategorie = get_field('kategorie', $expertenstimme ->ID);
                    $speaker_image = get_field("profilbild", $experte->ID);
                    $speaker_name = $experte->post_title;
                    $speaker_link = get_the_permalink($experte->ID);
                    ?>
                    <div class="testimonial card clearfix expertenstimme">
                        <h3 class="experte"><a target="_self" href="<?php print $speaker_link;?>"><?php print $speaker_name;?></a></h3>
                        <h4 class="teaser-cat experte-info"><?php print $speakerbeschreibung;?></h4>
                        <div class="testimonial-img">
                            <a target="_self" href="<?php print $speaker_link;?>">
                                <img class="teaser-img" alt="<?php print $speaker_name; ?>" title="<?php print $speaker_name; ?>" src="<?php print $speaker_image['sizes']['350-180'];?>">
                            </a>
                        </div>
                        <div class="testimonial-text">
                            <?php print $inhalt;?>
                        </div>
                    </div>
                <?php } ?>
            <?php } else {
                require_once ('library/functions/function-expertenstimmen.php');
                $kategorie = $zeile['inhaltstyp'][0]['kategorie'];
                display_expertenstimmen($kategorie);
            }
            break;
        //END of Expertenstimmen Modul Ausgabe

        //Konferenzticket
        case "konferenzticket":
            $product = $zeile['inhaltstyp'][0]['produkt'];
            $handle=new WC_Product_Variable($product->ID);
            $available_variations = $handle->get_available_variations();
            $variations1=$handle->get_children();
            foreach ($variations1 as $ticketvariation) {   /*build array with all seminars and all repeater date fields*/
//collecting data
                $single_variation = new WC_Product_Variation($ticketvariation);
                ?>
                <?php
//print_r($single_variation);
                $ticketkategorie = $single_variation->attributes['ticketkategorie'];
                $ticketstatus = $single_variation->attributes['status'];
                $preis = $single_variation->price;
                $lager = $single_variation->stock_quantity;
                $beschreibung = $single_variation->description;
                $ticket_variation_id = $single_variation->get_variation_id();
                $ticket_img_id = $single_variation->get_image_id();
                ?>
                <span class="anchor" id="ticket"></span>
                <div class="teaser teaser-small ticket <?php if ($lager<1) { print "ticket-inactive"; } ?>">
                    <?php /*<img class="teaser-img" title="<?php print $ticketkategorie;?>" alt="<?php print $ticketkategorie;?>" src="<?php print wp_get_attachment_image_src($ticket_img_id, 'full')[0];?>"/>
        <span class="teaser-cat"><?php print $product->post_title;?></span>*/?>
                    <h4 class="ticket-type"><?php print $ticketkategorie;?></h4>
                    <p class="ticket-price"><?php print $preis;?>,- &euro;</p>
                    <p class="ticket-info"><?php print strip_tags($beschreibung);?></p>
                    <?php if ($lager>0) { ?>
                        <a data-ticket-type="<?php print $ticketkategorie;?>" class="button button-gradient" href="/kasse/?add-to-cart=<?php print $product->ID;?>&attribute_ticketkategorie=<?php print $ticketkategorie;?>" title="<?php the_title_attribute(); ?>">Ticket Kaufen</a>
                    <?php } else { ?><div class="button button-gradient">nicht verfügbar</div><?php } ?>
                </div>
            <?php }

            break;
        //END of Konferenzticket

        //Partner / Sponsoren
        case "partner":
            foreach ($zeile['inhaltstyp'][0]['partner'] as $partner) { ?>
                <?php if (strlen($partner['link'])>0) { ?>
                    <a class="teaser teaser-small partner-button partner-button-<?php print $zeile['inhaltstyp'][0]['grose'];?>" href="<?php print $partner['link'];?>">
                        <img class="partner-single" src="<?php print $partner['logo']['url'];?>" alt="<?php print $partner['name'];?>" title="<?php print $partner['name'];?>"/>
                    </a>
                <?php } else { ?>
                    <div class="teaser teaser-small partner-button partner-button-<?php print $zeile['inhaltstyp'][0]['grose'];?>">
                        <img class="partner-single" src="<?php print $partner['logo']['url'];?>" alt="<?php print $partner['name'];?>" title="<?php print $partner['name'];?>"/>
                    </div>
                <?php }
            }

            break;
        //END of Partner / Sponsoren


        //COUNTDOWN
        case "countdown":
//headline
//text
//button_text
//button_link
//zieldatum
            ?>
            <div class="card countdown">
                <h3 class="no-margin-bottom"><?php print $zeile['inhaltstyp'][0]['headline'];?></h3>
                <p class="teaser-cat"><?php print $zeile['inhaltstyp'][0]['text'];?></p>
                <div class="countdown-wrap">
                    <div class="countdown-grid-timer" data-time="<?php print $zeile['inhaltstyp'][0]['zieldatum'];?>">
                    </div>
                    <?php if (strlen($zeile['inhaltstyp'][0]['button_text'])>0) { ?><a class="button button-red" href="<?php print $zeile['inhaltstyp'][0]['button_link'];?>"><?php print $zeile['inhaltstyp'][0]['button_text'];?></a><?php } ?>
                </div>
            </div>

            <?php break;


        //SPEAKERPROFIL ANZEIGEN
        case "speakerprofil":
//speaker_auswahlen
            $autor = $zeile['inhaltstyp'][0]['speaker_auswahlen'];
            $text_extra = $zeile['inhaltstyp'][0]['text_extra'];
            $titel = get_field('titel', $autor->ID);
            $profilbild = get_field('profilbild', $autor->ID);
            $firma = get_field('firma', $autor->ID);
            $speaker_galerie = get_field('speaker_galerie', $autor->ID);
            $beschreibung = get_field('beschreibung', $autor->ID);
            $social_media = get_field('social_media', $autor->ID);
            $speaker_name = get_the_title($autor->ID);

            ?>
            <div class="testimonial-img">
                <a target="_self" href="<?php print get_the_permalink($autor->ID);?>">
                    <img class="teaser-img" alt="<?php print $speaker_name;?>" title="<?php print $speaker_name;?>" src="<?php print $profilbild['sizes']['350-180'];?>"/>
                </a>
            </div>
            <div class="testimonial-text">
                <p class="teaser-cat speakerauswahl-info"><?php print $text_extra;?></p>
                <h3 class="experte has-margin-bottom-30"><a target="_self" href="<?php print get_the_permalink($autor->ID);?>"><?php print $speaker_name; ?></a></h3>
                <?php print $beschreibung;?>
            </div>
            <?php break;

        //alle speaker anzeigen
        case "alle_speaker_anzeigen":
            $speakerargs = array( //next seminare 1st
                'posts_per_page'    => -1,
                'posts_status'    => "publish",
                'post_type'         => 'speaker',
                'order'             => 'ASC',
                'orderby'           => 'title'
            );
            ?>
            <div class="speakers-list container-small">
                <?php
                $current = "A";
                $count = 0;
                $speakerloop = new WP_Query( $speakerargs );
                while ( $speakerloop->have_posts() ) : $speakerloop->the_post(); ?>
                <?php
                $first = substr(get_the_title(),0, 1);
                if ($first == "A" AND $count == 0) { ?>
                <h2>A</h2>
                <ul>
                    <?php }
                    if ($first != $current) {
                    $current = $first; ?>
                </ul>
                <h2><?php print $current;?></h2>
                <ul>
                    <?php  }
                    $count++;
                    ?>
                    <li>
                        <a href="<?php print get_the_permalink();?>"><?php print get_the_title(); ?></a>
                    </li>
                    <?php endwhile;
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
            <?php break;

        } //end of switch case ?>

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
    </section><?php } // end of foreach ROW ?>
    <?php if (1 == $kommentarfunktion_aktivieren) { ?>
        <section class="omt-row color-area-weiss">
            <?php
            comments_template();
            ?>
        </section>
    <?php } ?>
    <?php } ?>
    </div> <?php //end of #content ?>
    <?php get_footer(); ?>