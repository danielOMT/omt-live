<?php
function branchenbuch_premiumagenturen() {
    $args_agenturen = array(
        'posts_per_page'    => -1,
        'post_type'         => 'agentur',
        'orderby'	        => 'title',
        'order'             => 'ASC'
    );
$agenturen_array = array();
$loop = new WP_Query( $args_agenturen ); //*args and query all "?>
<?php while ( $loop->have_posts() ) {
    $loop->the_post();
    $premiumagentur = get_field('premiumagentur');
    if (1 == $premiumagentur) { $agenturen_array[] = get_the_ID(); }
} ?>
<?php wp_enqueue_script('google-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDFmVEWDZOoE8GtOglBut7XSID-OSC6hK0', null, null, true); // Add in your key
?>
<div class="acf-map">
    <?php foreach ($agenturen_array as $agentur) { ?>
        <?php $location = get_field('adresse_mapmarker', $agentur);
        //$name = get_field('name', $agentur);
        $name = get_the_title($agentur);
        $logo = get_field('logo', $agentur);
        $logo_aus_formular = get_field('logo_aus_formular', $agentur);
        if (strlen($logo_aus_formular)>0) {
            $logo['url'] = $logo_aus_formular;
            $logo['sizes']['jobs-thumb'] = $logo_aus_formular;
        }
        $kontakt_email = get_field('kontakt_e-mail', $agentur);
        $homepage = get_field('homepage', $agentur);
        $dienstleistungen = get_field('dienstleistungen', $agentur); //dienstleistung
        $location = get_field('adresse', $agentur);
        $premiumagentur = get_field('premiumagentur', $agentur);
        ?>
        <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
            <a target="_blank" class="" href="<?php print get_the_permalink($agentur);?>">
                <img class="agentur-logo" alt="<?php print $name;?>" src="<?php print $logo['url'];?>"/>
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
        $name = get_the_title($agentur);
        //$name = get_field('name', $agentur);
        $logo = get_field('logo', $agentur);
        $logo_aus_formular = get_field('logo_aus_formular', $agentur);
        if (strlen($logo_aus_formular)>0) {
            $logo['url'] = $logo_aus_formular;
            $logo['sizes']['jobs-thumb'] = $logo_aus_formular;
        }
        $kontakt_email = get_field('kontakt_e-mail', $agentur);
        $homepage = get_field('homepage', $agentur);
        $dienstleistungen = get_field('dienstleistungen', $agentur); //dienstleistung
        $location = get_field('adresse', $agentur);
        $premiumagentur = get_field('premiumagentur', $agentur);
        $strasse_und_hausnummer = get_field('strasse_und_hausnummer', $agentur);
        $plz_und_ort = get_field('plz_und_ort', $agentur);
        ?>
        <div class="webinar-teaser card agentur-info clearfix <?php if (1 == $premiumagentur) { print "vip"; }?>">
            <div class="webinar-teaser-img">
                <img class="teaser-img" alt="<?php print $name;?>" title="<?php print $name;?>" src="<?php print $logo['url'];?>"/>
            </div>
            <div class="webinar-teaser-text">
                <h3><a href="<?php print get_the_permalink($agentur);?>"><?php print $name;?></a></h3>
                <?php if ( 1 == $premiumagentur ) {?><span class="agentur-email"><?php print $kontakt_email;?></span><?php } ?>
                <div class="agentur-adresse">
                    <br/>
                    <p><?php print $strasse_und_hausnummer;?></p>
                    <p><?php print $plz_und_ort;?></p>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php } ?>