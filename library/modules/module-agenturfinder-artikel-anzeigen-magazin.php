<?php
require_once ( get_template_directory() . '/library/functions/function-magazin.php');?>
<?php
$author = $zeile['inhaltstyp'][0]['autor'];
$anzahl = $zeile['inhaltstyp'][0]['anzahl_angezeigter_artikel'];
$kategorien = $zeile['inhaltstyp'][0]['kategorie'];
$headline = $zeile['inhaltstyp'][0]['headline'];
$ab_x = $zeile['inhaltstyp'][0]['ab_x'];

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
display_magazinartikel($anzahl, $kategorie, $author, false, $ab_x, "teaser-small", true);
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$button_link = $zeile['inhaltstyp'][0]['button_link'];
if (strlen($button_text)>0) { ?>
    <a class="button after-grid" href="<?php print $button_link;?>"><?php print $button_text;?></a>
<?php } ?>