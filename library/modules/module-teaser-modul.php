<?php
$bildgrose = $zeile['inhaltstyp'][0]['bildbreite'];
switch ($bildgrose) {
case "20":
$imageclass = "img-20";
$textclass = "txt-80";
break;
case "25":
$imageclass = "img-25";
$textclass = "txt-75";
break;
case "33":
$imageclass = "img-33";
$textclass = "txt-67";
break;
default:
$imageclass = "";
}
$imageclass .= " img" . $zeile['inhaltstyp'][0]['bildhohe_begrenzen'];
$imageclass .= " " . $zeile['inhaltstyp'][0]['bildausrichtung'];
if ($zeile['inhaltstyp'][0]['grose'] != "custom") { $imageclass = ""; }
?>
<?php foreach($zeile['inhaltstyp'][0]['teaser'] as $teaser) { ?>
<div class="teaser teaser-<?php print $zeile['inhaltstyp'][0]['grose'];?> <?php print $imageclass;?>">
    <img class="teaser-img" src="<?php print $teaser['teaser_bild']['url'];?>" alt="<?php print $teaser['teaser_bild']['alt'];?>" title="<?php print $teaser['teaser_bild']['alt'];?>"/>
    <?php if ($zeile['inhaltstyp'][0]['grose'] == "large") { ?>
        </div>
        <div class="teaser teaser-large">
    <?php } ?>
    <?php if ($zeile['inhaltstyp'][0]['grose'] == "custom") { ?>
        </div>
        <div class="teaser teaser-custom <?php print $textclass;?>">
    <?php } ?>
    <?php if (strlen($teaser['teaser_highlight_rot'])>0) { ?><h4 class="teaser-cat"><?php print $teaser['teaser_highlight_rot'];?></h4><?php } ?>
    <h4>
        <?php if (strlen($teaser['teaser_link'])>0) { ?><a target="<?php print $teaser['link_blank'];?>" href="<?php print $teaser['teaser_link'];?>"> <?php } ?>
            <?php print $teaser['teaser_titel'];?>
            <?php if (strlen($teaser['teaser_link'])>0) { ?></a><?php } ?>
    </h4>
    <?php if (strlen($teaser['teaser_highlight_text'])>0) { ?><p class="text-highlight"><?php print $teaser['teaser_highlight_text'];?></p> <?php } ?>
    <?php print $teaser['teaser_text'];?>
    <?php if (strlen($teaser['teaser_button_text'])>0 AND strlen($teaser['teaser_link'])>0) { ?>
        <a target="<?php print $teaser['link_blank'];?>" class="button button-full" title="<?php print $teaser['teaser_button_text'];?>" href="<?php print $teaser['teaser_link'];?>"><?php print $teaser['teaser_button_text'];?></a>
    <?php } ?>
    </div>
<?php } ?>
