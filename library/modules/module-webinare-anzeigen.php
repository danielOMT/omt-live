<?php
require_once ( get_template_directory() . '/library/functions/function-webinare.php');
require_once ( get_template_directory() . '/library/functions/json-webinare/json-webinare-alle.php');
require_once ( get_template_directory() . '/library/functions/json-webinare/json-webinare-zukunft.php');
require_once ( get_template_directory() . '/library/functions/json-webinare/json-webinare-vergangenheit.php');
$author = $zeile['inhaltstyp'][0]['autor'];
$anzahl = $zeile['inhaltstyp'][0]['anzahl_angezeigter_webinare'];
$mehr_laden_button_anzeigen = $zeile['inhaltstyp'][0]['mehr_laden_button_anzeigen'];
if (1 == $mehr_laden_button_anzeigen) {$mehr_laden_button_anzeigen = TRUE; } else { $mehr_laden_button_anzeigen = FALSE; }
$status = $zeile['inhaltstyp'][0]['webinar_status'];
$highlight_next = $zeile['inhaltstyp'][0]['highlight_next'];
$reihenfolge = $zeile['inhaltstyp'][0]['reihenfolge'];
$kategorie = $zeile['inhaltstyp'][0]['kategorie'][0];
$kategorien = $zeile['inhaltstyp'][0]['kategorie'];
$new_tab = $zeile['inhaltstyp'][0]['new_tab'];
if (1 == $new_tab) { $new_tab = true; } else { $new_tab = false; }
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
$headline = $zeile['inhaltstyp'][0]['headline'];
$intro = $zeile['inhaltstyp'][0]['intro'];
if (strlen($headline)>0) { print "<h2>" . $headline . "</h2>"; }
if (strlen($intro)>0) { print $intro; }
if ("alle" == $status) { display_webinare_json_alle($anzahl, $reihenfolge, $kategorie, $author, $highlight_next, false, "", $mehr_laden_button_anzeigen, $new_tab); }
if ("vergangenheit" == $status) { display_webinare_json_vergangenheit($anzahl, $reihenfolge, $kategorie, $author, $highlight_next); }
if ("zukunft" == $status) {
    $futurewebinarecount = display_webinare_json_zukunft($anzahl, $reihenfolge, $kategorie, $author, $highlight_next, true);
    if ($futurewebinarecount>0) {
        display_webinare_json_zukunft($anzahl, $reihenfolge, $kategorie, $author, $highlight_next);
    } else {
        ?><div class="hidefull"></div>
    <?php }
}

$button_text = $zeile['inhaltstyp'][0]['button_text'];
$button_link = $zeile['inhaltstyp'][0]['button_link'];
if (strlen($button_text)>0) { ?>
    <a class="button after-grid" href="<?php print $button_link;?>"><?php print $button_text;?></a>
<?php } ?>