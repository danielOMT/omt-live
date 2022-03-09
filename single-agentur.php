<?php get_header(); ?>
<?php
//$name = get_field('name');
$name = get_the_title();
$logo = get_field('logo');
$logo_aus_formular = get_field('logo_aus_formular');
if (strlen($logo_aus_formular)>0) {
    $logo['url'] = $logo_aus_formular;
    $logo['sizes']['jobs-thumb'] = $logo_aus_formular;
}
$strasse_und_hausnummer = get_field('strasse_und_hausnummer');
$plz_und_ort = get_field('plz_und_ort');
$telefonnummer = get_field('telefonnummer');
$kontakt_email = get_field('kontakt_e-mail');
$homepage = get_field('homepage');
$dienstleistungen = get_field('dienstleistungen'); //dienstleistung
$beschreibung = get_field('beschreibung');
$location = get_field('adresse');
$premiumagentur = get_field('premiumagentur');
$zuordnung_ortliches_branchenbuch = get_field('zuordnung_ortliches_branchenbuch');
$branchenbuch_id = $zuordnung_ortliches_branchenbuch -> ID;
?>
<?php //// Branchenbuch TITELBILD //?>
    <div id="content" class="" xmlns:background="http://www.w3.org/1999/xhtml">
        <div id="inner-content" class="wrap clearfix no-hero">
            <div id="main" class="omt-row blog-single  clearfix" role="main">
                <h1 class="entry-title single-title h2" itemprop="headline"><?php the_title(); ?></h1>
<div class="agentur-beschreibung">
                    <?php print $beschreibung;?>
                </div>
                <div class="webinar-teaser card agentur-info clearfix <?php if (1 == $premiumagentur) { print "vip"; }?>">
                    <div class="webinar-teaser-img">
                        <img class="teaser-img" alt="<?php print $name;?>" title="<?php print $name;?>" src="<?php print $logo['url'];?>"/>
                    </div>
                    <div class="webinar-teaser-text">
                        <h3>Adresse:</h3>
                        <p><?php print $strasse_und_hausnummer;?></p>
                        <p><?php print $plz_und_ort;?></p>
                        <?php if (1 == $premiumagentur) { ?>
                            <p>Tel.:&nbsp;<?php print $telefonnummer;?></p>
                            <p><a href="mailto:<?php print $kontakt_email;?>">Kontakt</a>&nbsp;|&nbsp;<a target="_blank" href="<?php print $homepage;?>">Web</a></p>
                        <?php } ?>
                    </div>
                    <?php if (1!=$premiumagentur) { ?>
                        <a style="display: inline-block;width: 100%;clear: both;border-bottom: none;" class="" href="/branchenbucheintrag/">Agentur eintragen | Deine Agentur? Daten aktualisieren!</a>
                    <?php } ?>
                </div>
                <div class="teaser-modul">
                    <div class="teaser teaser-medium">
                        <div class="maps-wrap">
                            <?php
                            wp_enqueue_script('google-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyD9Qw28M7pNw6mb0WfJwA1wVO10XzfC7RE', null, null, true); // Add in your key
                            // ACF Google Map Single Map Output
                            //$location = get_field('location'); // Set the ACF location field to a variable
                            //wp_enqueue_script('acfmaps', get_stylesheet_directory_uri() . '/library/js/acf-maps.js', array('jquery'), '', true);
                            ?>
                            <div class="acf-map">
                                <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
                                    <a class="" href="<?php if (strlen($homepage) >=1 && 1 == $premiumagentur) { print $homepage; } else {print "#agentur";}?>">
                                        <img class="agentur-logo" alt="<?php print $name;?>" src="<?php print $logo['sizes']['jobs-thumb'];?>"/>
                                        <div class="agentur-titel-wrap">
                                            <p class="agentur-name"><?php print $name;?></p>
                                            <?php if (1 == $premiumagentur) { ?> <p class="agentur-email"><?php print $kontakt_email;?></p> <?php } ?>
                                        </div>
                                        <div class="agentur-adresse">
                                            <?php print $strasse_und_hausnummer . "<br/>" . $plz_und_ort;?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="teaser teaser-medium">
                        <h3>Dienstleistungen:</h3>
                        <ul class="check">
                            <?php foreach ($dienstleistungen as $leistung) { ?>
                                <li>
                                    <?php if (strlen($leistung['dienstleistung_branchenbuch']->ID)>0) {
                                        $dienstleistung_link = get_the_permalink($leistung['dienstleistung_branchenbuch']->ID);
                                        $dienstleistung = get_the_title($leistung['dienstleistung_branchenbuch']->ID);
                                        ?>
                                        <?php print str_replace('Agenturen für ', '', $dienstleistung);?>
                                    <?php } ?>
                                    <?php if (strlen($leistung['dienstleistung_branchenbuch']->ID)<1) { print $leistung['dienstleistung']; } ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div> <?php //end of omt-stadt-wrap// ?>
        </div> <?php //end of main// ?>
    </div>
<?php get_footer(); ?>