<div class="webinar-teaser card clearfix">
    <div class="webinar-teaser-img">
        <a target="<?php print $zeile['inhaltstyp'][0]['link_target'];?>" href="<?php print $zeile['inhaltstyp'][0]['link'];?>" title="<?php print $zeile['inhaltstyp'][0]['headline']; ?>">
            <img
                    class="teaser-img"
                    alt="<?php print $zeile['inhaltstyp'][0]['headline']; ?>"
                    title="<?php print $zeile['inhaltstyp'][0]['headline']; ?>"
                    width="550"
                    height="290"
                    srcset="
            <?php print $zeile['inhaltstyp'][0]['bild']['sizes']['350-180'];?> 480w,
            <?php print $zeile['inhaltstyp'][0]['bild']['url'];?> 800w,
            <?php print $zeile['inhaltstyp'][0]['bild']['url'];?> 1400w"
                    sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                    src="<?php print $zeile['inhaltstyp'][0]['bild']['url'];?>"
                    src="<?php print $zeile['inhaltstyp'][0]['bild']['url'];?>">
        </a>
    </div>
    <div class="webinar-teaser-text">
        <div class="teaser-cat"><?php print $zeile['inhaltstyp'][0]['headline_red'];?></div>
        <h3><?php print $zeile['inhaltstyp'][0]['headline'];?></h3>
        <?php print $zeile['inhaltstyp'][0]['text']; ?>
        <a target="<?php print $zeile['inhaltstyp'][0]['link_target'];?>" class="button button-red" href="<?php print $zeile['inhaltstyp'][0]['link'];?>" title="<?php print $zeile['inhaltstyp'][0]['headline']; ?>"><?php print $zeile['inhaltstyp'][0]['buttontext'];?></a>
    </div>
</div>
