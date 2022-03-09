<?php if (strlen($zeile['inhaltstyp'][0]['image']['url'])>0) { ?>
    <img
            width="550"
            height="290"
            srcset="
            <?php print $zeile['inhaltstyp'][0]['image']['sizes']['350-180'];?> 480w,
            <?php print $zeile['inhaltstyp'][0]['image']['sizes']['550-290'];?> 800w,
            <?php print $zeile['inhaltstyp'][0]['image']['sizes']['url'];?> 1400w"
            sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
            src="<?php print $zeile['inhaltstyp'][0]['image']['url']; ?>"
            alt="<?php print $zeile['inhaltstyp'][0]['image']['alt']; ?>"
            title="<?php print $zeile['inhaltstyp'][0]['image']['alt']; ?>"
    />
<?php } ?>
<?php if (strlen($zeile['inhaltstyp'][0]['headline']) >0) { ?><h3><?php print $zeile['inhaltstyp'][0]['headline']; ?></h3> <?php } ?>
<?php if (strlen($zeile['inhaltstyp'][0]['intro_text']) >0) { ?><?php print $zeile['inhaltstyp'][0]['intro_text']; ?> <?php } ?>
<?php if (strlen($zeile['inhaltstyp'][0]['text']) >0) { ?><?php print $zeile['inhaltstyp'][0]['text']; ?> <?php } ?>