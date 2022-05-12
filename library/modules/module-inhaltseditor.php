<?php $inhalt =  $zeile['inhaltstyp'][0]['inhaltseditor_feld']; ?>
<?php
$currentyear = date("Y");
$inhalt = str_replace("%%currentyear%%", $currentyear, $inhalt); ?>
<?php print $inhalt;?>
