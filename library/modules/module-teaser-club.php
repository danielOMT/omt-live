<?php
$teaser_bild = $zeile['inhaltstyp'][0]['teaser_bild'];
$headline = $zeile['inhaltstyp'][0]['headline'];
$introtext_optional = $zeile['inhaltstyp'][0]['introtext_optional'];
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$button_link = $zeile['inhaltstyp'][0]['button_link'];

if (strlen($headline)>0) { ?><h2><?php print $headline;?></h2><?php } ?>
<img
        class="club-teaser-img"
        width="550"
        height="290"
        srcset="
            <?php print $teaser_bild['sizes']['350-180'];?> 480w,
            <?php print $teaser_bild['sizes']['550-290'];?> 800w,
            <?php print $teaser_bild['url'];?> 1400w"
        sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
        src="<?php print $teaser_bild['url'];?>"
        alt="<?php print $teaser_bild['alt'];?>"
        title="<?php print $teaser_bild['alt'];?>"/>
<div class="podcast-teaser-content">
    <?php print $introtext_optional;?>
</div>
