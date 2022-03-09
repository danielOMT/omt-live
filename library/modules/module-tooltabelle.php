<?php //Vergleichstabelle Tools
$tabelle_auswahlen = $zeile['inhaltstyp'][0]['tabelle_auswahlen'];
//tool
//bewertung_text
//bewertung_datum
//bewertung_sterne
//eigenschaften_werte
//bewertungen__werte
//testsieger
?>
    <table class="vergleichstabelle">
        <tr>
            <th></th>
            <?php
            $count_with_pricelink = 0;
            $count_with_toollink = 0;
            $tabellenID = $tabelle_auswahlen->ID;
            $tools_auswahlen = get_field('tools_auswahlen', $tabellenID);
            $eigenschaften_titel = get_field('eigenschaften_titel', $tabellenID);

            foreach($tools_auswahlen as $tool) {
                $ID = $tool['tool']->ID;
                $zur_preisubersicht = $tool['zur_preisubersicht'];
                $zur_website = $tool['zur_website'];
                $tool_image = get_field('logo', $ID);
                $tool_title = str_replace('Privat: ', "", get_the_title($ID));
                if (strlen($zur_preisubersicht)>0) { $count_with_pricelink++; };
                if (strlen($zur_website)>0) { $count_with_toollink++; };
                ?>
                <td class="logo-wrap">
                    <img class="tool-image" alt="<?php print $tool_title;?>" title="<?php print $tool_title;?>" src="<?php print $tool_image['url'];?>">
                </td>
            <?php } ?>
        </tr>
        <tr>
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
                        <?php if ("true" == $tool['eigenschaften_werte'][$eigenschaften_i]['wert']) { ?><i class="fa fa-check"></i> <?php } ?>
                        <?php if ("false" == $tool['eigenschaften_werte'][$eigenschaften_i]['wert']) { ?><i class="fa fa-times"></i> <?php } ?>
                        <?php if ("false" != $tool['eigenschaften_werte'][$eigenschaften_i]['wert'] AND "true" != $tool['eigenschaften_werte'][$eigenschaften_i]['wert']) { print $tool['eigenschaften_werte'][$eigenschaften_i]['wert']; } ?>
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
                    <td><?php if (strlen($tool['zur_preisubersicht'])>0) { ?><a href="<?php print $tool['zur_preisubersicht'];?>" target="_blank">zur Preisübersicht</a><?php } ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
        <?php if ($count_with_toollink>0) { ?>
            <tr>
                <th>
                    Website
                </th>
                <?php foreach($tools_auswahlen as $tool) { ?>
                    <td><?php if (strlen($tool['zur_website'])>0) { ?><a class="button button-red" href="<?php print $tool['zur_website'];?>" target="_blank">zum Tool</a><?php } ?></td>
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
                        <?php if ("true" == $tool['eigenschaften_werte'][$eigenschaften_i]['wert']) { ?><i class="fa fa-check"></i> <?php } ?>
                        <?php if ("false" == $tool['eigenschaften_werte'][$eigenschaften_i]['wert']) { ?><i class="fa fa-times"></i> <?php } ?>
                        <?php if ("false" != $tool['eigenschaften_werte'][$eigenschaften_i]['wert'] AND "true" != $tool['eigenschaften_werte'][$eigenschaften_i]['wert']) { print $tool['eigenschaften_werte'][$eigenschaften_i]['wert']; } ?>
                    </p>
                    <?php
                    $eigenschaften_i++;
                } ?>
                <p><?php if (strlen($zur_preisubersicht)>0) { ?><a href="<?php print $zur_preisubersicht;?>" target="_blank">zur Preisübersicht</a><?php } ?></p>
                <?php if (strlen($zur_website)>0) { ?><a class="button button-red" href="<?php print $zur_website;?>" target="_blank">zum Tool</a><?php } ?>
            </div>
        <?php }
