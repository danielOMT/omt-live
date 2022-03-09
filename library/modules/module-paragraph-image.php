<div class="teaser teaser-large">
    <?php if ($zeile['inhaltstyp'][0]['ausrichtung'] == "bild") { ?>
        <img
                class=""
                width="550"
                height="290"
                srcset="
            <?php print $zeile['inhaltstyp'][0]['bild']['sizes']['350-180'];?> 480w,
            <?php print $zeile['inhaltstyp'][0]['bild']['sizes']['550-290'];?> 800w,
            <?php print $zeile['inhaltstyp'][0]['bild']['sizes']['url'];?> 1400w"
                sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                src="<?php print $zeile['inhaltstyp'][0]['bild']['url'];?>"
                alt="<?php print $zeile['inhaltstyp'][0]['bild']['alt'];?>"
                title="<?php print $zeile['inhaltstyp'][0]['bild']['alt'];?>"
        />
    <?php } else { print $zeile['inhaltstyp'][0]['text']; } ?>
</div>
<div class="teaser teaser-large">
    <?php if ($zeile['inhaltstyp'][0]['ausrichtung'] == "text") { ?>
        <img
                class=""
                width="550"
                height="290"
                srcset="
            <?php print $zeile['inhaltstyp'][0]['bild']['sizes']['350-180'];?> 480w,
            <?php print $zeile['inhaltstyp'][0]['bild']['sizes']['550-290'];?> 800w,
            <?php print $zeile['inhaltstyp'][0]['bild']['sizes']['url'];?> 1400w"
                sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                src="<?php  print $zeile['inhaltstyp'][0]['bild']['url'];?>"
                alt="<?php print $zeile['inhaltstyp'][0]['bild']['alt'];?>"
                title="<?php print $zeile['inhaltstyp'][0]['bild']['alt'];?>"
        />
    <?php } else { print $zeile['inhaltstyp'][0]['text']; } ?>
</div>
