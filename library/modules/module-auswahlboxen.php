<?php
//foreach () {}
//auswahlboxen
////titel
////bild
////text
////link
///
foreach ($zeile['inhaltstyp'][0]['auswahlboxen'] as $item) { ?>
    <div class="auswahlbox card">
        <img src="<?php print $bild['url'];?>" alt="<?php print $bild['alt'];?>" title="<?php print $bild['alt'];?>" />
        <strong style="display:block;text-align:center;"><?php print $item['titel'];?></strong>
        <?php print $text;?>
    </div>
<?php } ?>