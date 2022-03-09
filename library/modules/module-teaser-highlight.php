<?php
$standard_icon_teaser_highlight = get_field('standard_icon_teaser_highlight', 'options');
if ($zeile['inhaltstyp'][0]['link_target'] != false) { $target = "_blank"; } else { $target="_self"; } ?>
<a class="teaser-highlight teaser-highlight-linkwrap"  href="<?php print $zeile['inhaltstyp'][0]['link'];?>" target="<?php print $target;?>">
    <div class="teaser-highlight-container">
        <!--starting teaser highlight content-->
        <div class="teaser-highlight-img">
            <img
                    title="<?php print $standard_icon_teaser_highlight['alt'];?>"
                    alt="<?php print $standard_icon_teaser_highlight['alt'];?>"
                    src="<?php print $standard_icon_teaser_highlight['url'];?>"
            />
        </div>
        <div class="teaser-highlight-text">
            <h3><?php print $zeile['inhaltstyp'][0]['headline'];?></h3>
            <p><?php print $zeile['inhaltstyp'][0]['text'];?></p>
        </div>
        <!--ending teaser highlight content-->
    </div>
</a>
