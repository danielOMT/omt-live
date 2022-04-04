<?php

use OMT\Model\Tool;
use OMT\Services\ArraySort;

$j=0;
if ("tabelle" == $tabelle_kategorie) {
    $tool_ids = array();
    $i = 0;

    foreach ($tools_auswahlen as $tool) { ///create array with IDs from the selected tools
        $ID = $tool['tool']->ID;
        $tool_ids[$i] = $ID;
        $i++;
    }

    foreach ($json as $jsontool) { //remove all non-selected IDs from the JSON
        if (!in_array($jsontool['ID'], $tool_ids)) {
            unset ($json[$j]);
        } else {
            $k = 0;
            foreach ($tool_ids as $id) {
                if ($id == $jsontool['ID']) {
                    $json[$j]['initialsort'] = $k;
                }
                $k++;
            }
        }

        $j++;
    }
}
$kostenlos = 0;
$nicht_kostenlos = 0;
$testversion = 0;
$trial = 0;
if ("kategorie" == $tabelle_kategorie) {
    $toolModel = Tool::init();
    
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
        }

        $j++;
    }
}

ArraySort::toolsBySponsored($json);

//NOW WE HAVE REDUCED THE COMPLETE $JSON DATA TO JUST THE SELECTED TABLE IDs AND SORTED IT BY INITIAL SELECTION!
?>