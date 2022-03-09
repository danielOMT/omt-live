<?php

use OMT\Services\ArraySort;

function vb_sort_tools() {
    /*  if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'toolindexjamz' ) ) {
          var_dump($_SESSION);
          foreach (getallheaders() as $name => $value) {
              echo "$name: $value\n";
          }
          die('Permission denied');
      }*/
    /**
     * Default response
     */
    $response = [
        'status'  => 500,
        'message' => 'Something is wrong, please try again later ...',
        'content' => false,
        'found'   => 0
    ];
    /**
     * Setup query
     */
    $sort_option = $_POST['sort_option'];
    $filter_price = $_POST['filter_price'];
    $filter_testbericht = $_POST['filter_testbericht'];
    $pageid = $_POST['pageid'];
    $tabelle_kategorie = $_POST['indextype'];
    $index_taxonomy = $_POST['index_taxonomy'];

    $kategorie = $tabelle_kategorie;
    $tax_query[] =  array(
        'taxonomy' => 'tooltyp',
        'field' => 'id',
        'terms' => $kategorie
    );
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
            $filter_preis_arr = get_field('filter_preis', $ID);
            $filter_testbericht_arr = get_field('filter_testbericht', $ID);
            if (1 == $filter_testbericht_arr) {
                $filter_testbericht_arr = 1;
            } else {
                $filter_testbericht_arr = 0;
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
                '$filter_preis' => $filter_preis_arr,
                '$filter_testbericht' => $filter_testbericht_arr,
                '$terms' => $terms,
                '$category_name' => $category_name,
                '$category_slug' => $category_slug
            );

            ////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
//FILTER THE TOOLS ACCORDING TO SELECTION!
////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
            switch ($filter_price) {
                case "preis-alle":
                    break;
                case "preis-kostenlos":
                    $filter = 0;
                    foreach ($filter_preis_arr as $preisfilter) {
                        if ("kostenlos" == $preisfilter) {
                            $filter = 1;
                        }
                    }
                    break;
                case "preis-nicht-kostenlos":
                    $filter = 0;
                    foreach ($filter_preis_arr as $preisfilter) {
                        if ("nicht-kostenlos" == $preisfilter) {
                            $filter = 1;
                        }
                    }
                    break;
                case "preis-trial":
                    $filter = 0;
                    foreach ($filter_preis_arr as $preisfilter) {
                        if ("trial" == $preisfilter) {
                            $filter = 1;
                        }
                    }
                    break;
                case "preis-testversion":
                    $filter = 0;
                    foreach ($filter_preis_arr as $preisfilter) {
                        if ("testversion" == $preisfilter) {
                            $filter = 1;
                        }
                    }
                    break;
            }
            $testfilter = 0;
            if ( ("mit-testbericht" == $filter_testbericht) AND (1 != $filter_testbericht_arr) ) {
                $testfilter = 1;
            }

            if (1 == $testfilter AND 1 == $filter) {
                array_push($json, $tool_data);
            }
        }
    endwhile;



/////////////*********************DECIDE WHAT TO DO WITH THE TABLE BEFORE CREATING THE OUTPUT*************////////////////
    /////**************NEW DATAQUERY MIT KATEGORIEN VS TABELLEN************///////////

    $j=0;
    if ("kategorie" == $tabelle_kategorie) {
        $kategorie = $index_taxonomy;
        foreach ($json as $jsontool) { //remove all non-selected IDs from the JSON
            $is_term = 0;
            if (is_array($jsontool['$terms'])) {
                foreach ($jsontool['$terms'] as $term) {
                    if ($kategorie == $term->term_id) {
                        $kategorie_name = $term->name;
                        $is_term = 1;
                        if (in_array("testversion", $jsontool['$filter_preis'])) {
                            $testversion = 1;
                        }
                        if (in_array("trial", $jsontool['$filter_preis'])) {
                            $trial = 1;
                        }
                        if (in_array("kostenlos", $jsontool['$filter_preis'])) {
                            $kostenlos = 1;
                        }
                        if (in_array("nicht-kostenlos", $jsontool['$filter_preis'])) {
                            $nicht_kostenlos = 1;
                        }
                    }
                }
            }
            if (1 != $is_term) {
                unset ($json[$j]);
            } else {
                $k = 0;
                $json[$j]['initialsort'] = $k;
                $k++;
                if (is_array($jsontool['$club_stimmenanzahl_nach_kategorien'])) {
                    foreach ($jsontool['$club_stimmenanzahl_nach_kategorien'] as $clubkat) {
                        if ($kategorie == $clubkat['kategorie']) {
                            $json[$j]['$clubstimmen'] = $clubkat['anzahl_clubstimmen'];
                        }
                    }
                }
                if (is_array($jsontool['$tool_kategorien'])) {
                    $json[$j]['$wert'] = 0;
                    foreach ($jsontool['$tool_kategorien'] as $bidcat) {
                        if ($kategorie == $bidcat['kategorie']) {
                            $json[$j]['$wert'] = $bidcat['gebot'];
                        }
                    }
                }
            }
            $j++;
        }
    }




    switch ($sort_option) {
        /////////////SORT THE TABLE BY NUMBER OF REVIEWS:
        case "meiste":
            function sort_reviews_number($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
            {
                $t1 = $b['$anzahl_bewertungen'];
                $t2 = $a['$anzahl_bewertungen'];
                return $t1 - $t2;
            } ///*******end of helper function
            usort($json, 'sort_reviews_number'); //***sorting the array by initialsort*******/
            break;

        /////////////SORT THE TABLE BY RATING OF REVIEWS:
        case "beste":
            function sort_reviews_best($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
            {
                $t1 = 10*$b['$wertung_gesamt'];
                $t2 = 10*$a['$wertung_gesamt'];
                return $t1 - $t2;
            } ///*******end of helper function
            usort($json, 'sort_reviews_best'); //***sorting the array by initialsort*******/
            break;

        /////////////SORT THE TABLE BY TITLE:
        case "alphabetisch":
            function sort_title($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
            {
                return strcmp(strtolower ($a['$tool_vorschautitel']), strtolower ($b['$tool_vorschautitel']));
            } ///*******end of helper function
            usort($json, 'sort_title'); //***sorting the array by initialsort*******/
            break;

        /////////////SORT THE TABLE BY WERT / Sponsored:
        case "sponsored":
            ArraySort::toolsBySponsored($json);
            break;

        /////////////SORT THE TABLE BY RATING OF CLUBMEMBERS:
        case "clubstimmen":
            function sort_clubrating($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
            {
                $t1 = $b['$clubstimmen'];
                $t2 = $a['$clubstimmen'];
                return $t1 - $t2;
            } ///*******end of helper function
            usort($json, 'sort_clubrating'); //***sorting the array by initialsort*******/
            break;
    }
    /////////////*********************DECIDE WHAT TO DO WITH THE TABLE BEFORE CREATING THE OUTPUT*************////////////////

    ob_start();

    if (count($json)>0) :
        $j = 0;
        
        foreach ($json as $tool) {
            //   include('ajax-tools-item.php');
            include( get_template_directory() . '/library/modules/module-toolindex-part-tools-item.php');
        }

        $response = [
            'status'=> 200,
        ];

    else :
        $response = [
            'status'  => 201,
            'message' => 'Leider keine tools gefunden.'
        ];
    endif;
    $response['content'] = ob_get_clean();
    die(json_encode($response));

}
add_action('wp_ajax_do_sort_tools', 'vb_sort_tools');
add_action('wp_ajax_nopriv_do_sort_tools', 'vb_sort_tools');