<?php
function themenwelten_admin_menu() {
    add_menu_page(
        'Magazin / Themenwelten',
        'Magazin / Themenwelten',
        'read',
        'themenwelten',
        '', // Callback, leave empty
        'dashicons-calendar',
        2 // Position
    );
}
add_action( 'admin_menu', 'themenwelten_admin_menu' );