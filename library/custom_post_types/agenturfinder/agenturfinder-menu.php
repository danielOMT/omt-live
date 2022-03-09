<?php
function agenturfinder_admin_menu() {
    add_menu_page(
        'Agenturfinder',
        'Agenturfinder',
        'read',
        'agenturfinder',
        '', // Callback, leave empty
        'dashicons-calendar',
        2 // Position
    );
}
add_action( 'admin_menu', 'agenturfinder_admin_menu' );