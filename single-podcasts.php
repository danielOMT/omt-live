<?php get_header(); ?>
<?php
$post_id = get_the_ID();
$hero_image = get_field('podinar_titelbild');
$h1 = get_field('podinare_einzelansicht_text', 'options');
$podinar_vorschautitel = get_field('podinar_vorschautitel');
$soundcloud = get_field('soundcloud_iframe_link');
//$podinar_day = substr($podinar_datum,0,10);
$podinar_speakers = get_field('podinar_speaker');
$podinar_beschreibung = get_field('podinar_beschreibung');
$podcast_introtext = get_field('podcast_introtext');
$podinarID = get_field('podinarID');
$podinar_abonnieren_optionen = get_field('podinar_abonnieren_optionen', 'options');
?>
<div class="socials-floatbar-left">
    <?php print do_shortcode('[shariff headline="<p>Podcast-Folge<br/>teilen:</p>" borderradius="1" services="facebook|twitter|googleplus|linkedin|xing" theme="round" orientation="vertical"]');?>
</div>
<div id="content" class="" xmlns:background="http://www.w3.org/1999/xhtml">
    <div id="inner-content" class="wrap clearfix no-hero">
        <div id="main" class="omt-row blog-single  clearfix" role="main">
            <?php /*if (strlen($hero_image['url'])>0) { ?>
            <img class="article-hero magazin-hero" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $hero_image['sizes']['730-380'];?>" />
            <?php } */?>
            <h1 class="entry-title single-title h2 has-margin-bottom-30" itemprop="headline"><?php the_title(); ?></h1>
            <?php if (strlen($podcast_introtext)>0) { ?><div class="omt-module"><?php print $podcast_introtext; ?></div> <?php } ?>
            <?php  if (strlen($soundcloud)>0) { //SOUNDCLOUD ?>
                    <?php
                    //  $soundcloud = '<iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/323253642&color=%23c0cedb&auto_play=false&hide_related=true&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>';
                    $trackpos = strpos($soundcloud, "/tracks/");
                    $trackid_start = substr($soundcloud, $trackpos+8);
                    $trackendpos = strpos($trackid_start, "&color=");
                    $trackid = substr($trackid_start,0,$trackendpos);
                    ?>
                    <iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/<?php print $trackid;?>&color=%23ea506c&auto_play=false&hide_related=true&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>
            <?php } ?>
            <div class="omt-module podcast-abonnieren teaser-modul">
                <?php $podinar_abonnieren_optionen = get_field('podinar_abonnieren_optionen', 'options');?>
                <?php foreach ($podinar_abonnieren_optionen as $option) { ?>
                    <a class="teaser-small teaser-xsmall abonnieren" target="_blank" href="<?php print $option['link'];?>">
                        <h3>Podcast<br/>abonnieren</h3>
                        <?php switch ($option['titel']) {
                            case "Apple Podcasts": ?><i class="fa fa-apple"></i><?php break;
                            case "Google Podcast": ?><i class="fa fa-google"></i><?php break;
                            case "Spotify": ?><i class="fa fa-spotify"></i><?php break;
                            case "Soundcloud": ?><i class="fa fa-soundcloud"></i><?php break;
                        } ?>
                        <span style="color:white;"><?php print $option['titel'];?></span>
                    </a>
                <?php } ?>
            </div>
            <?php if (strlen($podinar_beschreibung)>0) { ?><div class="omt-module">
                <h2>Die Shownotes der aktuellen Podcast-Folge</h2>
                <?php print $podinar_beschreibung; ?></div> <?php }

            foreach($podinar_speakers as $podinar_speaker) {
                $speaker_image = get_field("profilbild", $podinar_speaker->ID);
                $speaker_profil = get_field("beschreibung", $podinar_speaker->ID);
                $speaker_titel = get_field("titel", $podinar_speaker->ID);
                ?>
                <div class="testimonial card clearfix speakerprofil">
                    <h3 class="experte"><a target="_self" href="<?php print the_permalink($podinar_speaker->ID);?>"><?php print $podinar_speaker->post_title;?></a></h3>
                    <div class="testimonial-img">
                        <a target="_self" href="<?php print the_permalink($podinar_speaker->ID);?>">
                            <img class="teaser-img" alt="<?php print $speaker_image['alt'];?>" title="<?php print $speaker_image['alt'];?>" src="<?php print $speaker_image['sizes']['350-180'];?>"/>
                        </a>
                    </div>
                    <div class="testimonial-text">
                        <?php print $speaker_profil;?>
                    </div>
                </div>
                <a class="button button-730px button-grey centered has-margin-top-30" href="<?php print get_permalink($podinar_speaker->ID);?>">Mehr über <?php print $podinar_speaker->post_title;?> erfahren</a>
            <?php } ?>


        </div>
        <?php //get_sidebar(); ?>
    </div>
</div>
<div class="socials-floatbar-mobile">
    <?php echo do_shortcode('[shariff services="facebook|twitter|googleplus|linkedin|xing" backend="on" lang="de" theme="round" borderradius="1" buttonstretch="1"]'); ?>
</div>
<?php get_footer(); ?>

