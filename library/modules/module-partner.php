<?php
foreach ($zeile['inhaltstyp'][0]['partner'] as $partner) { ?>
    <?php if (strlen($partner['link'])>0) { ?>
        <a class="teaser teaser-small partner-button partner-button-<?php print $zeile['inhaltstyp'][0]['grose'];?>" href="<?php print $partner['link'];?>">
            <img
                    class="partner-single"
                    width="350"
                    height="180"
                    srcset="
            <?php print $partner['logo']['url'];?> 480w,
            <?php print $partner['logo']['url'];?> 800w,
            <?php print $partner['logo']['url'];?> 1400w"
                    sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                    src="<?php print $partner['logo']['url'];?>"
                    alt="<?php print $partner['name'];?>"
                    title="<?php print $partner['name'];?>"
            />
        </a>
    <?php } else { ?>
        <div class="teaser teaser-small partner-button partner-button-<?php print $zeile['inhaltstyp'][0]['grose'];?>">
            <img
                    class="partner-single"
                    width="350"
                    height="180"
                    srcset="
            <?php print $partner['logo']['url'];?> 480w,
            <?php print $partner['logo']['url'];?> 800w,
            <?php print $partner['logo']['url'];?> 1400w"
                    sizes="
                            (max-width: 768px) 480w,
                            (min-width: 768px) and (max-width: 1399px) 800w,
                            (min-width: 1400px) 1400w"
                    src="<?php print $partner['logo']['url'];?>"
                    alt="<?php print $partner['name'];?>"
                    title="<?php print $partner['name'];?>"
            />
        </div>
    <?php }
}
?>