<?php
function branchenbuch_suche() { ?>
    <?php
    $args_agenturen = array(
        'posts_per_page'    => -1,
        'post_type'         => 'agentur',
        'orderby'	        => 'title',
        'order'             => 'ASC'
    );
    ?>
    <div class="twelvecol first omt-abschnitt branchenbuch-filter-wrap">
        <form class="branchenbuch-filter" action="" method="post">
            <h2>Finde eine Agentur in Deiner Nähe:</h2>
            <div class="teaser-modul">
                <?php //filter nach branche
                $args_branchen = array(
                    'posts_per_page'    => -1,
                    'post_type'         => 'branchenbuch',
                    'meta_key'		=> 'zuordnung_stadt_oder_branche',
                    'meta_value'	=> 'branche',
                    'orderby'	        => 'title',
                    'order'             => 'ASC'
                );
                $loop = new WP_Query( $args_branchen ); //*args and query all "?>
                <div class="teaser teaser-small">
                    <label>
                        <select id="branche" name="branche">
                            <option>Alle Branchen</option>
                            <?php while ( $loop->have_posts() ) { $loop->the_post(); ?>
                                <?php
                                $branchenbuch_name = get_the_title();
                                $branchenbuch_shortname = get_field('kurztitel_fur_die_suchfunktion');
                                $branchenbuch_id = get_the_id();
                                ?>
                                <option value="<?php print $branchenbuch_id;?>"><?php print $branchenbuch_shortname;?></option>
                            <?php };
                            wp_reset_postdata();?>
                        </select> <?php ///filter nach branche end ?>
                </div>
                </label>
                <div class="teaser teaser-small">
                    <?php //filter nach Ort
                    $args_ort = array(
                        'posts_per_page'    => -1,
                        'post_type'         => 'branchenbuch',
                        'meta_key'		=> 'zuordnung_stadt_oder_branche',
                        'meta_value'	=> 'stadt',
                        'orderby'	        => 'title',
                        'order'             => 'ASC'
                    );
                    $loop = new WP_Query( $args_ort ); //*args and query all "?>
                    <label><select id="ort" name="ort"><option>Alle Orte</option>
                            <?php while ( $loop->have_posts() ) { $loop->the_post(); ?>
                                <?php
                                $branchenbuch_name = get_the_title();
                                $branchenbuch_id = get_the_id();
                                $branchenbuch_shortname = get_field('kurztitel_fur_die_suchfunktion');
                                ?>
                                <option value="<?php print $branchenbuch_id;?>"><?php print $branchenbuch_shortname;?></option>
                            <?php };
                            wp_reset_postdata();?>
                        </select> <?php ///filter nach Ort end ?>
                    </label>
                </div>
                <div class="teaser teaser-small">
                    <input class="submit-bbsuche" type="submit" value="Agenturen durchsuchen">
                </div>
            </div>
        </form>
        <?php
        if ( ! empty( $_POST ) ) {
            $agenturen_branche = get_field('agenturen', $_POST['branche']);
            $agenturen_ort = get_field('agenturen', $_POST['ort']);
            $ergebnis_nonpremiumagenturen = array();
            $ergebnis_premiumagenturen = array();
            $b_premiumagenturen_array = array();
            $b_nonpremiumagenturen_array = array();
            $o_premiumagenturen_array = array();
            $o_nonpremiumagenturen_array = array();
            $loop = new WP_Query( $args_agenturen ); //*args and query all "*/
            if ($_POST['branche'] == "Alle Branchen") { ?>
                <?php while ($loop->have_posts()) {
                    $loop->the_post(); ?>
                    <?php
                    $premiumagentur = get_field('premiumagentur');
                    if (1 == $premiumagentur) {
                        $b_premiumagenturen_array[] = get_the_ID();
                    } else {
                        $b_nonpremiumagenturen_array[] = get_the_ID();
                    }
                    ?>
                <?php };
                wp_reset_postdata();
            }
            else {
                while ($loop->have_posts()) {
                    $loop->the_post();
                    $dienstleistungen = get_field('dienstleistungen');
                    $premiumagentur = get_field('premiumagentur');
                    foreach ($dienstleistungen as $leistung) {
                        if ($leistung['dienstleistung_branchenbuch']->ID == $_POST['branche']) {
                            if (1 == $premiumagentur) {
                                $b_premiumagenturen_array[] = get_the_ID();
                            } else {
                                $b_nonpremiumagenturen_array[] = get_the_ID();
                            }
                        }
                    }
                }
            }
            wp_reset_postdata();
            if ($_POST['ort'] == "Alle Orte") { ?>
                <?php while ($loop->have_posts()) {
                    $loop->the_post(); ?>
                    <?php
                    $premiumagentur = get_field('premiumagentur');
                    if (1 == $premiumagentur) {
                        $o_premiumagenturen_array[] = get_the_ID();
                    } else {
                        $o_nonpremiumagenturen_array[] = get_the_ID();
                    }
                    ?>
                <?php };
                wp_reset_postdata();
            }
            else {
                while ($loop->have_posts()) {
                    $loop->the_post();
                    $zuordnung_ortliches_branchenbuch = get_field('zuordnung_ortliches_branchenbuch');
                    $premiumagentur = get_field('premiumagentur');
                    if ($zuordnung_ortliches_branchenbuch->ID == $_POST['ort']) {
                        if (1 == $premiumagentur) {
                            $o_premiumagenturen_array[] = get_the_ID();
                        } else {
                            $o_nonpremiumagenturen_array[] = get_the_ID();
                        }
                    }
                }
            }
            wp_reset_postdata();
            foreach ($b_nonpremiumagenturen_array as $item) {
                if (in_array($item, $o_nonpremiumagenturen_array)) {
                    $ergebnis_nonpremiumagenturen[] = $item;
                    // print $item;
                }
            }
            foreach ($b_premiumagenturen_array as $item) {
                if (in_array($item, $o_premiumagenturen_array)) {
                    $ergebnis_premiumagenturen[] = $item;
                    // print $item;
                }
            }
            $agenturen_array = array();
            foreach ($ergebnis_premiumagenturen as $agentur) {
                $agenturen_array[] = $agentur;
            }
            foreach ($ergebnis_nonpremiumagenturen as $agentur) {
                $agenturen_array[] = $agentur;
            }
            ///***OUTPUT AGENTURSUCHE***///
            $input_ort = $_POST['ort'];
            $input_branche = $_POST['branche'];
            if ($_POST['ort'] != "Alle Orte") {$input_ort = get_the_title($_POST['ort']); }
            if ($_POST['branche'] != "Alle Branchen") {$input_branche = get_the_title($_POST['branche']); }
            if (count($agenturen_array)>=1) {
                ?><h3 class="filter-results">Ergebnisse für <?php print $input_branche;?> in <?php print $input_ort;?>:</h3><?php
                wp_enqueue_script('google-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDFmVEWDZOoE8GtOglBut7XSID-OSC6hK0', null, null, true); // Add in your key
                // ACF Google Map Single Map Output
                //$location = get_field('location'); // Set the ACF location field to a variable
                //wp_enqueue_script('acfmaps', get_stylesheet_directory_uri() . '/library/js/acf-maps.js', array('jquery'), '', true);
                ?>
                <div class="acf-map">
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
            <?php }
            else {?><h3 class="filter-results">Leider gibt es keine Ergebnisse für <?php print $input_branche;?> in <?php print $input_ort;?></h3><?php } ?>
        <?php } //**if !empty post end?>
    </div>
<?php } ?>