<?php
require_once ( get_template_directory() . '/library/functions/function-branchenbuch-liste.php');
$headline = $zeile['inhaltstyp'][0]['headline'];
$intro = $zeile['inhaltstyp'][0]['introtext'];
$typ = $zeile['inhaltstyp'][0]['art'];
if (strlen($headline)>0) { print "<h2 class='has-0-degrees'>" . $headline . "</h2>"; }
branchenbuch_liste($typ);
?>