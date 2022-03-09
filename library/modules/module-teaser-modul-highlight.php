<?php foreach($zeile['inhaltstyp'][0]['teaser'] as $teaser) { ?>
    <div class="teaser-modul-highlight">
        <img
                class="teaser-img"
                width="550"
                height="290"
                srcset="
            <?php print $teaser['teaser_bild']['sizes']['350-180'];?> 480w,
            <?php print $teaser['teaser_bild']['sizes']['550-290'];?> 800w,
            <?php print $teaser['teaser_bild']['url'];?> 1400w"
                sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
             src="<?php print $teaser['teaser_bild']['url'];?>"
                alt="<?php print $teaser['teaser_bild']['alt'];?>"
                title="<?php print $teaser['teaser_bild']['alt'];?>"
        />
        <div class="textarea">
            <h4>
                <?php if (strlen($teaser['teaser_link'])>0) { ?><a href="<?php print $teaser['teaser_link'];?>"> <?php } ?>
                    <?php print $teaser['teaser_titel'];?>
                    <?php if (strlen($teaser['teaser_link'])>0) { ?></a><?php } ?>
            </h4>
            <?php if (strlen($teaser['teaser_highlight_text'])>0) { ?><p class="text-highlight"><?php print $teaser['teaser_highlight_text'];?></p> <?php } ?>
            <?php print $teaser['teaser_text'];?>
            <?php if (strlen($teaser['teaser_buttontext'])>0) { ?><a class="button" href="<?php print $teaser['teaser_link'];?>"><?php print $teaser['teaser_buttontext'];?></a> <?php } ?>
        </div>
    </div>
<?php } ?>
