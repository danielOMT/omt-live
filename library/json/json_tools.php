<?php

function json_tools()
{
    $webcount = 0;
    $arr_data = [];
    $shortarr_data = [];
    $loop = new WP_Query([
        'posts_per_page' => -1,
        'post_status' => ['publish', 'private'],
        'post_type' => 'tool',
        'order' => 'DESC',
        'orderby' => 'date'
    ]);

    while ($loop->have_posts()) {
        $loop->the_post();
        $ID = get_the_ID();

        if ($ID != 191511) {
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
            $name_ankerlink = get_field("name_ankerlink");
            $logo = get_field("logo");
            $logo_350 = $logo['sizes']['350-180'];
            $logo_550 = $logo['sizes']['550-290'];
            $toolanbieter = get_field("toolanbieter");
            $zur_webseite = get_field("zur_webseite");
            $tool_details = get_field('tool_details');
            $tool_details_by_categories = get_field('tool_details_by_categories');
            $guthaben = 0;
            $guthaben = get_field('guthaben');
            if (!isset($guthaben)) {
                $guthaben = 0;
            }
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
            }
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
                $filter_preis = [$filter_preis];
            }

            $webcount++;
            $terms = get_the_terms(get_the_ID(), 'tooltyp');
            $category_name = $terms[0]->name;
            $category_slug = $terms[0]->slug;

            if ($guthaben <= 0) {
                $wert = 0;
            }

            $tool_data = [
                'number' => $webcount,
                'ID' => $ID,
                '$post_status' => $post_status,
                '$title' => $title,
                '$link' => $link,
                '$name_ankerlink' => $name_ankerlink,
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
                '$wert' => intval($wert),
                '$guthaben' => intval($guthaben),
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
            ];
            array_push($arr_data, $tool_data);

            $shorttool_data = [
                'number' => $webcount,
                'ID' => $ID,
                '$title' => $title,
                '$link' => $link
            ];
            array_push($shortarr_data, $shorttool_data);
        }
    }

    $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $jsondata_short = json_encode($shortarr_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    //write json data into data.json file
    file_put_contents(ABSPATH . "wp-content/themes/omt/library/json/tools.json", $jsondata);
    file_put_contents(ABSPATH . "wp-content/themes/omt/library/json/shorttools.json", $jsondata_short);

    wp_reset_postdata();
}
