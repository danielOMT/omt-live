<?php
//foreach () {}
//auswahlboxen
////titel
////bild
////text
////link
///
foreach ($zeile['inhaltstyp'][0]['auswahlboxen'] as $item) { ?>
    <a class="auswahlbox card" href="<?php print $item['link'];?>">
        <img src="<?php print $item['bild']['url'];?>" alt="<?php print $item['bild']['alt'];?>" title="<?php print $item['bild']['alt'];?>" />
        <strong style="display:block;text-align:center;"><?php print $item['titel'];?></strong>
        <?php print $item['text'];?>
    </a>
<?php } ?>