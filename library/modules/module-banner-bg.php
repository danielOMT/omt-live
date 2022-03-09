<?php
if (strlen($zeile['inhaltstyp'][0]['link'])>0) {
if ($zeile['inhaltstyp'][0]['link_target'] != false) { $target = "_blank"; } else { $target="_self"; } ?>
<a href="<?php print $zeile['inhaltstyp'][0]['link'];?>" target="<?php print $target;?>">
    <?php } ?>
    <?php print $zeile['inhaltstyp'][0]['text'];
    if (strlen($zeile['inhaltstyp'][0]['link'])>0) { ?>
</a>
<?php } ?>