<?php
require_once ( get_template_directory() . '/library/functions/function-seminare.php');
require_once ( get_template_directory() . '/library/functions/json-seminare/json-seminare-alle.php');?>
<?php
$author = $zeile['inhaltstyp'][0]['autor'];
$anzahl = $zeile['inhaltstyp'][0]['anzahl_angezeigter_seminare'];
$kategorie = $zeile['inhaltstyp'][0]['kategorie'];
$headline = $zeile['inhaltstyp'][0]['headline'];
$intro = $zeile['inhaltstyp'][0]['intro'];
if (strlen($headline)>0) { print "<h2>" . $headline . "</h2>"; }
if (strlen($intro)>0) { print $intro; }
display_seminare_json($anzahl, $kategorie, $author, 'large', false);
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$button_link = $zeile['inhaltstyp'][0]['button_link'];
if (strlen($button_text)>0) { ?>
    <a class="button after-grid" href="<?php print $button_link;?>"><?php print $button_text;?></a>
<?php }?>