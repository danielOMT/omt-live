<?php // Kapitelmodul mit Sekundärnavigation?>
<div class="kapitel-wrap">
    <div class="kapitelnavigation-wrap">
        <div class="kapitelnavigation">
            <?php if (strlen($zeile['inhaltstyp'][0]['headline'])>0) { ?><b><?php print $zeile['inhaltstyp'][0]['headline'];?></b> <?php }?>
            <?php foreach ($zeile['inhaltstyp'][0]['kapitel'] as $kapitel) {?>
                <div><a  class="navigation navigation-main" href="#<?php print $kapitel['ankerlink_name'];?>"><?php print $kapitel['kapitel_navigation'];?></a>
                    <?php if (is_array($kapitel['unterkapitel'])) {?>
                        <div class="navigation-unterkapitel-wrap">
                            <?php foreach($kapitel['unterkapitel'] as $unterkapitel) { ?>
                                <a class="navigation navigation-unterkapitel" href="#<?php print $unterkapitel['ankerlink_name_Kopie'];?>"><?php print $unterkapitel['kapitel_navigation'];?></a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="kapitel-items-wrap">
        <?php foreach ($zeile['inhaltstyp'][0]['kapitel'] as $kapitel) {?>
            <div class="kapitel"><span class="anchor" id="<?php print $kapitel['ankerlink_name'];?>"></span>
                <?php if ("h2ihv" != $kapitel['kapitelheadline_typ']) { ?>
                <<?php print $kapitel['kapitelheadline_typ'];?> class="no-ihv"><?php print $kapitel['kapitelheadline'];?></<?php print $kapitel['kapitelheadline_typ'];?>>
        <?php } else { ?>
                <h2><?php print $kapitel['kapitelheadline'];?></h2>
        <?php } ?>
                <?php print $kapitel['kapitelinhalt'];
                if (is_array($kapitel['unterkapitel'])) {?>
                    <div class="unterkapitel-wrap">
                        <?php foreach($kapitel['unterkapitel'] as $unterkapitel) { ?>
                            <div class="unterkapitel">
                                <span class="anchor" id="<?php print $unterkapitel['ankerlink_name_Kopie'];?>"></span>
                                <<?php print $unterkapitel['kapitelheadline_typ_unterkapitel'];?> class="no-ihv"><?php print $unterkapitel['kapitelheadline'];?></<?php print $unterkapitel['kapitelheadline_typ_unterkapitel'];?>>
                                <?php print $unterkapitel['kapitelinhalt'];?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
