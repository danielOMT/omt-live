<?php
$current_user_id = get_current_user_id();
um_fetch_user($current_user_id);
$display_name = um_user('display_name');
$first_name = um_user('first_name');
$email = um_user('user_email');
$zugewiesenes_tool = get_field('zugewiesenes_tool', 'user_' . $current_user_id);
?>
<div class="backend-sections-wrap">
    <div class="backend-section lines-wrap">
        <h4>Willkommen, <?php print $first_name;?></h4>
        <p><b>Benutzer: </b><?php print $display_name;?></p>
        <p><b>Email: </b><?php print $email;?></p>
        <a class="backend-nav-button button button-lightgrey button-350px" href="#" data-backend="toolanbieter-stammdaten">Stammdaten bearbeiten</a>
        <h3 style="margin: 30px 0 0 0 !important;"><a href="/toolanbieter/dokumentation/" target="_blank">Dokumentation</a></h3>
    </div>
    <div class="backend-section lines-wrap">
        <h4>Deine Tools</h4>
            <?php foreach($zugewiesenes_tool as $tool) {
                $tool_id = $tool->ID;
                print "<p>" . get_the_title($tool_id) . "</p>";
            }?>
        <a class="backend-nav-button button button-lightgrey button-350px" href="#" data-backend="toolanbieter-tools-bearbeiten">Tools bearbeiten</a>
    </div>
</div>