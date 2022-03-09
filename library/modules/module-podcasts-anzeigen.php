<?php
require_once ( get_template_directory() . '/library/functions/function-podcasts.php');
        require_once ( get_template_directory() . '/library/functions/json-podcasts/json-podcasts-alle.php');
        $author = $zeile['inhaltstyp'][0]['autor'];
        $anzahl = $zeile['inhaltstyp'][0]['anzahl_angezeigter_podinare'];
        $kategorien = $zeile['inhaltstyp'][0]['kategorie'];
        $speakerprofil = $zeile['inhaltstyp'][0]['speakerprofil_einbinden'];
        $speakerid = $speakerprofil->ID;
        $mehr_laden_button_anzeigen = $zeile['inhaltstyp'][0]['mehr_laden_button_anzeigen'];
        $teaser_small = $zeile['inhaltstyp'][0]['teaser_small'];
$new_tab = $zeile['inhaltstyp'][0]['new_tab'];
if (1 == $new_tab) { $new_tab = true; } else { $new_tab = false; }
if (1 == $teaser_small) { $teaser_small = true; } else { $teaser_small = false; }

        if ($speakerid<1) {$speakerid = NULL;};
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
        display_podcasts_json($anzahl, $kategorie, $author, false, $speakerid, "", $mehr_laden_button_anzeigen, $new_tab, $teaser_small);
        $button_text = $zeile['inhaltstyp'][0]['button_text'];
        $button_link = $zeile['inhaltstyp'][0]['button_link'];

        if (strlen($button_text)>0) { ?>
            <a class="button after-grid" href="<?php print $button_link;?>"><?php print $button_text;?></a>
        <?php } ?>