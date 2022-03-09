<?php
require_once ( get_template_directory() . '/library/functions/function-lexikon.php');
$anzahl = $zeile['inhaltstyp'][0]['anzahl_angezeigter_artikel'];
display_lexikon($anzahl);