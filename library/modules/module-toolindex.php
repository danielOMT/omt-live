<?php
$mit_filter = $zeile['inhaltstyp'][0]['mit_filter'];
$mit_sortierfunktion = $zeile['inhaltstyp'][0]['mit_sortierfunktion'];
$tabelle_kategorie = $zeile['inhaltstyp'][0]['tabelle_kategorie'];

//if tabelle
if ("tabelle" == $tabelle_kategorie) {
    $tabelle_auswahlen = $zeile['inhaltstyp'][0]['tabelle_auswahlen'];
    $tabellenID = $tabelle_auswahlen->ID;
    $tools_auswahlen = get_field('tools_auswahlen', $tabellenID);
}
//if category
if ("kategorie" == $tabelle_kategorie) {
    $kategorie_object = $zeile['inhaltstyp'][0]['kategorie_auswahlen'];
    $kategorie = $kategorie_object->term_id;
}
?>
<?php include('module-toolindex-toolsfromdb.php');?>
<?php include( 'module-toolindex-part-queries-wpdb.php'); ?>
<?php //include('module-toolindex-part-queries.php');?>
<?php include('module-toolindex-part-wrap.php'); ?>