<?php
$name = $zeile['inhaltstyp'][0]['name'];
$bild = $zeile['inhaltstyp'][0]['bild'];
$link = $zeile['inhaltstyp'][0]['link'];
$button_text = $zeile['inhaltstyp'][0]['button_text'];
$checkliste_linke_spalte = $zeile['inhaltstyp'][0]['checkliste_linke_spalte'];
$checkliste_rechte_spalte = $zeile['inhaltstyp'][0]['checkliste_rechte_spalte'];
//name
//wahr_falsch ?>
<a href="<?php print $link;?>" class="testimonial card clearfix vip-produkt" target="_blank">
    <h3 class="experte"><?php print $name;?></h3>
    <h4 class="teaser-cat experte-info"><?php print $speakerbeschreibung;?></h4>
    <div class="testimonial-img">
        <img class="teaser-img" alt="<?php print $name; ?>" title="<?php print $name; ?>" src="<?php print $bild['sizes']['350-180'];?>">
        <span class="button has-margin-top-30 button-red"  ><?php print $button_text;?></span>

    </div>
    <div class="testimonial-text checklist-wrap">
        <div class="checklist checklist-left">
            <?php foreach ($checkliste_linke_spalte as $item) {?>
                <div class="checklist-item">
                    <div class="name"><?php print $item['name'];?></div>
                    <div class="status"><?php if (1 == $item['wahr_falsch']) { ?><i class="fa fa-check"></i> <?php } else { ?> <i class="fa fa-times"></i><?php };?></div>
                </div>
            <?php } ?>
        </div>
        <div class="checklist checklist-right">
            <?php foreach ($checkliste_rechte_spalte as $item_r) { ?>
                <div class="checklist-item">
                    <div class="name"><?php print $item_r['name'];?></div>
                    <div class="status"><?php if (1 == $item_r['wahr_falsch']) { ?><i class="fa fa-check"></i> <?php } else { ?> <i class="fa fa-times"></i><?php };?></div>
                </div>
            <?php } ?>
        </div>
    </div>
</a>