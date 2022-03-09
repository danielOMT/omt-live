<?php
foreach ($zeile['inhaltstyp'][0]['testimonials'] as $testimonial) { ?>
    <div class="testimonial testimonial-slide card clearfix">
        <div class="testimonial-img">
            <?php if (strlen($testimonial['autor_link'])>0) { ?>
            <a target="_blank" href="<?php print $testimonial['autor_link'];?>">
                <?php } ?>
                <img class="teaser-img" alt="<?php print $testimonial['autor']; ?>" title="<?php print $testimonial['autor']; ?>" src="<?php print $testimonial['bild']['url'];?>">
                <?php if (strlen($testimonial['autor_link'])>0) { ?>
            </a>
        <?php } ?>
        </div>
        <div class="testimonial-text">
            <div class="teaser-cat"><?php if (strlen($testimonial['autor_link'])>0) { ?>
                <a target="_blank" href="<?php print $testimonial['autor_link'];?>"><?php } ?>
                    <?php print $testimonial['autor'];?>
                    <?php if (strlen($testimonial['autor_link'])>0) { ?></a><?php } ?></div>
            <p><b><?php print $testimonial['autor_beschreibung'];?></b></p>
            <p><?php print $testimonial['headline'];?></p>
            <?php if (strlen($testimonial['buttontext'])>0) { ?>
                <a class="button button-red" target="<?php print $testimonial['link_target'];?>" href="<?php print $testimonial['link'];?>" ><?php print $testimonial['buttontext'];?></a>
            <?php } ?>
        </div>
    </div>
<?php } ?>
