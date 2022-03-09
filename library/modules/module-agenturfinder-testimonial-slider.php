<?php
$zeilen = $zeile['inhaltstyp'][0]['testimonials'];
if (strlen($zeilen[0]['name'])<1) { $zeilen = get_field('agenturfinder_testimonial_slider', 'options'); }
foreach ($zeilen as $testimonial) { ?>
    <div class="testimonial testimonial-slide card clearfix">
        <div class="testimonial-img">
            <img class="teaser-img" alt="<?php print $testimonial['name']; ?>" title="<?php print $testimonial['name']; ?>" src="<?php print $testimonial['bild']['url'];?>">
        </div>
        <div class="testimonial-text">
            <div class="teaser-cat">
                <?php print $testimonial['name'];?><br/>
                <b><?php print $testimonial['titel'];?></b>
            </div>
            <p><?php print $testimonial['text'];?></p>
            <?php if (strlen($testimonial['firma_url'])>0) { ?><a class="button button-red" target="<?php print $testimonial['link_target'];?>" href="<?php print $testimonial['link'];?>" ><?php } ?>
                <?php print $testimonial['firma_titel'];?>
                <?php if (strlen($testimonial['firma_url'])>0) { ?></a><?php } ?>
        </div>
    </div>
<?php } ?>
