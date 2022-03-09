<?php if (strlen($zeile['inhaltstyp'][0]['headline'])>0) { ;?><h2><?php print $zeile['inhaltstyp'][0]['headline'];?></h2><?php } ?>
<?php if (strlen($zeile['inhaltstyp'][0]['introtext'])>0) { ;?><?php print $zeile['inhaltstyp'][0]['introtext'];?><?php } ?>
<table>
    <?php $trcount = 0;
    $has_heading = false;
    $has_body = false;
    foreach($zeile['inhaltstyp'][0]['zeilen'] as $tr) {
    $trcount++;
    if ($trcount == 1 AND $tr['titelzeile'] == true) {
        $has_heading = true;
        ?>
        <thead>
        <?php foreach($tr['felder'] as $td) { ?>
            <th><?php print $td['feld'];?></th>
        <?php } ?>
        </thead>
    <?php } else { ?>
<?php if (($has_body == false) AND (($trcount == 1 AND $tr['titelzeile'] == false) OR ($trcount == 2 AND $has_heading == true))) { ?>
    <tbody>
    <?php
    $has_body = true;
    } ?>
    <tr>
        <?php foreach($tr['felder'] as $td) { ?>
            <td>
                <?php print $td['feld'];?>
            </td>
        <?php } ?>
    </tr>
    <?php } ?>
    <?php } ?>
    <?php if ($has_body == true) { ?> </tbody> <?php } ?>
</table>
