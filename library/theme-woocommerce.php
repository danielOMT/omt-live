<?php

use OMT\Model\User;
use OMT\Model\WooCart;
use OMT\Model\WooProduct;
use OMT\Services\Checkout;
use OMT\Services\Order;

//declaring woocommerce support
function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce', array(
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ) );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

///////////////////////////////////////

//remove add to cart notice
add_filter( 'wc_add_to_cart_message', 'remove_add_to_cart_message' );

function remove_add_to_cart_message() {
    return;
}

// Empty Cart on before adding a new product so we cannot make more than 1 product into the cart (also prevents double-add by refreshing cart page with add-to-cart link!)
// LINK SOLUTION: https://www.omt.de/kasse/?add-to-cart=201855&nyp=101
function maybe_clear_cart()
{
    if (isset($_REQUEST['add-to-cart'])) {
        global $woocommerce;
        $product_id = 201855;
        $request = $_REQUEST['add-to-cart'];
        $product_cart_id = WC()->cart->generate_cart_id($product_id);
        $guthabenin_cart = WC()->cart->find_product_in_cart($product_cart_id);

        wc()->cart->empty_cart();
    } else {
        return;
    }
}

//add_action( 'woocommerce_add_cart_item_data', 'maybe_clear_cart', 20 );
add_action( 'wp_loaded', 'maybe_clear_cart', 10 );


/**
 * @snippet       Redirect to Checkout Upon Add to Cart - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    Woo 3.8
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

add_filter( 'woocommerce_add_to_cart_redirect', 'bbloomer_redirect_checkout_add_cart' );

function bbloomer_redirect_checkout_add_cart() {
    return wc_get_checkout_url();
}
/////////////////////////////////////////////////////////////////

//moving coupon shoutout to after checkout form fields
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
add_action( 'woocommerce_after_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

//adding content on top of checkout page/form
add_action( 'woocommerce_before_checkout_form', 'info_before_checkout', 10 );

function info_before_checkout() {
    $product_id = $_GET['add-to-cart'];
    $startdatum = $_GET['attribute_pa_startdatum'];
    $enddatum = $_GET['attribute_pa_enddatum'];
    $startuhrzeit = $_GET['attribute_pa_startuhrzeit'];
    $enduhrzeit = $_GET['attribute_pa_enduhrzeit'];
    $location = $_GET['attribute_pa_location'];
    $speaker_id = $_GET['speaker_id'];

    $hotel_telefonnummer = get_field('hotel_telefonnummer', $location);
    $hotel_homepage = get_field('hotel_homepage', $location);
    $hotel_email = get_field('hotel_email', $location);
    $hotel_adresse = get_field('hotel_adresse', $location);
    $location_stadtname = get_field('location_stadtname', $location);
    $seminar_speaker = get_field("seminar_speaker", $product_id);
    ?>
    <?php if (strlen($location)>0) { ?>
        <div class="widget seminare-text location-map-wrap">
            <h4 class="no-margin-top no-margin-bottom">Bestellung: Seminar <?php print get_the_title($product_id);?> in <?php print $location_stadtname;?></h4>
            <div class="webinar-meta">
                <p class="teaser-cat">
                    <?php if ($startdatum == $enddatum) {
                        print str_replace('-','.',$startdatum);
                    } else {
                        print str_replace('-','.',$startdatum) . " - " . str_replace('-','.',$enddatum);
                    } ?> |
                    <?php print str_replace('-',':',$startuhrzeit) . " Uhr - " . str_replace('-',':',$enduhrzeit) . " Uhr"; ?></p>
                <p class="text-highlight">
                    <?php print get_the_title($speaker_id);?>
                </p>
            </div>
            <?php wp_enqueue_script('google-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDFmVEWDZOoE8GtOglBut7XSID-OSC6hK0', null, null, true); // Add in your key ?>
            <div class="acf-map" style="">
                <div class="marker" data-lat="<?php echo $hotel_adresse['lat']; ?>" data-lng="<?php echo $hotel_adresse['lng']; ?>">
                    <div class="agentur-titel-wrap">
                        <h4 style="margin:0 0 10px 0;"><a href="<?php print get_the_permalink($location);?>" target="_blank"><?php print get_the_title($location);?></a></h4>
                    </div>
                    <div class="agentur-adresse">
                        <?php // print $agentur['adresse'];?>
                        <?php print $hotel_adresse['address'];?>
                    </div>
                    <p class="agentur-email">
                        <a href="mailto:<?php print $hotel_email;?>"><?php print $hotel_email;?></a><br/>
                        Telefon: <?php print $hotel_telefonnummer;?>
                    </p>
                </div>
            </div>
            <div class="route-berechnen-wrap">
                <strong>Route berechnen:</strong>
                <form action="https://maps.google.com/maps" method="get" target="_blank">
                    <input class="inputbox" placeholder="Startadresse (mit Ort)" type="text" name="saddr" value="" />
                    <input type="hidden" name="daddr" value="<?php print $hotel_adresse['address'];?>" />
                    <button class="route-submit button button-350px button-red" type="submit">Routenplanung aufrufen</button>
                </form>
            </div>
        </div>
    <?php } ?>
<?php }


// Change the "order received" / Thank you page
add_filter('woocommerce_thankyou_order_received_text', function ($str, WC_Order $order) {
    $model = WooProduct::init();
    $hasEbookProducts = false;

    $str = '<img class="checkout-danke" style="margin: 0 auto;display: block;" alt="danke" title="danke" src="/uploads/celebrate.gif" data-no-lazy="1" /><h2 style="margin-top:30px;">Gratulation - Deine Weiterbildungsmaßnahme ist nun gebucht</h2>Vielen Dank, dass Du Dich für eine Weiterbildungsmaßnahme vom OMT angemeldet hast. Im Anschluss erhältst Du alle weiteren notwendigen Informationen per Email. Bei Fragen wende Dich gerne jederzeit an unser Team unter info@omt.de oder unter 06192 96 26 148';

    foreach ($order->get_items() as $item) {
        // Equal to
        if ($item['product_id'] == 201855) {
            $str = '<h2 class="no-margin-top">Vielen Dank für Deine Bestellung!</h2><p>Dein Guthaben wird automatisch innerhalb von ca. 5 Minuten nach Zahlungseingang Deinem Konto gutgeschrieben. <br><b><a target="_blank" class="button button-blue has-margin-top-30" href="/toolanbieter">Zurück zum Dashboard</a></b></p>';
        }

        $product = $model->getProduct($item['product_id']);

        if ($product instanceof WC_Product) {
            if ($model->isOmtMagazinProduct($product) || $model->isEbookProduct($product)) {
                if ($model->isEbookProduct($product)) {
                    $hasEbookProducts = true;
                }
    
                $str = "";
                break;
            }
        }
    }

    if ($hasEbookProducts && Order::hasDownloadableProducts($order) && !$order->has_status('completed')) {
        $str = '<h3 class="x-text-center" style="margin: auto">Vielen Dank für Deine Bestellung! Du erhälst in Kürze eine E-Mail mit dem Download-Link für Dein eBook</h3>';
    }

    return $str;
}, 10, 2);

//Re-order checkout form
add_filter("woocommerce_checkout_fields", "custom_override_checkout_fields", 1);
function custom_override_checkout_fields($fields) {
    $fields['billing']['billing_first_name']['priority'] = 1;
    $fields['billing']['billing_last_name']['priority'] = 2;
    $fields['billing']['billing_company']['priority'] = 3;
    $fields['billing']['billing_address_1']['priority'] = 6;
    $fields['billing']['billing_address_2']['priority'] = 7;
    $fields['billing']['billing_postcode']['priority'] = 8;
    $fields['billing']['billing_city']['priority'] = 9;
    $fields['billing']['billing_country']['priority'] = 10;
    $fields['billing']['billing_email']['priority'] = 11;
    $fields['billing']['billing_phone']['priority'] = 12;
    return $fields;
}
add_filter( 'woocommerce_billing_fields', 'wc_npr_filter_phone', 10, 1 );

function wc_npr_filter_phone( $address_fields ) {
    $address_fields['billing_phone']['required'] = true;
    return $address_fields;
}

add_filter( 'woocommerce_default_address_fields', 'custom_override_default_locale_fields' );
function custom_override_default_locale_fields( $fields ) {
    $fields['state']['priority'] = 5;
    $fields['address_1']['priority'] = 6;
    $fields['address_2']['priority'] = 7;
    return $fields;
}

//Neue Felder im Checkout hinzufügen
add_action('woocommerce_before_order_notes', 'customise_checkout_field');
function customise_checkout_field($checkout)
{       
    foreach( WC()->cart->get_cart() as $cart_item ){
        $product_id = $cart_item['product_id'];
    }
    $product_type = get_post_meta( $product_id, '_custom_product_type', true );
    
     switch ($product_type) {
        case 'Agenturfinder':
            break;
        case 'job':
            break;
        default:
            echo '<div id="customise_checkout_field" class="alternativer-teilnehmer ' . (!Checkout::displayParticipantFields() ? 'display-none' : '') . '"><hr style="margin:30px 0;"/><p class="button button-red">Falls der Teilnehmer vom Rechnungsempfänger abweicht, werden folgende Daten für den reibungslosen Ablauf des Events benötigt:</p>';
        
            woocommerce_form_field('teilnehmer_vorname', array(
                'type' => 'text',
                'class' => array(
                    'my-field-class form-row-wide'
                ) ,
                'label' => __('Teilnehmer Vorname') ,
                'placeholder' => __('Vorname') ,
                'required' => false,
            ) , $checkout->get_value('teilnehmer_vorname'));
        
            woocommerce_form_field('teilnehmer_nachname', array(
                'type' => 'text',
                'class' => array(
                    'my-field-class form-row-wide'
                ) ,
                'label' => __('Teilnehmer Nachname') ,
                'placeholder' => __('Nachname') ,
                'required' => false,
            ) , $checkout->get_value('teilnehmer_nachname'));
        
            woocommerce_form_field('teilnehmer_email', array(
                'type' => 'text',
                'class' => array(
                    'my-field-class form-row-wide'
                ) ,
                'label' => __('Teilnehmer Email') ,
                'placeholder' => __('E-Mail Adresse') ,
                'required' => false,
            ) , $checkout->get_value('teilnehmer_email'));
        
            echo "</div>";
        break;
    }
    echo '<hr style="margin:30px 0;"/>';

    // TODO: Old programmer code, NOT sure this is needed anymore
    // Old comment "20686 is ID for the if/else abfrage, only orders with this product ID will show the Tshirt"
    foreach (WC()->cart->get_cart_contents() as $product) {
        echo '<div id="customise_checkout_field" class="alternativer-teilnehmer display-none"><hr style="margin:30px 0;"/><p>Wir schenken Dir Dein persönliches OMT-Networking Polo mit eigenem Namen! Bitte gib uns Deine Größe (XS, S, M, L, XL, XXL)</p>';

        woocommerce_form_field('teilnehmer_shirtsize', array(
            'type' => 'text',
            'class' => array(
                'my-field-class form-row-wide'
            ) ,
            'label' => __('Teilnehmer Tshirt') ,
            'placeholder' => __('XS/S/M/L/XL/XXL') ,
            'required' => false,
        ) , $checkout->get_value('teilnehmer_shirtsize'));

        echo '<hr style="margin:30px 0;"/></div>';
    }
}

//save field data to order
/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['teilnehmer_email'] ) ) {
        update_post_meta( $order_id, 'Teilnehmer Email', sanitize_text_field( $_POST['teilnehmer_email'] ) );
    }
    if ( ! empty( $_POST['teilnehmer_vorname'] ) ) {
        update_post_meta( $order_id, 'Teilnehmer Vorname', sanitize_text_field( $_POST['teilnehmer_vorname'] ) );
    }
    if ( ! empty( $_POST['teilnehmer_nachname'] ) ) {
        update_post_meta( $order_id, 'Teilnehmer Nachname', sanitize_text_field( $_POST['teilnehmer_nachname'] ) );
    }
    if ( ! empty( $_POST['teilnehmer_shirtsize'] ) ) {
        update_post_meta( $order_id, 'Teilnehmer Tshirt', sanitize_text_field( $_POST['teilnehmer_shirtsize'] ) );
    }
}

//display custom fields in order admin
/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('Teilnehmer Email').':</strong> ' . get_post_meta( $order->id, 'Teilnehmer Email', true ) . '</p>';
    echo '<p><strong>'.__('Teilnehmer Vorname').':</strong> ' . get_post_meta( $order->id, 'Teilnehmer Vorname', true ) . '</p>';
    echo '<p><strong>'.__('Teilnehmer Nachname').':</strong> ' . get_post_meta( $order->id, 'Teilnehmer Nachname', true ) . '</p>';
    echo '<p><strong>'.__('Teilnehmer Tshirt').':</strong> ' . get_post_meta( $order->id, 'Teilnehmer Tshirt', true ) . '</p>';
}

//display those custom fields in my order email - DOESNT WORK YET!
/* To use:
1. Add this snippet to your theme's functions.php file
2. Change the meta key names in the snippet
3. Create a custom field in the order post - e.g. key = "Tracking Code" value = abcdefg
4. When next updating the status, or during any other event which emails the user, they will see this field in their email
add_filter( 'woocommerce_email_order_meta_fields', 'custom_woocommerce_email_order_meta_fields', 10, 3 );

function custom_woocommerce_email_order_meta_fields( $fields, $sent_to_admin, $order ) {
    $fields['teilnehmer_vorname'] = array(
        'label' => __( 'Teilnehmer Vorname' ),
        'value' => get_post_meta( $order->id, 'teilnehmer_vorname', true ),
    );
    $fields['teilnehmer_nachname'] = array(
        'label' => __( 'Teilnehmer Nachname' ),
        'value' => get_post_meta( $order->id, 'teilnehmer_nachname', true ),
    );
    $fields['teilnehmer_email'] = array(
        'label' => __( 'Teilnehmer Email' ),
        'value' => get_post_meta( $order->id, 'teilnehmer_email', true ),
    );
    return $fields;
}*/


/////Custom Checkout Box for requiring acceptance of nichtantrittsgebühren in case of no-show
/// https://wpquestions.com/Woocommerce_Checkout_Custom_fields_conditional_based_on_Gateway/10814
/// https://toolset.com/forums/topic/woocommerce-additional-custom-checkout-order-fields-conditional-by-product/
/// https://stackoverflow.com/questions/50766359/conditional-custom-checkout-fields-based-on-product-category-in-woocommerce
/// https://remicorson.com/customise-woocommerce-checkout-fields-based-on-products-in-cart/
/// https://wordpress.stackexchange.com/questions/263902/problem-with-conditional-woocommerce-custom-checkout-field
/// https://www.liquidweb.com/kb/way-conditionally-show-hide-checkout-fields-specific-products-product-categories-store/

add_action('woocommerce_after_checkout_billing_form', 'c_custom_checkout_field');
function c_custom_checkout_field( $checkout )
{
    foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
        
        $cart_product = $values['data'];
        $cart_ids[] = $cart_product->id;
        $product_id = $cart_product->id;
        $in_cart = false;
        $product_type = get_post_meta( $cart_product->id, '_custom_product_type', true );
        foreach( WC()->cart->get_cart() as $cart_item ) {
            //echo $cart_item['product_id'];
            if ( $product_type == 'agency day' OR $product_in_cart === 254476  OR  $product_in_cart === 254478  OR  $product_in_cart === 254479  ) {$in_cart = true;}
        }

        if ( $in_cart) {
                 echo '<div id="c_custom_checkout_field" class="hinweis-unkostenpauschale">';
                 woocommerce_form_field('c_type', array(
                     'type' => 'checkbox',
                     'class' => array('my-field-class form-row form-row-wide'),
                     'label' => __('Du akzeptierst, dass Deine E-Mail durch den OMT für Online-Marketing Zwecke erhoben, genutzt und zu diesem Zweck auch an die Sponsoren des Agency Days weitergegeben wird. Dir ist bekannt, dass Du Deine Werbeeinwilligung jederzeit und kostenlos durch eine E-Mail an info@omt.de widerrufen kannst. Im Fall des Widerruf bleibt die bis zum Widerruf erhaltene Werbung rechtmäßig. Weitergehende Informationen findest Du auf in unseren Datenschutzbestimmungen.'),
                     'placeholder' => __(''),
                     'required'  => true,
                 ), $checkout->get_value('c_type'));
                 echo '</div>';
        }
    }
    // if ($price < 1) {
    // }
}

add_action('woocommerce_checkout_process', 'c_custom_checkout_field_process');
function c_custom_checkout_field_process()
{
    foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
        $cart_product = $values['data'];
        $cart_ids[] = $cart_product->id;
        $price = $cart_product->get_price();
    }
//     if ($price < 1) {
// // Check if set, if its not set add an error.
//         if (!$_POST['c_type'])
//             wc_add_notice(__('Bitte akzeptiere den Hinweis zur Unkostenpauschale bei kurzfristiger Absage.'), 'error');

//     }
}
/////END OF Custom Checkout Box for requiring acceptance of nichtantrittsgebühren in case of no-show



// Product thumbnail in checkout
add_filter( 'woocommerce_cart_item_name', 'product_thumbnail_in_checkout', 20, 3 );
function product_thumbnail_in_checkout( $product_name, $cart_item, $cart_item_key ){
    if ( is_checkout() )
    {   
        $product_type = get_post_meta( $cart_item['product_id'], '_custom_product_type', true );
        //$thumbnail   = $cart_item['data']->get_image(array( 350, 180));
        if ($product_type == 'job') {
           echo '<style>.checkbox-recruiting_video{display:block !important;} .wc-gzd-product-name-left{display:none !important;}</style>';
        }elseif($product_type =='Agenturfinder'){
            $image_html  = '<div class="product-item-thumbnail"><img width="350" height="180" src="/uploads/2021/10/OMT-Liebe.jpg" class="woocommerce-placeholder wp-post-image" alt="Placeholder" loading="lazy" srcset="/uploads/2021/10/OMT-Liebe.jpg 350w, /uploads/2021/10/OMT-Liebe.jpg 290w" sizes="(max-width: 350px) 100vw, 350px"></div> ';
             echo '<style>.checkbox-recruiting_video{display:none !important;} .wc-gzd-product-name-left{display:none !important;}</style>';
        }else{
            echo '<style>.checkbox-recruiting_video{display:none !important;}</style>';
            $image_html  = '</style><div class="product-item-thumbnail">'.$cart_item['data']->get_image(array( 350, 180)).'</div> ';
        }
        $product_name = $image_html . $product_name;
    }
    return $product_name;
}

/**
 * @snippet       Cart subtotal slashed if coupon applied @ WooCommerce Cart
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=21879
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.1.2
 */

add_filter( 'woocommerce_cart_subtotal', 'bbloomer_slash_cart_subtotal_if_discount', 99, 3 );

function bbloomer_slash_cart_subtotal_if_discount( ){
    global $woocommerce;
    $unformatted  = WC()->cart->subtotal_ex_tax;
    $price_only = number_format($unformatted, 2, ",", ".");
    $cart_subtotal = '<span class="subtotal"> ' . $price_only . '</span><span class="woocommerce-Price-currencySymbol"> €</span>';
    return $cart_subtotal;
}

/*****************************************/
/*****************************************/
/*****************************************/
////add a column in woocommerce orders table
add_filter( 'manage_edit-shop_order_columns', 'add_columns_to_orders' );
function add_columns_to_orders( $columns ) {
    $new_columns = ( is_array( $columns ) ) ? $columns : array();
    unset( $new_columns[ 'order_actions' ] );

    //edit this for your column(s)
    //all of your columns will be added before the actions column
    $new_columns['order_invoice_number'] = 'Rechnungs-Nr.';
    //$new_columns['MY_COLUMN_ID_2'] = 'MY_COLUMN_2_TITLE';
    //stop editing
    return $new_columns;
}
////////Put DATA into the new column(s)
add_action( 'manage_shop_order_posts_custom_column', 'invoice_column_values', 2 );
function invoice_column_values( $column ) {
    global $post;
    $data = get_post_meta( $post->ID );
    //start editing, I was saving my fields for the orders as custom post meta
    //if you did the same, follow this code

    if ( $column == 'order_invoice_number' ) {
        // Get invoice
        $order = wc_get_order( $post->ID );
        $invoices = wc_gzdp_get_invoices_by_order( $order, 'simple' );
        if (!empty($invoices)) {
            if ( ! empty( $invoices ) ) {
                foreach ($invoices as $invoice) {
                    $subject = $invoice->formatted_number;
                    print str_replace(": ", "", $subject);
                }
            }
        }
    }
}


////Lade Woocommerce Ressourcen nur auf Woocommerce pages!
add_action( 'wp_enqueue_scripts', 'optimiere_woocommerce' );
function optimiere_woocommerce() {

    // Ist das Woocommerce Plugin aktiviert?
    if( function_exists( 'is_woocommerce' ) ){

        // Befinden wir uns auf einer Woocommerce Seite?
        if(! is_woocommerce() && ! is_cart() && ! is_checkout() ) {

            ## Woocommerce CSS deaktivieren
            wp_dequeue_style('woocommerce-layout');
            wp_dequeue_style('woocommerce-general');
            wp_dequeue_style('woocommerce-smallscreen');
            wp_dequeue_style('woocommerce-gzd-layout'); //germanized style entfernen

            ## Woocommerce Skripte Deaktivieren
            wp_dequeue_script('wc-cart-fragments');
            wp_dequeue_script('woocommerce');
            wp_dequeue_script('wc-add-to-cart');

            wp_deregister_script( 'js-cookie' );
            wp_dequeue_script( 'js-cookie' );

        }
    }
}

add_action('wp_enqueue_scripts', function () {
    if (is_checkout()) {
        // On WooCommerce checkout page/shortcodes "$" function is overridden by jQuery.noConflict()
        // In file /wp-content/plugins/flexible-checkout-fields-pro/assets/js/front.min.js
        // Add "$" backward compatibility for custom scripts
        wp_enqueue_script('jquery-no-conflict', get_stylesheet_directory_uri() . '/library/js/jquery-no-conflict.js', ['inspire_checkout_fields_front_pro_js']);
    }
});

add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );
add_filter( 'woocommerce_is_attribute_in_product_name', '__return_false' );

///CUSTOM FIELD ZUR VARIATION HINZUFÜGEN: Lagerbestand Maximal
require_once("woocommerce-add-customfield-stockmax.php");

///CUSTOM FIELD ZUR VARIATION HINZUFÜGEN: Zugehörige Offline-ID (für Hybrid-Seminare notwendig)
require_once("woocommerce-add-customfield-offline-id.php");

///CUSTOM FIELD ZUR VARIATION HINZUFÜGEN: Zugehörige Online-ID (für Hybrid-Seminare notwendig)
require_once("woocommerce-add-customfield-online-id.php");

///CUSTOM FIELD ZUR VARIATION HINZUFÜGEN: ProduktAktivieren
//require_once("woocommerce-add-customfield-activate.php");

// Manage "WooCommerce Subscriptions"
require_once("woocommerce-subscriptions.php");

// Manage WooCommerce for "OMT Magazin" products
require_once("woocommerce-omt-magazin.php");

//push guthabenaufladung into database when paid (=processing)
function mysite_woocommerce_payment_complete( $order_id )
{
    $toolorder = wc_get_order($order_id);
    $user = $toolorder->get_user();
    $user_id = $toolorder->get_user_id();
    $guthabenaufladung = false;
    $total = 0;
    $items = $toolorder->get_items();
    $order_time = $toolorder->get_date_modified();
    foreach ($items as $item_id => $item) {
        $product_id = $item->get_variation_id() ? $item->get_variation_id() : $item->get_product_id();
        //   $product_name = $item->get_title();
        $parent_id = wp_get_post_parent_id($product_id);
        if ($product_id === 201855) {
            $guthabenaufladung = true;
            $total = $toolorder->get_subtotal();

            ////WRITE ORDER VALUE INTO SQL:
            // SQL CONNECTION COMES FIRWST
            $conn = new mysqli(DATAHOST_DB_HOST, DATAHOST_DB_USER, DATAHOST_DB_PASSWORD, DATAHOST_DB_NAME);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            //END OF SQL CONNECTION + TEST

            $sql = "INSERT INTO omt_einzahlungen (user_id, betrag, order_time, woocommerce_order_id, gutschein)
            VALUES ('$user_id', '$total', '$order_time', '$order_id', '')";
            if ($conn->query($sql) === TRUE) {
                //    echo "New tool record created or updated successfully";
            } else {
                // echo "Error: " . $sql . "<br>" . $conn->error;
            }

//
//    $to = "christos.pipsos@omt.de";
//    $subject = 'Toolanbieter Guthabenbestellung beim OMT bezahlt';
//    $body = 'The email body content';
//    // Get user data by user id
//    $user = get_userdata( $user_id );
//    // Get display name from user object
//    $display_name = $user->display_name;
//    if (true == $guthabenaufladung) {
//        $body = "<h1>Guthabenbestellung im Toolanbieter Backend wurde bezahlt:</h1><hr/><table><tbody><tr><td>Bestellnummer: </td><td>" . $order_id . "</td><td>Nutzer:</td><td>" . $display_name . "</td><td>Summe:</td><td>" . $total . "</td></tr></tbody></table>";
//        $headers = array('Content-Type: text/html; charset=UTF-8', 'CC: daniel.voelskow@reachx.de');
//        wp_mail($to, $subject, $body, $headers);
//    }
            //END OF DATABASE UPDATE
            //CREATE EMAIL INFORMATION
            $user = get_userdata($user_id);
            // Get display name from user object
            $user_login = $user->user_login;
            $user_email = $user->user_email;
            $to = $user_email;
            $subject = 'OMT ToolAds: Dein Guthaben wurde aufgeladen';
            $body = "<h1>Vielen Dank für Deine Bestellung beim OMT:</h1><hr/><table><tbody><tr><td>Bestellnummer: </td><td>" . $order_id . "</td></tr><tr><td>Nutzer:</td><td>" . $user_login . "</td></tr><tr><td>Summe:</td><td>" . $total . "€</td></tr></tbody></table><h3>Das Guthaben wurde Deinem Account gutgeschrieben und ist ab sofort nutzbar.</h3><a href='https://www.omt.de/toolanbieter/'>Jetzt einloggen</a>";
            //$headers = array('Content-Type: text/html; charset=UTF-8');
            $headers = "From: info@omt.de\r\n";
            $headers .= "Reply-To: info@omt.de\r\n";
            $headers .= "CC: info@omt.de\r\n";
            $headers .= "CC: christos.pipsos@omt.de\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            wp_mail($to, $subject, $body, $headers);
            print "Guthabenbenachrichtigung sent";
        }
        /* if ( ( 244114 == $parent_id ) OR (240285 == $product_id ) ) //if magazin printausgabe has been ordered. Checking if it will work with the main product id or we need variation ids?
         {
             $data  = $toolorder->get_data(); // The Order data
             ## BILLING INFORMATION:
             $billing_email      = $data['billing']['email'];
             $billing_phone      = $data['billing']['phone'];

             $billing_first_name = $data['billing']['first_name'];
             $billing_last_name  = $data['billing']['last_name'];
             $billing_company    = $data['billing']['company'];
             $billing_address_1  = $data['billing']['address_1'];
             $billing_address_2  = $data['billing']['address_2'];
             $billing_city       = $data['billing']['city'];
             $billing_state      = $data['billing']['state'];
             $billing_postcode   = $data['billing']['postcode'];
             $billing_country    = $data['billing']['country'];

             ## SHIPPING INFORMATION:
             $shipping_first_name = $data['shipping']['first_name'];
             $shipping_last_name  = $data['shipping']['last_name'];
             $shipping_company    = $data['shipping']['company'];
             $shipping_address_1  = $data['shipping']['address_1'];
             $shipping_address_2  = $data['shipping']['address_2'];
             $shipping_city       = $data['shipping']['city'];
             $shipping_state      = $data['shipping']['state'];
             $shipping_postcode   = $data['shipping']['postcode'];
             $shipping_country    = $data['shipping']['country'];
             $to = "daniel.voelskow@reachx.de";
             $subject = "OMT Magazinbestellung: " . $product_name;
             $body ="<h1>Magazin Bestelldaten:</h1>";
             $body .="<h2>Produkt: " . $product_name . "</h2>";
             $body .="<h2>Rechnungsinformationen:</h2>";
             $body .= "<table>";
             $body .= "<tr><td>Vorname:</td><td>" . $billing_first_name . "</td></tr>";
             $body .= "<tr><td>Nachname:</td><td>" . $billing_last_name . "</td></tr>";
             $body .= "<tr><td>Firma:</td><td>" . $billing_company . "</td></tr>";
             $body .= "<tr><td>Adresszeile 1:</td><td>" . $billing_address_1 . "</td></tr>";
             $body .= "<tr><td>Adresszeile 2:</td><td>" . $billing_address_2 . "</td></tr>";
             $body .= "<tr><td>Stadt:</td><td>" . $billing_city . "</td></tr>";
             $body .= "<tr><td>Bundesland:</td><td>" . $billing_state . "</td></tr>";
             $body .= "<tr><td>Postleitzahl:</td><td>" . $billing_postcode . "</td></tr>";
             $body .= "<tr><td>Land:</td><td>" . $billing_country . "</td></tr>";
             $body .= "</table>";
             $body .="<h2>Versandinformationen (falls von Rechnung abweichend):</h2>";
             $body .= "<table>";
             $body .= "<tr><td>Vorname:</td><td>" . $shipping_first_name . "</td></tr>";
             $body .= "<tr><td>Nachname:</td><td>" . $shipping_last_name . "</td></tr>";
             $body .= "<tr><td>Firma:</td><td>" . $shipping_company . "</td></tr>";
             $body .= "<tr><td>Adresszeile 1:</td><td>" . $shipping_address_1 . "</td></tr>";
             $body .= "<tr><td>Adresszeile 2:</td><td>" . $shipping_address_2 . "</td></tr>";
             $body .= "<tr><td>Stadt:</td><td>" . $shipping_city . "</td></tr>";
             $body .= "<tr><td>Bundesland:</td><td>" . $shipping_state . "</td></tr>";
             $body .= "<tr><td>Postleitzahl:</td><td>" . $shipping_postcode . "</td></tr>";
             $body .= "<tr><td>Land:</td><td>" . $shipping_country . "</td></tr>";
             $body .= "</table>";
             $headers = "From: info@omt.de\r\n";
             $headers .= "Reply-To: info@omt.de\r\n";
             $headers .= "MIME-Version: 1.0\r\n";
             $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
             wp_mail($to, $subject, $body, $headers);
         }*/
    }
}
//add_action( 'woocommerce_order_status_processing', 'mysite_woocommerce_payment_complete', 10, 1 );
add_action( 'woocommerce_order_status_completed', 'mysite_woocommerce_payment_complete', 10, 1 );

/**
 * @snippet       Programmatically Complete Paid WooCommerce Orders
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.8
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

add_filter( 'woocommerce_payment_complete_order_status', 'bbloomer_autocomplete_processing_orders', 9999 );

function bbloomer_autocomplete_processing_orders() {
    return 'completed';
}

////Send Email on New Guthabenaufladungs-Order
function new_guthaben_order( $order_id ) {
    $toolorder = wc_get_order( $order_id );
    $user = $toolorder->get_user();
    $user_id = $toolorder->get_user_id();
    $order_status  = $toolorder->get_status(); // Get the order status (see the conditional method has_status() below)
    $currency      = $toolorder->get_currency(); // Get the currency used
    $payment_method = $toolorder->get_payment_method(); // Get the payment method ID
    $payment_title = $toolorder->get_payment_method_title(); // Get the payment method title
    $date_created  = $toolorder->get_date_created(); // Get date created (WC_DateTime object)
    $date_modified = $toolorder->get_date_modified(); // Get date modified (WC_DateTime object)
    $guthabenaufladung = false;
    $total = 0;
    $items = $toolorder->get_items();
    $order_time = $toolorder->get_date_modified();
    foreach ( $items as $item_id => $item ) {
        $product_id = $item->get_variation_id() ? $item->get_variation_id() : $item->get_product_id();
        if ( $product_id === 201855 ) {
            $guthabenaufladung = true;
            $total = $toolorder->get_subtotal();
        }
    }
    if (true == $guthabenaufladung) {
        //CREATE EMAIL INFORMATION
        $to = "christos.pipsos@omt.de";
        $subject = 'Toolanbieter Guthabenbestellung beim OMT';

        // Get user data by user id
        $user = get_userdata( $user_id );
        // Get display name from user object
        $display_name = $user->display_name;
        if (true == $guthabenaufladung) {
            $tools = [];
            foreach (User::init()->tools($user->ID) as $tool) {
                array_push($tools, '<a href="' . get_the_permalink($tool) . '">' . get_the_title($tool) . '</a>');
            }

            $body = "<h1>Guthabenbestellung im Toolanbieter Backend:</h1><hr/><ul><li>Bestellnummer: " . $order_id . "</li><li>Zahlungsmethode: " . $payment_method . "</li><li>Nutzer: " . $display_name . "</li><li>Summe: " . $total . "</li><li>Tool: " . implode(', ', $tools) . "</li></ul>";
            $headers = array('Content-Type: text/html; charset=UTF-8', 'CC: daniel.voelskow@reachx.de', 'CC: mario@omt.de');
            wp_mail($to, $subject, $body, $headers);
        }
    }
}
add_action( 'woocommerce_thankyou', 'new_guthaben_order', 10, 1 );

////CHECK IF A CERTAIN COUNPON HAS BEEN APPLIED, IF S ADD CUSTOM UPLOAD FIELD TO CHECKOUT!
add_action('woocommerce_applied_coupon', 'apply_product_on_coupon');
function apply_product_on_coupon( )
{
    global $woocommerce;
    $coupon_id = 'omt_koschstudent';
    $coupon_id2 = 'omt2020_othregensburg';
    $free_product_id = 206150;

    if (in_array($coupon_id, $woocommerce->cart->get_applied_coupons())) { //if coupon with this code is applied in my cart:
        $woocommerce->cart->add_to_cart($free_product_id, 1);
    }
    if (in_array($coupon_id2, $woocommerce->cart->get_applied_coupons())) { //if coupon with this code is applied in my cart:
        $woocommerce->cart->add_to_cart($free_product_id, 1);
    }
}

/**
 * Hide WooCommerce shipping name in checkout
 */
add_filter('woocommerce_cart_shipping_method_full_label', function ($label, $method) {
    if ($method->cost == 0) {
        $label = str_replace($method->get_label(), __('Free Shipping', 'woocommerce'), $label);
    } else {
        $label = str_replace([$method->get_label(), ':'], '', $label);
    }

    return $label;
}, 10, 2);

/**
 * Disable "Rechnung" payment method for non-administrator users and products "OMT Magazin Printausgabe" / "eBook"
 */
add_filter('woocommerce_available_payment_gateways', function ($payments) {
    if (is_admin()) {
        return $payments;
    }

    if (Checkout::disableInvoicePaymentMethod()) {
        unset($payments['invoice']);
    }

    return $payments;
});

/**
 * Enable "Completed order" emails notifications for "Downloadable products"
 */
add_filter('woocommerce_email_enabled_customer_completed_order', function ($enabled, $order, $object) {
    if ($order instanceof WC_Order && Order::hasDownloadableProducts($order)) {
        return true;
    }

    return $enabled;
}, 10, 3);

/**
 * Switch order to "Completed" if it contains "Downloadable products" and payments are "stripe_sepa" or "stripe_sofort"
 */
add_action('woocommerce_order_status_on-hold', function ($order_id, $order) {
    if ($order instanceof WC_Order && Order::hasDownloadableProducts($order) && in_array($order->get_payment_method(), ['stripe_sepa', 'stripe_sofort'])) {
        $order->update_status('completed', 'Order status changed automatically for downloadable product and gateways "SEPA-Lastschrift/SOFORT"');
    }
}, 10, 2);

/**
 * Fix [Embed Checkout]
 * Clear WooCommerce Cart for "eBooks" and "OMT Magazin" on "on loaded" Wordpress, after WC_Cart_Session::get_cart_from_session()
 * Clear here because in template "single-omt_ebook" cause problems with session
 * 
 * Products will be added later in templates 
 */
add_action('wp_loaded', function () {
    if (preg_match('/\/downloads\/ebooks\/.+/', $_SERVER['REQUEST_URI'], $matches) || preg_match('/\/downloads\/magazin\/.+/', $_SERVER['REQUEST_URI'], $matches)) {
        WooCart::init()->clear();

        if (!is_user_logged_in() || wp_get_current_user()->ID !== WC()->customer->get_id()) {
            add_filter('woocommerce_checkout_get_value', '__return_empty_string', 10);
        }
    }
}, 11);

/**
 * Fix Paypal IPN error caused by redirection from POST "/wc-api/WC_Gateway_Paypal" to GET "/wc-api/wc_gateway_paypal"
 * Installed plugin "WP Force Lowercase URLs" redirect Notify POST request from Paypal
 */
add_filter('woocommerce_api_request_url', function ($api_request_url, $request, $ssl) {
    if (strpos($api_request_url, 'WC_Gateway_Paypal') !== false) {
        $api_request_url = strtolower($api_request_url);
    }

    return $api_request_url;
}, 10, 3);



add_filter( 'allowed_block_types', 'misha_allow_2_woo_blocks' );

function misha_allow_2_woo_blocks( $allowed_blocks ){

    $allowed_blocks = array(
    );

    return $allowed_blocks;

}







/*---------------------------------- custom fields for agenturfinder ---------------------------------*/

add_action( 'woocommerce_variation_options_pricing', 'omt_add_product_class_to_variations', 10, 3 );
 
function omt_add_product_class_to_variations( $loop, $variation_data, $variation ) {
   woocommerce_wp_text_input( array(
'id' => 'product_class[' . $loop . ']',
'class' => 'short',
'label' => __( 'Product Variation Class', 'woocommerce' ),
'value' => get_post_meta( $variation->ID, 'product_class', true )
   ) );
}
 
// -----------------------------------------
// 2. Save custom field on product variation save
 
add_action( 'woocommerce_save_product_variation', 'omt_save_product_class_variations', 10, 2 );
 
function omt_save_product_class_variations( $variation_id, $i ) {
   $product_class = $_POST['product_class'][$i];
   if ( isset( $product_class ) ) update_post_meta( $variation_id, 'product_class', esc_attr( $product_class ) );
}
 
// -----------------------------------------
// 3. Store custom field value into variation data
 
add_filter( 'woocommerce_available_variation', 'omt_add_custom_field_variation_data' );
 
function omt_add_custom_field_variation_data( $variations ) {
   $variations['product_class'] = '<div class="woocommerce_custom_field">Prodact variation Class: <span>' . get_post_meta( $variations[ 'variation_id' ], 'product_class', true ) . '</span></div>';
   return $variations;
}






add_action( 'woocommerce_variation_options_pricing', 'omt_add_m_price_to_variations', 10, 3 );
 
function omt_add_m_price_to_variations( $loop, $variation_data, $variation ) {
   woocommerce_wp_text_input( array(
'id' => 'monthly_price[' . $loop . ']',
'class' => 'short',
'label' => __( 'Monthly Price', 'woocommerce' ),
'value' => get_post_meta( $variation->ID, 'monthly_price', true )
   ) );
}
 
// -----------------------------------------
// 2. Save custom field on product variation save
 
add_action( 'woocommerce_save_product_variation', 'omt_save_m_price_variations', 10, 2 );
 
function omt_save_m_price_variations( $variation_id, $i ) {
   $monthly_price = $_POST['monthly_price'][$i];
   if ( isset( $monthly_price ) ) update_post_meta( $variation_id, 'monthly_price', esc_attr( $monthly_price ) );
}
 
// -----------------------------------------
// 3. Store custom field value into variation data
 
add_filter( 'woocommerce_available_variation', 'omt_add_m_price_variation_data' );
 
function omt_add_m_price_variation_data( $variations ) {
   $variations['monthly_price'] = '<div class="woocommerce_custom_field">Monthly Price: <span>' . get_post_meta( $variations[ 'variation_id' ], 'monthly_price', true ) . '</span></div>';
   return $variations;
}





add_action( 'woocommerce_variation_options_pricing', 'omt_add_fraction_to_variations', 10, 3 );
 
function omt_add_fraction_to_variations( $loop, $variation_data, $variation ) {
   woocommerce_wp_text_input( array(
'id' => 'fraction[' . $loop . ']',
'class' => 'short',
'label' => __( 'Fraction', 'woocommerce' ),
'value' => get_post_meta( $variation->ID, 'fraction', true )
   ) );
}
 
// -----------------------------------------
// 2. Save custom field on product variation save
 
add_action( 'woocommerce_save_product_variation', 'omt_save_fraction_variations', 10, 2 );
 
function omt_save_fraction_variations( $variation_id, $i ) {
   $fraction = $_POST['fraction'][$i];
   if ( isset( $fraction ) ) update_post_meta( $variation_id, 'fraction', esc_attr( $fraction ) );
}
 
// -----------------------------------------
// 3. Store custom field value into variation data
 
add_filter( 'woocommerce_available_variation', 'omt_add_fraction_variation_data' );
 
function omt_add_fraction_variation_data( $variations ) {
   $variations['fraction'] = '<div class="woocommerce_custom_field">Fraction: <span>' . get_post_meta( $variations[ 'variation_id' ], 'fraction', true ) . '</span></div>';
   return $variations;
}





add_action( 'woocommerce_variation_options_pricing', 'omt_add_var_title_variations', 10, 3 );
 
function omt_add_var_title_variations( $loop, $variation_data, $variation ) {
   woocommerce_wp_text_input( array(
'id' => 'variation_title[' . $loop . ']',
'class' => 'short',
'label' => __( 'Variation Title', 'woocommerce' ),
'value' => get_post_meta( $variation->ID, 'variation_title', true )
   ) );
}
 
// -----------------------------------------
// 2. Save custom field on product variation save
 
add_action( 'woocommerce_save_product_variation', 'omt_save_var_title_variations', 10, 2 );
 
function omt_save_var_title_variations( $variation_id, $i ) {
   $variation_title = $_POST['variation_title'][$i];
   if ( isset( $variation_title ) ) update_post_meta( $variation_id, 'variation_title', esc_attr( $variation_title ) );
}
 
// -----------------------------------------
// 3. Store custom field value into variation data
 
add_filter( 'woocommerce_available_variation', 'omt_add_var_variation_data' );
 
function omt_add_var_variation_data( $variations ) {
   $variations['variation_title'] = '<div class="woocommerce_custom_field">Variation Title: <span>' . get_post_meta( $variations[ 'variation_id' ], 'variation_title', true ) . '</span></div>';
   return $variations;
}


/*---------------------------------- custom fields for agenturfinder /---------------------------------*/