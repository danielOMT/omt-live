<?php if (strlen($zeile['inhaltstyp'][0]['hero_titel'])>0) { ?> <h2><?php print $zeile['inhaltstyp'][0]['hero_titel']; ?></h2> <?php } ?>
<?php if (strlen($zeile['inhaltstyp'][0]['hero_subtitel']) >0) { ?><h3><?php print $zeile['inhaltstyp'][0]['hero_subtitel']; ?></h3> <?php } ?>
<?php foreach($zeile['inhaltstyp'][0]['hero_images'] as $image) { ?>
    <?php if (strlen($image['link'])>0) { ?><a href="<?php print $image['link'];?>"><?php } ?>
    <img
            class="slider-image"
            width="550"
            height="290"
            srcset="
            <?php print $image['image']['sizes']['350-180'];?> 480w,
            <?php print $image['image']['sizes']['550-290'];?> 800w,
            <?php print $image['image']['sizes']['url'];?> 1400w"
            sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
            src="<?php print $image['image']['url'];?>"
            alt="<?php print $image['image']['alt'];?>"
            title="<?php print $image['image']['title'];?>"
    />
    <?php if (strlen($image['link'])>0) { ?></a><?php } ?>
<?php } ?>
