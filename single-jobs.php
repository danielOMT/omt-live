
<?php
$titel = get_the_title();
$date = get_the_date();
$titelbild = get_field('titelbild', 2275);
$post_date = get_the_time( 'U' );
$curr_time = current_time( 'U' );
$time_diff = ($curr_time - $post_date) / (24 * 3600);
if ($post_art == "job") {
    if ($time_diff > 100 ) {
        header("Location:https://www.omt.de/jobs/", true, 301);
        exit;
    }
}
$job_hervorheben_class = '';
$arbeitgeber_name = get_field('arbeitgeber_name');
$arbeitgeber_logo = get_field('arbeitgeber_logo');
$arbeitgeber_logo_id = get_field('arbeitgeber_logo_id');
$jobbeschreibung = get_field('jobbeschreibung');
$bewerbungsinfo = get_field('bewerbungsinfo');
$wie_arbeiten = get_field('wie_arbeiten');
$stelle_frei_ab = get_field('stelle_frei_ab');
$bewerbung_email_adresse = get_field('bewerbung_email_adresse');
$stadt = get_field('stadt');
$gehalt = get_field('gehalt');
$job_hervorheben = get_field('job_hervorheben');
$arbeitgeber_url = get_field('arbeitgeber_url');
$standard_icon_teaser_highlight = get_field('standard_icon_teaser_highlight', 'options');
if (strlen($arbeitgeber_logo_id)>0) { $arbeitgeber_logo['url'] = $arbeitgeber_logo_id; }
if($job_hervorheben == 1){ $job_hervorheben_class = 'ribbon_'; $no_border = 'ribbon_link';}else{$job_hervorheben_class = ''; $no_border = '';}

get_header(); ?>
<div class="socials-floatbar-left">
    <?php print do_shortcode('[shariff headline="<p>Job teilen:</p>" borderradius="1" services="facebook|twitter|googleplus|linkedin|xing" theme="round" orientation="vertical"]');?>
</div>
<div id="content" class="" xmlns:background="http://www.w3.org/1999/xhtml">
    <?php /* <div class="hero-header" style="background: url('<?php print $hero_image['url'];?>') no-repeat 50% 0;">
        <div class="wrap">
            <h2 class="h1"><?php print $h1;?></h2>
        </div>
    </div>*/?>
    <div id="inner-content" class="wrap clearfix no-hero">
        <div id="main" class="omt-row blog-single  jobs-single clearfix" role="main">
            <h1 class="h2 entry-title single-title job-title" itemprop="headline"><?php the_title(); ?></h1>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article style="" id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
                    <section class="entry-content clearfix" itemprop="articleBody">
                        <div class="webinar-teaser card clearfix <?=$job_hervorheben_class;?>"  data-ribbon="Hot Job">
                            <div class="webinar-teaser-img">
                                <img class="teaser-img" alt="<?php print $arbeitgeber_name?>" title="<?php print $arbeitgeber_name; ?>" src="<?php print $arbeitgeber_logo['url'];?>">
                            </div>
                            <div class="webinar-teaser-text">
                                <?php //print_r($arbeitgeber_logo);?>
                                <div class="teaser-cat">Diese Stelle ist frei ab dem <?php print $stelle_frei_ab;?></div>
                                <h3><?php print $arbeitgeber_name;?></h3>
                                <?php if (strlen($arbeitgeber_url)>0) { ?><p class="job-homepage no-margin-bottom no-margin-top"><?php print $arbeitgeber_url;?></p><?php } ?>
                                <p class="no-margin-bottom no-margin-top"><strong>In: </strong><span class="job-ort"><?php print $stadt;?></span></p>
                                <p class="no-margin-bottom no-margin-top"><strong>Art: </strong><span class=" job-art"><?php print $wie_arbeiten;?></span></p>
                                <a class="button" href="mailto:<?php print $bewerbung_email_adresse;?>?subject=<?php print get_the_title();?>%20-%20OMT%20Jobs">Jetzt bewerben</a>
                            </div>
                        </div>
                        <div class="jobbeschreibung">
                            <h3>Jobbeschreibung:</h3>
                            <?php print $jobbeschreibung;?>
                        </div>
                        <div class="bewerbungsinformationen">
                        <h3>Bewerbungsinformationen:</h3>
                            <?php /*if (strlen($gehalt)>0) { ?><p class="job-gehalt no-margin-bottom no-margin-top">Gehalt: <?php print $gehalt;?></p><?php }*/ ?>
                            <?php print $bewerbungsinfo;?>
                        </div>
                        <div class="teaser-highlight teaser-highlight-red">
                            <a class="teaser-highlight-container" href="mailto:<?php print $bewerbung_email_adresse;?>?subject=<?php print get_the_title();?>%20-%20OMT%20Jobs">
                                <!--starting teaser highlight content-->
                                <div class="teaser-highlight-img">
                                    <img title="<?php print $standard_icon_teaser_highlight['alt'];?>" alt="<?php print $standard_icon_teaser_highlight['alt'];?>" src="<?php print $standard_icon_teaser_highlight['url'];?>" width="130" />
                                </div>
                                <div class="teaser-highlight-text">
                                    <h3>Jetzt bewerben!</h3>
                                </div>
                                <!--ending teaser highlight content-->
                            </a>
                        </div>
                    </section>
                    <?php //comments_template(); ?>
                </article>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <?php //get_sidebar(); ?>
    </div>
</div>
<div class="socials-floatbar-mobile">
    <?php echo do_shortcode('[shariff services="facebook|twitter|googleplus|linkedin|xing" backend="on" lang="de" theme="round" borderradius="1" buttonstretch="1"]'); ?>
</div>
<?php get_footer(); ?>

