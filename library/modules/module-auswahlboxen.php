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
        <img src="<?php print $item['url'];?>" alt="<?php print $item['alt'];?>" title="<?php print $item['alt'];?>" />
        <strong style="display:block;text-align:center;"><?php print $item['titel'];?></strong>
        <?php print $item['text'];?>
    </div>
<?php } ?>