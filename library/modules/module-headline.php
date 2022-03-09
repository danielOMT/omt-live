<?php if ($zeile['inhaltstyp'][0]['ausrichtung'] == "gerade") { $ausrichtung = "has-0-degrees"; } else { $ausrichtung = "has-5-degrees"; } ?>
<<?php print $zeile['inhaltstyp'][0]['headline_typ'];?> class="<?php print $ausrichtung;?>">
<?php print $zeile['inhaltstyp'][0]['headline'];?>
</<?php print $zeile['inhaltstyp'][0]['headline_typ'];?>>