<?php
require_once ( get_template_directory() . '/library/functions/function-vortrage_anzeigen.php');?>
<?php
$jahr = $zeile['inhaltstyp'][0]['jahr_auswahlen'];
display_vortraege($jahr);