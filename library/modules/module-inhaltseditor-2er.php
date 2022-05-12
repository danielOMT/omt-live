<?php
$content1 = $zeile['inhaltstyp'][0]['inhaltseditor_1'];
$content2 = $zeile['inhaltstyp'][0]['inhaltseditor_2'];
$currentyear = date("Y");
$content1 = str_replace("%%currentyear%%", $currentyear, $content1);
$content2 = str_replace("%%currentyear%%", $currentyear, $content2);

?>
<div class="teaser-medium"><?php print $content1;?></div>
<div class="teaser-medium"><?php print $content2;?></div>
