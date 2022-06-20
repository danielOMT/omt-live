<?php get_header(); ?>
<?php
$titelbild = get_field('titelbild');
$titelbild_overlay_h1 = get_field('titelbild_overlay_h1');
$inhalt = get_field('inhalt');
$agenturen = get_field('agenturen');
//name
//logo
//adresse
//e-mail
$zuordnung_stadt_oder_branche = get_field('zuordnung_stadt_oder_branche');
$branchenbuch_id = get_the_ID();
///end of branchenbuch data

///create an array with agenturen IDs that have a matching dienstleistung ID entered:
$branchenbuch_id = get_the_id();
$args_agenturen = array(
    'posts_per_page'    => -1,
    'post_type'         => 'agentur',
    'orderby'	        => 'title',
    'order'             => 'ASC'
);
$nonpremiumagenturen_array = array();
$premiumagenturen_array = array();
$stadt_dienstleistungen = array();
$loop = new WP_Query( $args_agenturen ); //*args and query all "?>
<?php while ( $loop->have_posts() ) { $loop->the_post();
    $dienstleistungen = get_field('dienstleistungen');
    $zuordnung_ortliches_branchenbuch = get_field('zuordnung_ortliches_branchenbuch');
    $premiumagentur = get_field('premiumagentur');
    switch ($zuordnung_stadt_oder_branche) {
        case "branche":
            foreach ($dienstleistungen as $leistung) {
                if ($leistung['dienstleistung_branchenbuch']->ID == $branchenbuch_id) {
                    if (1 == $premiumagentur) {
                        $premiumagenturen_array[] = get_the_ID();
                    }
                    else {
                        $nonpremiumagenturen_array[] = get_the_ID();
                    }
                }
            }
            break;
        case "stadt":
            if ($zuordnung_ortliches_branchenbuch->ID == $branchenbuch_id) {
                if (1 == $premiumagentur) {
                    $premiumagenturen_array[] = get_the_ID();
                } else {
                    $nonpremiumagenturen_array[] = get_the_ID();
                }
                foreach ($dienstleistungen as $leistung) { //fill array for branchenfilter in stadt branchenbuch
                    if ($leistung['dienstleistung_branchenbuch']->ID >0) { $stadt_dienstleistungen[] = $leistung['dienstleistung_branchenbuch']->ID; }
                }
            }
            break;
    }
}
wp_reset_postdata();?>
<?php
$agenturen_array = array();
foreach ($premiumagenturen_array as $agentur) {
    $agenturen_array[] = $agentur;
}
foreach ($nonpremiumagenturen_array as $agentur) {
    $agenturen_array[] = $agentur;
}
?>
<?php //// Branchenbuch TITELBILD //?>
    <div id="content" class="" xmlns:background="http://www.w3.org/1999/xhtml">
        <div id="inner-content" class="wrap clearfix no-hero">
            <div id="main" class="omt-row blog-single  clearfix" role="main">
                <h1 class="entry-title single-title h2" itemprop="headline"><?php the_title(); ?></h1>
                <div id="branchenbuch" class="omt-abschnitt single-branchenbuch-content"> <?php //***jobs main leftside***//?>
                    <?php wp_enqueue_script('google-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDFmVEWDZOoE8GtOglBut7XSID-OSC6hK0', null, null, true); ?>
                    <div class="acf-map">
                        <?php foreach ($agenturen_array as $agentur) { ?>
                            <?php $location = get_field('adresse_mapmarker', $agentur);
                            $name = get_field('name', $agentur);
                            $logo = get_field('logo', $agentur);
                            $kontakt_email = get_field('kontakt_e-mail', $agentur);
                            $homepage = get_field('homepage', $agentur);
                            $dienstleistungen = get_field('dienstleistungen', $agentur); //dienstleistung
                            $location = get_field('adresse', $agentur);
                            $premiumagentur = get_field('premiumagentur', $agentur);
                            ?>
                            <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
                                <a target="_blank" class="" href="<?php print get_the_permalink($agentur);?>">
                                    <img class="agentur-logo" alt="<?php print $name;?>" src="<?php print $logo['sizes']['jobs-thumb'];?>"/>
                                    <div class="agentur-titel-wrap">
                                        <p class="agentur-name"><?php print $name;?></p>
                                        <?php if (1==$premiumagentur) { ?><p class="agentur-email"><?php print $kontakt_email;?></p><?php } ?>
                                    </div>
                                    <div class="agentur-adresse">
                                        <?php print $location['address'];?>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="agentur-list">
                        <?php foreach ($agenturen_array as $agentur) { ?>
                            <?php $location = get_field('adresse_mapmarker', $agentur);
                            $name = get_field('name', $agentur);
                            $logo = get_field('logo', $agentur);
                            $kontakt_email = get_field('kontakt_e-mail', $agentur);
                            $homepage = get_field('homepage', $agentur);
                            $dienstleistungen = get_field('dienstleistungen', $agentur); //dienstleistung
                            $location = get_field('adresse', $agentur);
                            $premiumagentur = get_field('premiumagentur', $agentur);
                            $strasse_und_hausnummer = get_field('strasse_und_hausnummer', $agentur);
                            $plz_und_ort = get_field('plz_und_ort', $agentur);
                            ?>
                            <div class="webinar-teaser card clearfix <?php if (1 == $premiumagentur) { print "vip"; }?>">
                                <div class="webinar-teaser-img">
                                    <img class="teaser-img" alt="<?php print $name;?>" title="<?php print $name;?>" src="<?php print $logo['url'];?>"/>
                                </div>
                                <div class="webinar-teaser-text">
                                    <h3><a href="<?php print get_the_permalink($agentur);?>"><?php print $name;?></a></h3>
                                    <?php if ( 1 == $premiumagentur ) {?><span class="agentur-email"><?php print $kontakt_email;?></span><?php } ?>
                                    <div class="agentur-adresse">
                                        <p class="no-margin-top no-margin-bottom"><?php print $strasse_und_hausnummer;?></p>
                                        <p class="no-margin-top no-margin-bottom"><?php print $plz_und_ort;?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <hr>
                    <div class="branchenbuch-infos">
                        <?php print $inhalt;?>
                    </div>
                </div>
                <?php //get_sidebar();?>
            </div> <?php //end of omt-stadt-wrap// ?>
        </div> <?php //end of main// ?>
    </div>
<?php get_footer(); ?>