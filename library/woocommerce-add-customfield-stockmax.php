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

add_action( 'woocommerce_variation_options_pricing', 'bbloomer_add_custom_field_to_variations', 10, 3 );

function bbloomer_add_custom_field_to_variations( $loop, $variation_data, $variation ) {
woocommerce_wp_text_input( array(
'id' => 'stock_max[' . $loop . ']',
'class' => 'short',
'label' => __( 'Lagerbestand Maximal', 'woocommerce' ),
'value' => get_post_meta( $variation->ID, 'stock_max', true )
)
);
}

// -----------------------------------------
// 2. Save custom field on product variation save

add_action( 'woocommerce_save_product_variation', 'bbloomer_save_custom_field_variations', 10, 2 );

function bbloomer_save_custom_field_variations( $variation_id, $i ) {
$custom_field = $_POST['stock_max'][$i];
if ( isset( $custom_field ) ) update_post_meta( $variation_id, 'stock_max', esc_attr( $custom_field ) );
}

// -----------------------------------------
// 3. Store custom field value into variation data

add_filter( 'woocommerce_available_variation', 'bbloomer_add_custom_field_variation_data' );

function bbloomer_add_custom_field_variation_data( $variations ) {
$variations['stock_max'] = '<div class="woocommerce_custom_field">Lagerbestand Maximal: <span>' . get_post_meta( $variations[ 'variation_id' ], 'stock_max', true ) . '</span></div>';
return $variations;
}