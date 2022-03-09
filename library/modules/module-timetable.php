<?php $anzahl_raume = $zeile['inhaltstyp'][0]['anzahl_raume'];
$fullcolspan = $anzahl_raume;
?>
<?php if (strlen($zeile['inhaltstyp'][0]['headline'])>0) { ;?><h2><?php print $zeile['inhaltstyp'][0]['headline'];?></h2><?php } ?>
<?php if (strlen($zeile['inhaltstyp'][0]['introtext'])>0) { ;?><?php print $zeile['inhaltstyp'][0]['introtext'];?><?php } ?>
<?php if ($zeile['inhaltstyp'][0]['timetable_verstecken'] != 1) { ?>
    <div class="legend">

        <div class="table-cats">
            <b>Legende:</b>
            <i class="cat1 fa fa-circle"></i> Anfänger
            <i class="cat2 fa fa-circle"></i> Fortgeschrittene
            <i class="cat3 fa fa-circle"></i> Experten
        </div>
    </div>

    <table>
        <thead>
        <?php
        $mod1_id = $zeile['inhaltstyp'][0]['moderator_raum_1']->ID;
        $mod2_id = $zeile['inhaltstyp'][0]['moderator_raum_2']->ID;
        $mod3_id = $zeile['inhaltstyp'][0]['moderator_raum_3']->ID;
        ?>
        <th class="time"><b>Uhrzeit</b></th>
        <th class="room"><b>Raum 1</b><br />Moderator: <a style="color:white;" target="_blank" href="<?php print get_the_permalink($mod1_id)?>"><?php print $zeile['inhaltstyp'][0]['moderator_raum_1']->post_title;?></a></th>
        <th class="room"><b>Raum 2</b><br />Moderator: <a style="color:white;" target="_blank" href="<?php print get_the_permalink($mod2_id)?>"><?php print $zeile['inhaltstyp'][0]['moderator_raum_2']->post_title;?></a></th>
        <?php if ($anzahl_raume >2) { ?>
            <th class="room"><b>Raum 3</b><br />Moderator: <a style="color:white;" target="_blank" href="<?php print get_the_permalink($mod3_id)?>"><?php print $zeile['inhaltstyp'][0]['moderator_raum_3']->post_title;?></a></th>
        <?php } ?>
        </thead>
        <tbody>
        <?php foreach ($zeile['inhaltstyp'][0]['timetable'] as $zeile) { ?>
            <tr>
                <td class="time"><b><?php print $zeile['uhrzeit'];?></b></td>
                <?php //find out if the other columns have entries, if not, increase colspan!
                if ( strlen($zeile['vortrag_raum_1']->ID)>0 OR strlen($zeile['freitext_raum_1'])>0) { $occupied1 = true; } else { $occupied1 = false; }
                if ( strlen($zeile['vortrag_raum_2']->ID)>0 OR strlen($zeile['freitext_raum_2'])>0) { $occupied2 = true; } else { $occupied2 = false; }
                if ( strlen($zeile['vortrag_raum_3']->ID)>0 OR strlen($zeile['freitext_raum_3'])>0) { $occupied3 = true; } else { $occupied3 = false; }

                if (true == $occupied1) {
                    if (false == $occupied2 AND false == $occupied3) {
                        $colspan1 = $fullcolspan;;
                        $alignment = "left";
                    } else {
                        $colspan1 = "1"; }
                }else {
                    $colspan1 = "0"; }

                if (true == $occupied2) {
                    if (false == $occupied1 AND false == $occupied3) {
                        $colspan2 = $fullcolspan;
                        $alignment = "center";
                    } else {
                        $colspan2 = "1"; }
                } else {
                    $colspan2 = "0"; }

                if (true == $occupied3) {
                    if (false == $occupied2 AND false == $occupied1) {
                        $colspan3 = $fullcolspan;
                        $alignment = "right";
                    } else {
                        $colspan3 = "1"; }
                } else {
                    $colspan3 = "0"; }

                ?>
                <?php if ($colspan1 != 0) { ?>
                    <td class="room" style="text-align:<?php print $alignment;?>;" colspan="<?php print $colspan1;?>"><?php if (strlen($zeile['freitext_raum_1'])>0) {
                            print $zeile['freitext_raum_1']; } else {
                            $vortrag_id = $zeile['vortrag_raum_1']->ID;
                            if (strlen($vortrag_id)>0) {
                                $titel = get_field('vorschautitel_des_vortrags', $vortrag_id);
                                $schwierigkeitsgrad = get_field('schwierigkeitsgrad', $vortrag_id);
                                $speaker = get_field('speaker', $vortrag_id);
                                $speaker_alternativtext = get_field('speaker_alternativtext', $vortrag_id);
                                $speaker_name = "";
                                ?><b>
                                <?php
                                $i = 0;
                                if (strlen($speaker_alternativtext)<1) {
                                    foreach ($speaker as $helper) {
                                        $i++;
                                        if ($i > 1 AND $i != count($speaker)) { print ", "; }
                                        if ($i > 1 AND $i == count($speaker)) { print " und "; }
                                        ?>
                                        <a target="_blank" href="<?php print get_the_permalink($helper->ID);?>"><?php print get_the_title($helper->ID); ?></a>
                                    <?php } } else { print $speaker_alternativtext; } ?></b><br />
                                <?php print $titel;?> <i class="fa fa-info btn" data-popup-open="popup-<?php print $vortrag_id;?>"></i>
                                <div class="table-cats">
                                    <?php if (in_array(1, $schwierigkeitsgrad)) { ?><i class="cat1 fa fa-circle"></i><?php } ?>
                                    <?php if (in_array(2, $schwierigkeitsgrad)) { ?><i class="cat2 fa fa-circle"></i><?php } ?>
                                    <?php if (in_array(3, $schwierigkeitsgrad)) { ?><i class="cat3 fa fa-circle"></i><?php } ?>
                                </div>
                                <div class="popup" data-popup="popup-<?php print $vortrag_id;?>">
                                    <div class="close-layer" data-popup-close="popup-<?php print $vortrag_id;?>"></div>
                                    <div class="popup-inner">
                                        <div>
                                            <h3><?php print $titel;?></h3>
                                            <?php print get_field('vorschautext_des_vortrags', $vortrag_id);?>
                                        </div>
                                        <a class="popup-close" data-popup-close="popup-<?php print $vortrag_id;?>" href="#">x</a>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </td> <?php } //end raum 1?>
                <?php if ($colspan2 != 0) { ?>
                    <td class="room" style="text-align:<?php print $alignment;?>;" colspan="<?php print $colspan2;?>"><?php if (strlen($zeile['freitext_raum_2'])>0) {
                            print $zeile['freitext_raum_2']; } else {
                            $vortrag_id = $zeile['vortrag_raum_2']->ID;
                            if (strlen($vortrag_id)>0) {
                                $titel = get_field('vorschautitel_des_vortrags', $vortrag_id);
                                $schwierigkeitsgrad = get_field('schwierigkeitsgrad', $vortrag_id);
                                $speaker = get_field('speaker', $vortrag_id);
                                $speaker_alternativtext = get_field('speaker_alternativtext', $vortrag_id);
                                $speaker_name = "";
                                ?><b>
                                <?php
                                $i = 0;
                                if (strlen($speaker_alternativtext)<1) {
                                    foreach ($speaker as $helper) {
                                        $i++;
                                        if ($i > 1 AND $i != count($speaker)) { print ", "; }
                                        if ($i > 1 AND $i == count($speaker)) { print " und "; }
                                        ?>
                                        <a target="_blank" href="<?php print get_the_permalink($helper->ID);?>"><?php print get_the_title($helper->ID); ?></a>
                                    <?php } } else { print $speaker_alternativtext; } ?></b><br />
                                <?php print $titel;?> <i class="fa fa-info btn" data-popup-open="popup-<?php print $vortrag_id;?>"></i>
                                <div class="table-cats">
                                    <?php if (in_array(1, $schwierigkeitsgrad)) { ?><i class="cat1 fa fa-circle"></i><?php } ?>
                                    <?php if (in_array(2, $schwierigkeitsgrad)) { ?><i class="cat2 fa fa-circle"></i><?php } ?>
                                    <?php if (in_array(3, $schwierigkeitsgrad)) { ?><i class="cat3 fa fa-circle"></i><?php } ?>
                                </div>
                                <div class="popup" data-popup="popup-<?php print $vortrag_id;?>">
                                    <div class="close-layer" data-popup-close="popup-<?php print $vortrag_id;?>"></div>
                                    <div class="popup-inner">
                                        <div>
                                            <h3><?php print $titel;?></h3>
                                            <?php print get_field('vorschautext_des_vortrags', $vortrag_id);?>
                                        </div>
                                        <a class="popup-close" data-popup-close="popup-<?php print $vortrag_id;?>" href="#">x</a>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </td> <?php } //end raum 2?>
                <?php if ($colspan3 != 0) { ?>
                    <td class="room" style="text-align:<?php print $alignment;?>;" colspan="<?php print $colspan3;?>"><?php if (strlen($zeile['freitext_raum_3'])>0) {
                            print $zeile['freitext_raum_3']; } else {
                            $vortrag_id = $zeile['vortrag_raum_3']->ID;
                            if (strlen($vortrag_id)>0) {
                                $titel = get_field('vorschautitel_des_vortrags', $vortrag_id);
                                $schwierigkeitsgrad = get_field('schwierigkeitsgrad', $vortrag_id);
                                $speaker = get_field('speaker', $vortrag_id);
                                $speaker_alternativtext = get_field('speaker_alternativtext', $vortrag_id);
                                $speaker_name = "";
                                ?><b>
                                <?php
                                $i = 0;
                                if (strlen($speaker_alternativtext)<1) {
                                foreach ($speaker as $helper) {
                                    $i++;
                                    if ($i > 1 AND $i != count($speaker)) { print ", "; }
                                    if ($i > 1 AND $i == count($speaker)) { print " und "; }
                                    ?>
                                    <a target="_blank" href="<?php print get_the_permalink($helper->ID);?>"><?php print get_the_title($helper->ID); ?></a>
                                <?php } } else { print $speaker_alternativtext; } ?></b><br />
                                <?php print $titel;?> <i class="fa fa-info btn" data-popup-open="popup-<?php print $vortrag_id;?>"></i>

                                <div class="table-cats">
                                    <?php if (in_array(1, $schwierigkeitsgrad)) { ?><i class="cat1 fa fa-circle"></i><?php } ?>
                                    <?php if (in_array(2, $schwierigkeitsgrad)) { ?><i class="cat2 fa fa-circle"></i><?php } ?>
                                    <?php if (in_array(3, $schwierigkeitsgrad)) { ?><i class="cat3 fa fa-circle"></i><?php } ?>
                                </div>
                                <div class="popup" data-popup="popup-<?php print $vortrag_id;?>">
                                    <div class="close-layer" data-popup-close="popup-<?php print $vortrag_id;?>"></div>
                                    <div class="popup-inner">
                                        <div>
                                            <h3><?php print $titel;?></h3>
                                            <?php print get_field('vorschautext_des_vortrags', $vortrag_id);?>
                                        </div>
                                        <a class="popup-close" data-popup-close="popup-<?php print $vortrag_id;?>" href="#">x</a>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </td> <?php } //end raum 3?>
            </tr>
        <?php } //end foreach Zeile ?>
        </tbody>
    </table>
<?php } //end of if timetable verstecken != 1?>