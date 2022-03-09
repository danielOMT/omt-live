<?php get_header(); ?>
<?php
$post_id = get_the_ID();
$featured_img_url = get_the_post_thumbnail_url($post_id, 'post-image');
$beschreibung_des_vortrags = get_field('beschreibung_des_vortrags');
$speaker = get_field('speaker');
$veranstaltung = get_field('veranstaltung');
$wistia_embed_code = get_field('wistia_embed_code');
$wistia_embed_code_mitglieder = get_field('wistia_embed_code_mitglieder');
?>
    <div id="content" xmlns:background="http://www.w3.org/1999/xhtml">
        <div id="inner-content" class="wrap clearfix magazin-single-wrap  no-hero">
            <div id="main" class="blog-single magazin-single clearfix" role="main">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article style="" id="post-<?php the_ID(); ?>" class="omt-row" role="article">
                        <header class="article-header">
                            <?php if (strlen($veranstaltung['url'])>0) { ?><img class="veranstaltung" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $veranstaltung['url'];?>"/><?php } ?>
                            <h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
                        </header>

                        <?php //***WEBINAR VIDEO UND DOWNLOADS + SONSTIGE FEATURES AUSGEBEN**//?>
                        <?php if (strlen($wistia_embed_code)>0 OR strlen($wistia_embed_code_mitglieder)>0) {  //webinar video erst nach club launch aktivieren ?>
                        <div class="video_wrap">
                            <div class="webinar-video">
                                <?php if (!is_user_logged_in()) {
                                    if (strlen($wistia_embed_code) > 0) { ?>
                                        <div class="video-wrap player-wrap" data-members="<?php print $wistia_embed_code_mitglieder; ?>">
                                            <script src="//fast.wistia.com/embed/medias/<?php print $wistia_embed_code; ?>.jsonp" async></script>
                                            <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                                            <div class="wistia_responsive_padding">
                                                <div class="wistia_responsive_wrapper">
                                                    <div class="wistia_embed wistia_async_<?php print $wistia_embed_code; ?>">
                                                        &nbsp;
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                                if (is_user_logged_in()) { ?>
                                    <?php if (strlen($wistia_embed_code_mitglieder) >0 ) { ?>
                                        <div class="video-wrap">
                                            <script src="//fast.wistia.com/embed/medias/<?php print $wistia_embed_code_mitglieder;?>.jsonp" async></script>
                                            <script src="//fast.wistia.com/assets/external/E-v1.js" async></script>
                                            <div class="wistia_responsive_padding">
                                                <div class="wistia_responsive_wrapper">
                                                    <div class="wistia_embed wistia_async_<?php print $wistia_embed_code_mitglieder;?>">&nbsp;</div>
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
                        <?php } /***END OF VORTRAGS VIDEO AUSGEBEN*/ ?>


                        <section class="entry-content clearfix inhaltseditor" itemprop="articleBody">
                            <?php print $beschreibung_des_vortrags; ?>
                        </section>
                    </article>
                    <section style="" id="post-<?php the_ID(); ?>" class="omt-row wrap">
                        <?php foreach($speaker as $vortrags_speaker) { ?>
                        <div class="testimonial card clearfix speakerprofil">
                            <?php
                            $profilbild = get_field('profilbild', $vortrags_speaker->ID);
                            $firma = get_field('firma', $vortrags_speaker->ID);
                            $speaker_galerie = get_field('speaker_galerie', $vortrags_speaker->ID);
                            $beschreibung = get_field('beschreibung', $vortrags_speaker->ID);
                            $social_media = get_field('social_media', $vortrags_speaker->ID);
                            $speaker_name = get_the_title($vortrags_speaker->ID);
                            ?>
                            <div class="testimonial-img">
                                <h3 class="experte"><a target="_self" href="<?php print get_the_permalink($vortrags_speaker->ID);?>"><?php print $speaker_name; ?></a></h3>
                                <h4 class="teaser-cat experte-info"></h4>
                                <a target="_self" href="<?php print get_the_permalink($vortrags_speaker->ID);?>">
                                    <img class="teaser-img" alt="<?php print $speaker_name;?>" title="<?php print $speaker_name;?>" src="<?php print $profilbild['url'];?>"/>
                                </a>
                            </div>
                            <div class="testimonial-text">
                                <?php print $beschreibung;?>
                            </div>
                        </div>
                        <?php } ?>
                        <?php //comments_template(); ?>
                    </section>
                <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <?php //get_sidebar(); ?>
        </div>
    </div>

<?php get_footer(); ?>