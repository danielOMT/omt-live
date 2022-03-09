<?php
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
$topLeftBannerUrl = getPost()->field('banner_top_left_url');

if (strlen($header_hero_hintergrundbild['url'])>0) { $hero_background = $header_hero_hintergrundbild;}
if (strlen($header_hero_h1)>0) { $h1 = $header_hero_h1;} else { $h1 = get_the_title(); }
 
if ($has_sidebar != false) {
    $extraclass="has-sidebar";
} else { 
    $extraclass = "fullwidth"; 
} 

$class_themenwelt = " template-themenwelt";
?>
<?php if (1 == $alles_730) { $class_themenwelt .=" layout-730"; } ?>

<div id="content" class=" <?php print $extraclass;?>" xmlns:background="http://www.w3.org/1999/xhtml">
    <div class="wrapper omt-row hero-header header-flat" style="background: url('<?php print $hero_background['url'];?>') no-repeat 50% 0;">
        <div class="wrap">
            <h1><?php print $h1;?></h1>
        </div>
    </div>
<?php if (strlen($sticky_button_text)<1) { //Inhaltsverzeichnis einblenden, falls Themenwelt Checkbox angeklickt wurde?>
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
<?php }
$mobile_banner_link = get_field('mobile_banner_link');
$mobile_banner_bild = get_field('mobile_banner_bild');
if (strlen($mobile_banner_link)>0) { ?>
    <div class="omt-row tool-info-mobile">
        <a rel="nofollow" href="<?php print $mobile_banner_link;?>" target="_blank"><img src="<?php print $mobile_banner_bild['url'];?>" alt="<?php print $mobile_banner_bild['alt'];?> title=<?php print $mobile_banner_bild['alt'];?>"/></a>
    </div>
<?php } ?>

<?php if (!empty($topLeftBannerUrl)) : ?>
    <div class="top-left-banner-section single-top-left-banner x-overflow-hidden x-hidden">
        <a href="<?php echo $topLeftBannerUrl ?>" target="_blank" rel="nofollow">
            <img src="<?php echo getPost()->field('banner_top_left', 'image_url') ?>" class="x-m-0 x-w-full" alt="Banner" />
        </a>
    </div>
<?php endif ?>

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