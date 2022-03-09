<?php
    $eigenschaften_titel = $zeile['inhaltstyp'][0]['eigenschaften_titel'];
    $bewertungen_titel = $zeile['inhaltstyp'][0]['bewertungen_titel'];
    $tools_auswahlen = $zeile['inhaltstyp'][0]['tools_auswahlen'];
//tool
//bewertung_text
//bewertung_datum
//bewertung_sterne
//eigenschaften__werte
//bewertungen__werte
//testsieger
    ?>
    <table class="vergleichstabelle">
        <tr>
            <th></th>
            <?php
            $count_with_pricelink = 0;
            $count_with_toollink = 0;
            ?>
            <?php foreach($tools_auswahlen as $tool) {
                $ID = $tool['tool']->ID;
                $tool_image = get_field('logo', $ID);
                $tool_title = str_replace('Privat: ', "", get_the_title($ID));
                if (strlen($tool['link_price'])>0) { $count_with_pricelink++; };
                if (strlen($tool['link'])>0) { $count_with_toollink++; };
                ?>
                <td class="logo-wrap">
                    <img class="tool-image" alt="<?php print $tool_title;?>" title="<?php print $tool_title;?>" src="<?php print $tool_image['url'];?>">
                </td>
            <?php } ?>
        </tr>
        <tr>
            <th>Tool</th>
            <?php foreach($tools_auswahlen as $tool) {
                $ID = $tool['tool']->ID;
                $tool_title = str_replace('Privat: ', "", get_the_title($ID));
                ?>
                <td><?php print $tool_title;?></td>
            <?php } ?>
        </tr>
        <?php $eigenschaften_i = 0;
        foreach($eigenschaften_titel as $titel) { ?>
            <tr>
                <th><?php print $titel['eigenschaft'];?></th>
                <?php foreach( $tools_auswahlen as $tool) { ?>
                    <td>
                        <?php if ("true" == $tool['eigenschaften__werte'][$eigenschaften_i]['wert']) { ?><i class="fa fa-check"></i> <?php } ?>
                        <?php if ("false" == $tool['eigenschaften__werte'][$eigenschaften_i]['wert']) { ?><i class="fa fa-times"></i> <?php } ?>
                        <?php if ("false" != $tool['eigenschaften__werte'][$eigenschaften_i]['wert'] AND "true" != $tool['eigenschaften__werte'][$eigenschaften_i]['wert']) { print $tool['eigenschaften__werte'][$eigenschaften_i]['wert']; } ?>
                    </td>
                <?php } ?>
            </tr>
            <?php
            $eigenschaften_i++;
        } ?>
        <?php if ($count_with_pricelink>0) { ?>
            <tr>
                <th>
                    Preise
                </th>
                <?php foreach($tools_auswahlen as $tool) { ?>
                    <td><?php if (strlen($tool['link_price'])>0) { ?><a href="<?php print $tool['link_price'];?>" target="_blank">zur Preisübersicht</a><?php } ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
        <?php if ($count_with_toollink>0) { ?>
            <tr>
                <th>
                    Website
                </th>
                <?php foreach($tools_auswahlen as $tool) { ?>
                    <td><?php if (strlen($tool['link'])>0) { ?><a class="button button-red" href="<?php print $tool['link'];?>" target="_blank">zum Tool</a><?php } ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>
    <?php
//mobile Version
    ?>
    <div class="vergleichstabelle-mobile">
        <?php
        foreach($tools_auswahlen as $tool) {
            $ID = $tool['tool']->ID;
            $tool_image = get_field('logo', $ID);
            $tool_title = str_replace('Privat: ', "", get_the_title($ID));
            ?>
            <div class="tool card">
                <img class="tool-image" alt="<?php print $tool_title;?>" title="<?php print $tool_title;?>" src="<?php print $tool_image['url'];?>">
                <?php $eigenschaften_i = 0;
                foreach($eigenschaften_titel as $titel) { ?>
                    <p><strong><?php print $titel['eigenschaft'];?>: </strong>
                        <?php if ("true" == $tool['eigenschaften__werte'][$eigenschaften_i]['wert']) { ?><i class="fa fa-check"></i> <?php } ?>
                        <?php if ("false" == $tool['eigenschaften__werte'][$eigenschaften_i]['wert']) { ?><i class="fa fa-times"></i> <?php } ?>
                        <?php if ("false" != $tool['eigenschaften__werte'][$eigenschaften_i]['wert'] AND "true" != $tool['eigenschaften__werte'][$eigenschaften_i]['wert']) { print $tool['eigenschaften__werte'][$eigenschaften_i]['wert']; } ?>
                    </p>
                    <?php
                    $eigenschaften_i++;
                } ?>
                <p><?php if (strlen($tool['link_price'])>0) { ?><a href="<?php print $tool['link_price'];?>" target="_blank">zur Preisübersicht</a><?php } ?></p>
                <?php if (strlen($tool['link'])>0) { ?><a class="button button-red" href="<?php print $tool['link'];?>" target="_blank">zum Tool</a><?php } ?>
            </div>
        <?php } ?>