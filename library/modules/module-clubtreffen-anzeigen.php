<?php
$clubtreffen = get_field('clubtreffen', 'options');
foreach($clubtreffen as $teaser) { ?>
    <div class="teaser teaser-medium">

        <img
                width="550"
                height="290"
                class="teaser-img"
                srcset="
        <?php print $teaser['titelbild']['sizes']['350-180'];?> 480w,
        <?php print $teaser['titelbild']['sizes']['550-290'];?> 800w,
        <?php print $teaser['titelbild']['sizes']['550-290'];?> 1400w"
                sizes="
                (max-width: 768px) 480w,
                (min-width: 768px) and (max-width: 1399px) 800w,
                (min-width: 1400px) 1400w"
                src="<?php print $teaser['titelbild']['sizes']['550-290'];?>"
                alt="<?php print $teaser['titelbild']['alt'];?>"
                title="<?php print $teaser['titelbild']['alt'];?>"
        />
    </div>
    <div class="teaser teaser-medium">
        <h4 class="teaser-cat"><?php print $teaser['datum'];?></h4>
        <h4>
            <?php if (strlen($teaser['link'])>0) { ?><a target="<?php print $teaser['link'];?>" href="<?php print $teaser['link'];?>"> <?php } ?>
                <?php print $teaser['titel'];?>
                <?php if (strlen($teaser['link'])>0) { ?></a><?php } ?>
        </h4>
        <?php print $teaser['beschreibung'];?>
        <span class="club-more">Mehr lesen</span>
    </div>
    <?php if (strlen($teaser['button_text'])>0 AND strlen($teaser['link'])>0) { ?>
        <div style="width:100%;display:block;"><a target="_blank" class="teaser teaser-medium button" style="float:right;margin-bottom: 50px;position:relative;bottom:20px;" title="<?php print $teaser['button_text'];?>" href="<?php print $teaser['link'];?>"><?php print $teaser['button_text'];?></a></div>
    <?php } ?>
<?php } ?>
