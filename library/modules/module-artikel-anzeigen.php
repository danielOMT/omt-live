<?php
require_once ( get_template_directory() . '/library/functions/function-magazin.php');
        require_once ( get_template_directory() . '/library/functions/json-magazin/json-magazin-alle.php');
        $author = $zeile['inhaltstyp'][0]['autor'];
        $anzahl = $zeile['inhaltstyp'][0]['anzahl_angezeigter_artikel'];
        $kategorien = $zeile['inhaltstyp'][0]['kategorie'];
        $headline = $zeile['inhaltstyp'][0]['headline'];
        $ab_x = $zeile['inhaltstyp'][0]['ab_x'];
        $format = $zeile['inhaltstyp'][0]['format'];
        $mehr_laden_button_anzeigen = $zeile['inhaltstyp'][0]['mehr_laden_button_anzeigen'];
        $featured = $zeile['inhaltstyp'][0]['non_featured'];
        $new_tab = $zeile['inhaltstyp'][0]['new_tab'];

        if (1 == $featured) { $featured = false; } else { $featured = true; }
        if (1 == $new_tab) { $new_tab = true; } else { $new_tab = false; }
        if (1 == $mehr_laden_button_anzeigen) { $mehr_laden_button_anzeigen = TRUE;} else { $mehr_laden_button_anzeigen = FALSE; }

        if (is_array($kategorien)) {
            if (count($kategorien)<2) {
                $kategorie = $kategorien[0];
            }
        } else {
            if (strlen($kategorie) < 2) {
                $kategorie = $kategorien;
            }
        }
        if (is_array($kategorien)) {
            if (count($kategorien) > 1) {
                $kategorie = "";
                foreach ($kategorien as $item) {
                    $kategorie .= $item . "|";
                }
            }
        }
        if ((!isset($ab_x)) OR ($ab_x<1)) { $ab_x = 1; }
        if (strlen($headline)>0) { print "<h2>" . $headline . "</h2>"; }
        display_magazinartikel_json($anzahl, $kategorie, $author, false, $ab_x, $format, false, "", $mehr_laden_button_anzeigen, $featured, $new_tab);
        $button_text = $zeile['inhaltstyp'][0]['button_text'];
        $button_link = $zeile['inhaltstyp'][0]['button_link'];
        if (strlen($button_text)>0) { ?>
            <a class="button after-grid" href="<?php print $button_link;?>"><?php print $button_text;?></a>
        <?php } ?>