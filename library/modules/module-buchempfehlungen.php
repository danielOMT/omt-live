<?php
foreach($zeile['inhaltstyp'][0]['buchempfehlungen'] as $buchempfehlung) { ?>
    <img class="teaser-img img-20" src="<?php print $buchempfehlung['bild']['url'];?>" alt="<?php print $buchempfehlung['bild']['alt'];?>" title="<?php print $buchempfehlung['bild']['alt'];?>"/>
    <div class="teaser teaser-custom txt-80 txt-buchempfehlung">
        <h4>
            <?php if (strlen($buchempfehlung['link'])>0) { ?><a target="_blank" href="<?php print $buchempfehlung['link'];?>"> <?php } ?>
                <?php print $buchempfehlung['titel'];?>
                <?php if (strlen($buchempfehlung['link'])>0) { ?></a><?php } ?>
        </h4>
        <?php print $buchempfehlung['beschreibung'];?>
        <?php $button_text = "Jetzt kaufen"; ?>
        <?php $button_link = $buchempfehlung['link']; ?>
        <?php if (strlen($buchempfehlung['button_text'])>0) { $button_text = $buchempfehlung['button_text']; } ?>
        <a target="_blank" class="button" title="<?php print $button_text?>" href="<?php print $buchempfehlung['link'];?>">
            <?php print $button_text;  ?>
        </a>
    </div>
<?php }