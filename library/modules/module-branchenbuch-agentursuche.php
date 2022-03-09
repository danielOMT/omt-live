<?php
require_once ( get_template_directory() . '/library/functions/function-branchenbuch-suche.php');
$headline = $zeile['inhaltstyp'][0]['headline'];
$intro = $zeile['inhaltstyp'][0]['introtext']; if (strlen($headline)>0) { print "<h2 class='has-0-degrees'>" . $headline . "</h2>"; }
branchenbuch_suche(); ?>