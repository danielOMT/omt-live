<?php

use OMT\Model\Tool;
use OMT\Services\ArraySort;

function vb_sort_tools() {
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
    $url = get_template_directory() . '/library/json/tools.json';
    $content_json = file_get_contents($url);    
    $json = json_decode($content_json, true);
    /////////////*********************DECIDE WHAT TO DO WITH THE TABLE BEFORE CREATING THE OUTPUT*************////////////////
    /////**************NEW DATAQUERY MIT KATEGORIEN VS TABELLEN************///////////

    $j=0;
    if ("tabelle" == $tabelle_kategorie) {
        $tabellenID = $_POST['tabellenid'];
        $tools_auswahlen = get_field('tools_auswahlen', $tabellenID);
        $tool_ids = array();
        $i = 0;

        foreach ($tools_auswahlen as $tool) { ///create array with IDs from the selected tools
            $ID = $tool['tool']->ID;
            $tool_ids[$i] = $ID;
            $i++;
        }

        foreach ($json as $tabellentool) { //remove all non-selected IDs from the JSON
            if (!in_array($tabellentool['ID'], $tool_ids)) {
                unset ($json[$j]);
            } else {
                include ('ajax-toolfilter.php');
            }
            $j++;
        }
    }

    if ("kategorie" == $tabelle_kategorie) {
        $toolModel = Tool::init();
        $kategorie = $index_taxonomy;
        $term = get_term( $kategorie, 'tooltyp' );
        $slug = $term->slug;

        foreach ($json as $jsontool) { //remove all non-selected IDs from the JSON
            $is_term = 0;
            if (has_term($slug, 'tooltyp', $jsontool['ID'])) {
                $is_term = 1;
            }

            if (1 != $is_term) {
                unset($json[$j]);
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
                    $json[$j]['$wert'] = $toolModel->worth(
                        (bool) $jsontool['$buttons_anzeigen'],
                        $jsontool['$guthaben'],
                        $jsontool['$tool_kategorien'],
                        $kategorie
                    );
                }

                include ('ajax-toolfilter.php');
            }

            $j++;
        }
    }
    /////**************NEW DATAQUERY MIT KATEGORIEN VS TABELLEN************///////////

    switch ($sort_option) {
        /////////////SORT THE TABLE BY NUMBER OF REVIEWS:
        case "meiste":
            function sort_reviews_number($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
            {
                $t1 = $b['$anzahl_bewertungen'];
                $t2 = $a['$anzahl_bewertungen'];
                return $t1 - $t2;
            }
            usort($json, 'sort_reviews_number');
            break;

        /////////////SORT THE TABLE BY RATING OF REVIEWS:
        case "beste":
            function sort_reviews_best($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
            {
                $t1 = 10*$b['$wertung_gesamt'];
                $t2 = 10*$a['$wertung_gesamt'];
                return $t1 - $t2;
            }
            usort($json, 'sort_reviews_best');
            break;

        /////////////SORT THE TABLE BY TITLE:
        case "alphabetisch":
            function sort_title($a, $b) ////***helper function to sort the array by $timestamp field from array ****/
            {
                return strcmp(strtolower ($a['$tool_vorschautitel']), strtolower ($b['$tool_vorschautitel']));
            }
            usort($json, 'sort_title');
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
            }
            usort($json, 'sort_clubrating');
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