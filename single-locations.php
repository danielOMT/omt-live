<?php get_header(); ?>

<?php
$location_titelbild_overlay_uberschrift = get_field('location_titelbild_overlay_uberschrift');
$location_seminare_headline = get_field('location-seminare_headline');
$weitere_hotels_headline = get_field('weitere_hotels_headline');

$hotel_telefonnummer = get_field('hotel_telefonnummer');
$hotel_homepage = get_field('hotel_homepage');
$hotel_email = get_field('hotel_email');
$hotel_adresse = get_field('hotel_adresse');

$weitere_hotels_in_der_location = get_field('weitere_hotels_in_der_location');
//name
//volle_adresse
//telefon
//homepage
//e-mail

$informationstext = get_field('informationstext');
$bild_unter_informationstext = get_field('bild_unter_informationstext');
$anfahrt_auto = get_field('anfahrt_auto');
$anfahrt_bahn = get_field('anfahrt_bahn');
$anfahrt_flughafen = get_field('anfahrt_flughafen');

$ID = get_the_id();
$unsere_referenten_headline = get_field('unsere_referenten_headline', 576);
$unsere_referenten = get_field('unsere_referenten', 576);
$titelbild = get_the_post_thumbnail_url($ID, 'full');
$wissenswertes = get_field('wissenswertes', 576);
$location_name = get_the_title();
?>
    <div id="content" class="" xmlns:background="http://www.w3.org/1999/xhtml">
        <div id="inner-content" class="wrap clearfix no-hero">
            <div id="main" class="seminar-single clearfix" role="main">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article style="" id="post-<?php the_ID(); ?>" class="clearfix omt-row" role="article">
                        <header class="article-header">
                            <?php /* <img class="article-hero" alt="<?php print get_the_title();?>" title="<?php print get_the_title();?>" src="<?php print $featured_img_url;?>" />*/ ?>
                            <h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
                        </header>
                        <section class="informationen">
                            <?php print $informationstext;?>
                        </section>
                        <section class="entry-content map-location clearfix" itemprop="articleBody">
                            <?php wp_enqueue_script('google-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyD9Qw28M7pNw6mb0WfJwA1wVO10XzfC7RE', null, null, true); // Add in your key ?>
                            <div class="acf-map" style="height:400px;">
                                <div class="marker" data-lat="<?php echo $hotel_adresse['lat']; ?>" data-lng="<?php echo $hotel_adresse['lng']; ?>">
                                    <div class="agentur-titel-wrap">
                                        <h4 style="margin:0 0 10px 0;"><a href="<?php print get_the_permalink($location);?>" target="_blank"><?php print get_the_title($location);?></a></h4>
                                        <p class="agentur-email">
                                            <a href="mailto:<?php print $hotel_email;?>"><?php print $hotel_email;?></a><br/>
                                            Telefon: <?php print $hotel_telefonnummer;?>
                                        </p>
                                    </div>
                                    <div class="agentur-adresse">
                                        <?php // print $agentur['adresse'];?>
                                        <?php print $hotel_adresse['address'];?>
                                    </div>
                                </div>
                            </div>
                            <div class="route-berechnen-wrap">
                                <strong>Route berechnen:</strong>
                                <form action="https://maps.google.com/maps" method="get" target="_blank">
                                    <input class="inputbox" placeholder="Startadresse (mit Ort)" type="text" name="saddr" value="" />
                                    <input type="hidden" name="daddr" value="<?php print $hotel_adresse['address'];?>" />
                                    <button class="route-submit button button-350px button-red" style="display:inline;" type="submit">Routenplanung aufrufen</button>
                                </form>
                            </div>
                        </section>
                        <section class="anfahrt">
                            <div class="accordion">
                                <?php if (strlen($anfahrt_auto)>0) { ?>
                                    <div class="accordion-item">
                                        <h3 class="accordion-title">Anfahrt mit dem Auto<span class="fa fa-plus"></span></h3>
                                        <div class="accordion-content">
                                            <?php print $anfahrt_auto;?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (strlen($anfahrt_bahn)>0) { ?>
                                    <div class="accordion-item">
                                        <h3 class="accordion-title">Anfahrt mit der Bahn<span class="fa fa-plus"></span></h3>
                                        <div class="accordion-content">
                                            <?php print $anfahrt_bahn;?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (strlen($anfahrt_flughafen)>0) { ?>
                                    <div class="accordion-item">
                                        <h3 class="accordion-title">Anfahrt vom Flughafen<span class="fa fa-plus"></span></h3>
                                        <div class="accordion-content">
                                            <?php print $anfahrt_flughafen;?>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>

                        </section>
                    </article>
                <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>