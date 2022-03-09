<?php
require_once ( get_template_directory() . '/library/functions/function-trends-anzeigen.php');
$headline = $zeile['inhaltstyp'][0]['headline'];
$intro = $zeile['inhaltstyp'][0]['introtext'];
if (strlen($headline)>0) { print "<h2>" . $headline . "</h2>"; }
if (strlen($intro)>0) { print $intro; }
$auswahl = $zeile['inhaltstyp'][0]['trends_auswahlen'];
trends_anzeigen($auswahl);
?>
