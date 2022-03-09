<?php
$links_label = $zeile['inhaltstyp'][0]['button_links_label'];
$links_url = $zeile['inhaltstyp'][0]['button_links_link'];
$rechts_label = $zeile['inhaltstyp'][0]['button_rechts_label'];
$rechts_url = $zeile['inhaltstyp'][0]['button_rechts_link'];
?>
<a class="button introbutton introbutton-first" href="<?php print $links_url;?>"><?php print $links_label;?></a>
<a class="button introbutton introbutton-second" href="<?php print $rechts_url;?>"><?php print $rechts_label;?></a>

