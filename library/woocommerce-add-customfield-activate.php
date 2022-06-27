<?php
/////////////////////////////
///
/**
* @snippet       Add Custom Field to Product Variations - WooCommerce
* @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
* @sourcecode    https://businessbloomer.com/?p=73545
* @author        Rodolfo Melogli
* @compatible    WooCommerce 3.5.6
* @donate $9     https://businessbloomer.com/bloomer-armada/
*/

// -----------------------------------------
// 1. Add custom field input @ Product Data > Variations > Single Variation

add_action( 'woocommerce_variation_options_pricing', 'add_custom_variation_activate_checkbox', 10, 3 );

function add_custom_variation_activate_checkbox( $loop, $variation_data, $variation ) {
    woocommerce_wp_checkbox( array(
'id' => '_activate_Pro[' . $loop . ']',
'class' => 'short',
'label' => __( 'Aktivieren: ', 'woocommerce' ),
'value' => get_post_meta( $variation->ID, '_activate_Pro', true )
)
);
}

// -----------------------------------------
// 2. Save custom field on product variation save

add_action( 'woocommerce_save_product_variation', 'save_custom_field_variations_activate_checkbox', 10, 2 );

function save_custom_field_variations_activate_checkbox( $variation_id, $i ) {
$custom_field = $_POST['_activate_Pro'][$i];
if ( isset( $custom_field ) ) update_post_meta( $variation_id, '_activate_Pro', esc_attr( $custom_field ) );
}

// -----------------------------------------
// 3. Store custom field value into variation data

add_filter( 'woocommerce_available_variation', 'add_custom_field_variation_data_activate_checkbox' );

function add_custom_field_variation_data_activate_checkbox( $variations ) {
$variations['_activate_Pro'] = '<div class="woocommerce_custom_field">Aktivieren: <span>' . get_post_meta( $variations[ 'variation_id' ], '_activate_Pro', true ) . '</span></div>';
return $variations;
}