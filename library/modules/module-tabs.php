<?php if (strlen($zeile['inhaltstyp'][0]['tabs_headline'])>0) { ?>
    <h3 class="accordion-headline"><?php print $zeile['inhaltstyp'][0]['tabs_headline'];?></h3>
<?php }
$tabsi = 0; //tab buttons
$highlight_last = $zeile['inhaltstyp'][0]['letzten_hervorheben'];?>
<span id="selected" class="anchor"></span>
<div class="tab tab-buttons <?php if (1 == $highlight_last) { print 'highlight-last'; }?>">
    <?php foreach ($zeile['inhaltstyp'][0]['items'] as $item) { ;?>
        <span class="tablinks <?php if ($tabsi < 1) print 'active';?>" onclick="openTab(event, 'tab-<?php print $tabsi;?>')"><?php print $item['headline'];?></span>
        <?php
        $tabsi++;
    }?>
</div>

<?php $tabsi = 0; //tabcontent ?>
<div class="seminare-content-wrap">
    <div class="tab-content">
        <?php foreach ($zeile['inhaltstyp'][0]['items'] as $item) { ;?>
            <div id="tab-<?php print $tabsi;?>" class="tabcontent untabbed" <?php if ($tabsi<1) { ?>style="display:flex;"<?php } ?>>
                <?php print $item['text'];?>
            </div>
            <?php $tabsi++;
        } ?>
    </div>
</div>
