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
    </div>
    <div class="backend-section lines-wrap">

    </div>
</div>