<?php if (strlen($zeile['inhaltstyp'][0]['accordion_headline'])>0) { ?>
    <h3 class="accordion-headline"><?php print $zeile['inhaltstyp'][0]['accordion_headline'];?></h3>
<?php }
$accitemcount = 0; ?>
<?php foreach ($zeile['inhaltstyp'][0]['items'] as $item) { ;?>
    <div class="accordion-item <?php if (1 == $zeile['inhaltstyp'][0]['erstes_item_geschlossen_lassen']) { print "initial-closed"; } ?>">
        <h3 class="accordion-title"><?php print $item['headline'];?><span class="fa fa-plus"></span></h3>
        <div class="accordion-content">
            <?php print $item['text'];?>
        </div>
    </div>
    <?php
    $accitemcount++;
}
if ($accitemcount<1) { ?><span class="hidethis"></span><?php }
if ($accitemcount<1) { ?><span class="hidefull"></span><?php } ?>
