<?php
$einzugsgebiet_orte = $zeile['inhaltstyp'][0]['einzugsgebiet_orte'];
$kategorien = $zeile['inhaltstyp'][0]['kategorien'];
$agenturencount = 0;
$alphabetische_anzeige = $zeile['inhaltstyp'][0]['alphabetische_anzeige'];
if (1 == $alphabetische_anzeige) {
    $args = array( //next
        'posts_per_page'    => -1,
        'post_type'         => "agenturen",
        'posts_status'    => array('publish', 'private'),
        'meta_key'			=> 'agentur_rating_manuell',
        'orderby'			=> 'title',
        'order'				=> 'ASC'
        //'meta_query'		=> $meta_query,
        //'meta_key'	        => 'webinar_datum',
        //'meta_type'			=> 'DATETIME',
        //'tax_query'         => $tax_query,
    );
    ?>
    <div class="speakers-list container-small">
        <?php
        $current = "A";
        $count = 0;
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
        $first = strtoupper(substr(get_the_title(),0, 1));
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
<?php } else { //if agenturen regulär anzeigen instead of just alphabet list
    if (is_array($zeile['inhaltstyp'][0]['logos'])) {
        $agenturen_posts = $zeile['inhaltstyp'][0]['logos'];
    } else {
        if (in_array("alle", $kategorien)) {
            //$post_types = array('contentagentur', 'cmagentur', 'digitalagentur', 'gaagentur', 'internetagentur', 'omagentur', 'seaagentur', 'seoagentur', 'smagentur', 'webagentur', 'webanalyseagentur', 'webdesignagentur', 'wpagentur');
            $post_types = array('affiliateagentur', 'contentagentur', 'cmagentur', 'digitalagentur', 'gaagentur', 'internetagentur', 'linkbuildingagentur', 'omagentur', 'seaagentur', 'seoagentur', 'smagentur', 'webagentur', 'webanalyseagentur', 'webdesignagentur', 'wpagentur', 'videoerstellung');

        } else {
            $post_types = $kategorien;
        }
        $args = array( //next
            'posts_per_page' => -1,
            'post_type' => "agenturen",
            'posts_status' => array('publish', 'private'),
            'meta_key' => 'agentur_rating_manuell',
            'orderby' => 'meta_value',
            'order' => 'DESC'
            //'meta_query'		=> $meta_query,
            //'meta_key'	        => 'webinar_datum',
            //'meta_type'			=> 'DATETIME',
            //'tax_query'         => $tax_query,
        );
        $loop = new WP_Query($args);
        $agenturen_posts = array();
        while ($loop->have_posts()) : $loop->the_post();
            $branchen = get_field('branchen');
            $agentur_orte = get_field('einzugsgebiet_orte');

            foreach ($branchen as $branche) { //check if chosen branche is found in agentur
                foreach ($post_types as $type) {
                    if ($branche['value'] == $type) {
                        if (strlen($einzugsgebiet_orte[0]) < 1) { //Branche found! Now Orte have been selected
                            $agenturen_posts[] = get_the_ID(); //add to array if not!
                        } else { //check if we can find the chosen ort(e) in the agentur!
                            foreach ($einzugsgebiet_orte as $ort) { //go through all chosen orte
                                if (in_array($ort, $agentur_orte)) {  //if this single ort can be found in agentur array of orte, we have a match!
                                    $agenturen_posts[] = get_the_ID(); //add to array then
                                }
                            }
                        }
                    }
                }
            }
        endwhile;
        wp_reset_postdata();
        $agenturen_posts = array_unique($agenturen_posts);
    }

    if (1 == $zeile['inhaltstyp'][0]['nur_logos_anzeigen']) { //logos only
        foreach ($agenturen_posts as $partner) {
            if (is_array($partner)) {
                $logo = get_field('logo', $partner['agentur']->ID);
                $logo_attachment = get_field('logo_attachment', $partner['agentur']->ID);
                $permalink = get_the_permalink($partner['agentur']->ID);
            } else {
                $logo = get_field('logo', $partner);
                $logo_attachment = get_field('logo_attachment', $partner);
                $permalink = get_the_permalink($partner);
            }
            if (strlen($logo['url']) < 2) {
                $logo['url'] = $logo_attachment;
            }
            ?>
            <a class="teaser teaser-small teaser-xsmall partner-button partner-button-small"
               href="<?php print get_the_permalink($partner['agentur']->ID); ?>">
                <img class="partner-single" src="<?php print $logo['url']; ?>"
                     alt="<?php print $logo['alt']; ?>" title="<?php print $logo['alt']; ?>"/>
            </a>
        <?php } //end foreach partner
    } else { //full preview
        foreach ($agenturen_posts as $partner) {
            if (is_array($partner)) {
                $ID = $partner['agentur']->ID;
            } else {
                $ID = $partner;
            }
            $logo = get_field('logo', $ID);
            $logo_attachment = get_field('logo_attachment', $ID);
            $title = get_the_title($ID);
            $kompetenzen = get_field('branchen', $ID);
            $services = get_field('services', $ID);
            $anzahl_der_mitarbeiter = get_field('anzahl_der_mitarbeiter', $ID);
            $adresse_stadt = get_field('adresse_stadt', $ID);
            $omt_zertifiziert = get_field('omt_zertifiziert', $ID);
            $beschreibung = get_field('beschreibung', $ID);
            $vorschautext = get_field('vorschautext', $ID);
            $permalink = get_the_permalink($ID);
            /* } else {
                 $logo = get_field('logo', $partner);
                 $logo_attachment = get_field('logo_attachment', $partner);
                 $title = get_the_title($partner);
                 $kompetenzen = get_field('branchen', $partner);
                 $services = get_field('services', $partner);
                 $anzahl_der_mitarbeiter = get_field('anzahl_der_mitarbeiter', $partner);
                 $adresse_stadt = get_field('adresse_stadt', $partner);
                 $omt_zertifiziert = get_field('omt_zertifiziert', $partner);
                 $beschreibung = get_field('beschreibung', $partner);
                 $permalink = get_the_permalink($partner);
             }*/
            if (strlen($logo['url']) < 1) {
                $logo['url'] = $logo_attachment;
            }
            ?>
            <div class="teaser teaser-small agentur-preview">
                <?php if (1 == $omt_zertifiziert) { ?>
                    <div class="ribbon"><span>Zertifiziert</span></div><?php } ?>
                <div class="logo-wrap">
                    <img class="agentur-logo" src="<?php print $logo['url']; ?>"
                         alt="<?php print $title; ?>" title="<?php print $title; ?>"/>
                </div>
                <h3><?php print $title; ?></h3>
                <div class="meta-wrap">
                    <?php print "Agentur in " . $adresse_stadt . " | ";
                    foreach ($services as $service) { ?>
                        <?php print $service['label'] . " | "; ?>
                    <?php } ?>
                    <?php print $anzahl_der_mitarbeiter . " Mitarbeiter"; ?>
                </div>
                <div class="kompetenzen">
                    <?php foreach ($kompetenzen as $kompetenz) { ?>
                        <div class="button button-grey kompetenz"><?php print $kompetenz['label']; ?></div>
                    <?php } ?>
                </div>
                <div style="align-self:flex-end;"><?php if (strlen($vorschautext) > 0) {
                        print $vorschautext . "...";
                    } else {
                        print showBeforeMore($beschreibung);
                    } ?></div>
                <a class="button button-blue" style="align-self:flex-end;"
                   href="<?php print $permalink; ?>">Zur Agentur</a>
            </div>
            <?php
            $agenturencount++;
        } //end foreach partner
    } // end else = volle previewanzeige
} // end else == agenturen eregulär zeigen, nicht alphabetische liste?>
<?php if (strlen($zeile['inhaltstyp'][0]['button_text'])>0) { ?>
    <?php if (strlen($zeile['inhaltstyp'][0]['button_link']) > 0) { ?>
        <p style="width:100%;text-align:center;display:flex;justify-content:center;"><a
                class="button button-blue button-350px"
                href="<?php print $zeile['inhaltstyp'][0]['button_link']; ?>"><?php print $zeile['inhaltstyp'][0]['button_text']; ?></a><br/>
        </p>
    <?php } else { ?>
        <div class="contact-modal" style="width:100%;text-align:center;display:flex;justify-content:center;"><a
                class="agentursuche-button button button-red"
                href="#kontakt"><?php print $zeile['inhaltstyp'][0]['button_text']; ?></a></div>
    <?php }
}
if (strlen ($zeile['inhaltstyp'][0]['sekundarlink_text'])>0) { ?>
    <a class="secondary" href="<?php print $zeile['inhaltstyp'][0]['sekundarlink_url'];?>"><?php print $zeile['inhaltstyp'][0]['sekundarlink_text'];?></a>
<?php }
if ($agenturencount<1 AND 1 != $alphabetische_anzeige) { ?><span class="hidethis"></span><?Php }
if ($agenturencount<1 AND 1 != $alphabetische_anzeige) { ?><span class="hidefull"></span><?Php }
?>