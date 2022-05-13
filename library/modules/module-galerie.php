<?php foreach($zeile['inhaltstyp'][0]['galerie'] as $image) { ?>
    <div class="teaser teaser-small">
        <img
                class="galerie-image"
                width="350"
                height="180"
                src="<?php print $image['bild']['sizes']['350-180'];?>"
                alt="<?php print $image['bild']['alt'];?>"
                title="<?php print $image['bild']['alt'];?>"
        />
        <?php if (strlen($image['link'])>0) { ?><a href="<?php print $image['link'];?>"><?php } ?>
            <?php if (strlen($image['bild_untertitel'])>0) { print $image['bild_untertitel']; } ?>
            <?php if (strlen($image['link'])>0) { ?></a><?php } ?>
    </div>
<?php } ?>
