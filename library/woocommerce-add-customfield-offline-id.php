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

add_action( 'woocommerce_variation_options_pricing', 'add_custom_variation_offline_id', 10, 3 );

function add_custom_variation_offline_id( $loop, $variation_data, $variation ) {
woocommerce_wp_text_input( array(
'id' => 'offline_id[' . $loop . ']',
'class' => 'short',
'label' => __( 'Variation-ID der zugehörigen Offline-Variante (falls Hybrid-Seminar)', 'woocommerce' ),
'value' => get_post_meta( $variation->ID, 'offline_id', true )
)
);
}

// -----------------------------------------
// 2. Save custom field on product variation save

add_action( 'woocommerce_save_product_variation', 'save_custom_variation_offline_id', 10, 2 );

function save_custom_variation_offline_id( $variation_id, $i ) {
$custom_field = $_POST['offline_id'][$i];
if ( isset( $custom_field ) ) update_post_meta( $variation_id, 'offline_id', esc_attr( $custom_field ) );
}

// -----------------------------------------
// 3. Store custom field value into variation data

add_filter( 'woocommerce_available_variation', 'add_custom_variation_data_offline_id' );

function add_custom_variation_data_offline_id( $variations ) {
$variations['offline_id'] = '<div class="woocommerce_custom_field">Variation-ID der zugehörigen Offline-Variante (falls Hybrid-Seminar): <span>' . get_post_meta( $variations[ 'variation_id' ], 'offline_id', true ) . '</span></div>';
return $variations;
}