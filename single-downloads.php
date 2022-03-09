<?php get_header(); ?>
<?php
$post_id = get_the_ID();
$left_image = get_field('left_image');
$hubspot_formular_id = get_field('right_hubspot');
$inhaltseditor = get_field('inhaltseditor');
$webinar_speaker = get_field('experte');
$speaker_image = get_field("profilbild", $webinar_speaker->ID);
$speaker_profil = get_field("beschreibung", $webinar_speaker->ID);
$speaker_titel = get_field("titel", $webinar_speaker->ID);
?>

<div id="content" class="" xmlns:background="http://www.w3.org/1999/xhtml">
    <?php /* <div class="hero-header" style="background: url('<?php print $hero_image['url'];?>') no-repeat 50% 0;">
        <div class="wrap">
            <h2 class="h1"><?php print $h1;?></h2>
        </div>
    </div>*/?>
    <div id="inner-content" class="wrap clearfix no-hero">
        <div id="main" class="omt-row blog-single  clearfix" role="main">
            <h1 class="entry-title single-title h2 has-margin-bottom-30" itemprop="headline"><?php the_title(); ?></h1>
            <article style="" id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
                <section class="entry-content clearfix" itemprop="articleBody">
                    <div class="content-intro clearfix">
                        <div class="half left-half">
                            <img class="download-image" alt="<?php print $left_image['alt'];?>" title="<?php print $left_image['alt'];?>" src="<?php print $left_image['url'];?>"/>
                        </div>
                        <div class="half right-half">
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
                        </div>
                    </div>
                </section>
                <section style="" class="omt-row wrap">
                    <?php print $inhaltseditor;?>
                </section>
                <section style="" class="omt-row wrap">
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
                </section>
            </article>
        </div>
        <?php //get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>

