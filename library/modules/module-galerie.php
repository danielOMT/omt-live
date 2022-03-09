<?php foreach($zeile['inhaltstyp'][0]['galerie'] as $image) { ?>
    <div class="teaser teaser-small">
        <img
                class="galerie-image"
                width="550"
                height="290"
                srcset="
            <?php print $image['bild']['sizes']['350-180'];?> 480w,
            <?php print $image['bild']['sizes']['550-290'];?> 800w,
            <?php print $image['bild']['sizes']['url'];?> 1400w"
                sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                src="<?php print $image['bild']['url'];?>"
                alt="<?php print $image['bild']['alt'];?>"
                title="<?php print $image['bild']['alt'];?>"
        />
        <?php if (strlen($image['link'])>0) { ?><a href="<?php print $image['link'];?>"><?php } ?>
            <?php if (strlen($image['bild_untertitel'])>0) { print $image['bild_untertitel']; } ?>
            <?php if (strlen($image['link'])>0) { ?></a><?php } ?>
    </div>
<?php } ?>
