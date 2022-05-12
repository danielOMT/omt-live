<?php
$content1 = $zeile['inhaltstyp'][0]['inhaltseditor_1'];
$content2 = $zeile['inhaltstyp'][0]['inhaltseditor_2'];
$content3 = $zeile['inhaltstyp'][0]['inhaltseditor_3'];
$currentyear = date("Y");
$content1 = str_replace("%%currentyear%%", $currentyear, $content1);
$content2 = str_replace("%%currentyear%%", $currentyear, $content2);
$content3 = str_replace("%%currentyear%%", $currentyear, $content3);
?>
<div class="teaser-small"><?php print $content1;?></div>
<div class="teaser-small"><?php print $content2;?></div>
<div class="teaser-small"><?php print $content3;?></div>
