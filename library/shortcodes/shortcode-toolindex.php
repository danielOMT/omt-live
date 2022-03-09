<?php

function toolindex ( $atts )
{
    $atts = shortcode_atts(array(
        'filter' => '0',
        'sortierfunktion' => '1',
        'indextyp' => 'kategorie',
        'kategorie' => '332',
        'tabelle' => '0'
    ), $atts);

    ob_start();
    $mit_filter = $atts['filter'];
    $mit_sortierfunktion = $atts['sortierfunktion'];
    $tabelle_kategorie = $atts['indextyp'];
    if ("tabelle" == $tabelle_kategorie) {
        $tools_auswahlen = get_field('tools_auswahlen', $atts['tabelle']);
    }
    if ("kategorie" == $tabelle_kategorie) {
        $kategorie = $atts['kategorie'];
        $tax_query[] =  array(
            'taxonomy' => 'tooltyp',
            'field' => 'id',
            'terms' => $kategorie
        );
    }
    ?>

    <section class="omt-row wrap toolindex-row-wrap  template-themenwelt layout-730 color-area-kein ">
        <div class="omt-module toolindex-column-wrap toolindex-shortcode-wrap">
            <?php
            $args = array( //next seminare 1st
                'posts_per_page'    => -1,
                'posts_status'      => "publish",
                'post_type'         => 'tool',
                'order'             => 'DESC',
                'orderby'           => 'date',
                'tax_query'         => $tax_query,

            );
            $webcount = 0;
            $json = array();
            $loop = new WP_Query($args);
            while ($loop->have_posts()) : $loop->the_post();
                $ID = get_the_ID();
                if (((get_post_status() != 'draft') AND ($ID != 191511))/* AND (get_post_status() != "private")*/) {
                    if (get_post_status() != "private") {
                        $post_status = "publish";
                    } else {
                        $post_status = "private";
                    }

                    $title = get_the_title();
                    $link = get_the_permalink();
                    $wert = get_field("wert");
                    $clubstimmen = get_field("club_stimmenanzahl");
                    $club_stimmenanzahl_nach_kategorien = get_field("club_stimmenanzahl_nach_kategorien");
                    $logo = get_field("logo");
                    // $square_100 = $logo['sizes']['square-100x100'];
                    $logo_350 = $logo['sizes']['350-180'];
                    $logo_550 = $logo['sizes']['550-290'];
                    $toolanbieter = get_field("toolanbieter");
                    $zur_webseite = get_field("zur_webseite");
                    $tool_details = get_field('tool_details');
                    $tool_details_by_categories = get_field('tool_details_by_categories');
                    $tool_preisubersicht = get_field("tool_preisubersicht");
                    $tool_gratis_testen_link = get_field("tool_gratis_testen_link");
                    $tool_vorschautitel = get_field("vorschautitel_fur_index");
                    $tool_vorschautext = get_field("vorschautext");
                    $vorschautext_nach_kategorie = get_field("vorschautext_nach_kategorie");
                    $tool_kategorien = get_field('tool_kategorien');
                    $anzahl_bewertungen = get_field('anzahl_bewertungen', $ID);
                    $buttons_anzeigen = get_field('buttons_anzeigen', $ID);
                    $filter_preis = get_field('filter_preis', $ID);
                    $filter_testbericht = get_field('filter_testbericht', $ID);
                    if (1 == $filter_testbericht) {
                        $filter_testbericht = 1;
                    } else {
                        $filter_testbericht = 0;
                    }
                    if (strlen($tool_vorschautitel) < 1) {
                        $tool_vorschautitel = $title;
                    }
                    if (strlen($tool_vorschautitel) > 60) {
                        $tool_vorschautitel = substr($tool_vorschautitel, 0, 60) . "...";
                    };
                    $wertung_gesamt = get_field("gesamt");
                    $wertung_benutzerfreundlichkeit = get_field("benutzerfreundlichkeit");
                    $wertung_kundenservice = get_field("kundenservice");
                    $wertung_funktionen = get_field("funktionen");
                    $wertung_preis_leistungs_verhaltnis = get_field("preis-leistungs-verhaltnis");
                    $wertung_wahrscheinlichkeit_weiterempfehlung = get_field("wahrscheinlichkeit_weiterempfehlung");

                    if (!isset($wert)) {
                        $wert = 0;
                    }
                    if (!isset($clubstimmen)) {
                        $clubstimmen = 0;
                    }
                    if (!isset($anzahl_bewertungen)) {
                        $anzahl_bewertungen = 0;
                    }
                    if (!isset($wertung_gesamt)) {
                        $wertung_gesamt = 0;
                    }
                    if (!isset($wertung_benutzerfreundlichkeit)) {
                        $wertung_benutzerfreundlichkeit = 0;
                    }
                    if (!isset($wertung_kundenservice)) {
                        $wertung_kundenservice = 0;
                    }
                    if (!isset($wertung_funktionen)) {
                        $wertung_funktionen = 0;
                    }
                    if (!isset($wertung_preis_leistungs_verhaltnis)) {
                        $wertung_preis_leistungs_verhaltnis = 0;
                    }
                    if (!isset($wertung_wahrscheinlichkeit_weiterempfehlung)) {
                        $wertung_wahrscheinlichkeit_weiterempfehlung = 0;
                    }
                    if (!isset($filter_preis)) {
                        $filter_preis = "kostenlos";
                    }
                    if (!is_array($filter_preis)) {
                        $filter_preis = array($filter_preis);
                    }

                    $webcount++;
                    $terms = get_the_terms(get_the_ID(), 'tooltyp');
                    $category_name = $terms[0]->name;
                    $category_slug = $terms[0]->slug;
                    ?>
                    <?php
                    $tool_data = array(
                        'number' => $webcount,
                        'ID' => $ID,
                        '$post_status' => $post_status,
                        '$title' => $title,
                        '$link' => $link,
                        '$logo' => $logo['url'],
                        '$logo_350' => $logo_350,
                        '$logo_550' => $logo_550,
                        '$tool_vorschautitel' => $tool_vorschautitel,
                        '$tool_vorschautext' => $tool_vorschautext,
                        '$vorschautext_nach_kategorie' => $vorschautext_nach_kategorie,
                        '$tool_kategorien' => $tool_kategorien,
                        '$toolanbieter' => $toolanbieter,
                        '$zur_webseite' => $zur_webseite,
                        '$tool_preisubersicht' => $tool_preisubersicht,
                        '$tool_gratis_testen_link' => $tool_gratis_testen_link,
                        '$buttons_anzeigen' => $buttons_anzeigen,
                        '$wert' => $wert,
                        '$clubstimmen' => $clubstimmen,
                        '$club_stimmenanzahl_nach_kategorien' => $club_stimmenanzahl_nach_kategorien,
                        '$anzahl_bewertungen' => $anzahl_bewertungen,
                        '$wertung_gesamt' => $wertung_gesamt,
                        '$wertung_benutzerfreundlichkeit' => $wertung_benutzerfreundlichkeit,
                        '$wertung_kundenservice' => $wertung_kundenservice,
                        '$wertung_funktionen' => $wertung_funktionen,
                        '$wertung_preis_leistungs_verhaltnis' => $wertung_preis_leistungs_verhaltnis,
                        '$wertung_wahrscheinlichkeit_weiterempfehlung' => $wertung_wahrscheinlichkeit_weiterempfehlung,
                        '$tool_details' => $tool_details,
                        '$tool_details_by_categories' => $tool_details_by_categories,
                        '$filter_preis' => $filter_preis,
                        '$filter_testbericht' => $filter_testbericht,
                        '$terms' => $terms,
                        '$category_name' => $category_name,
                        '$category_slug' => $category_slug
                    );
                    array_push($json, $tool_data);
                }
            endwhile;
            wp_reset_postdata();
              include( get_template_directory() . '/library/modules/module-toolindex-part-queries-wpdb.php');
              include( get_template_directory() . '/library/modules/module-toolindex-part-wrap.php');
            ?>
        </div>
    </section>
    <?php //*****END OF NEW WEBINAR TEASER STRUCTURE///*****////?>
    <?php $result = ob_get_clean();
    return $result;
}
add_shortcode( 'toolindex', 'toolindex' );

?>