<?php
$headline = $zeile['inhaltstyp'][0]['headline'];
$introtext_optional = $zeile['inhaltstyp'][0]['introtext_optional'];
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$button_link = $zeile['inhaltstyp'][0]['button_link'];

if (strlen($headline)>0) { ?><h2><?php print $headline;?></h2><?php } ?>
<div class="podcast-teaser-content">
    <?php print $introtext_optional;?>
    <div class="omt-suche"><form role="search" method="get" id="searchform" action="https://www.omt.de/"> <input type="text" class="searchphrase" value="" name="s" id="s" placeholder="Finde die Inhalte beim OMT..." id=""/><input type="submit" id="searchsubmit" value="Los"></form></div>
</div>
