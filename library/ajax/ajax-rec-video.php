<?php
function omt_rec_video()
{
    /**
     * Default response
     */
    $response = [
        'status' => 500,
        'message' => 'Something is wrong, please try again later ...',
        'content' => false,
        'found' => 0
    ];
    ob_start();
    function my_scripts_method(){
        wp_enqueue_script( 'jquery' );
    }
    add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
    
    //Getting value from recruiting video checkbox.
    $video = $_POST['video'];

    //Checking if checkbox is checked
    if($video == 1):
        global $woocommerce;
        foreach( $woocommerce->cart->get_cart() as $cart_item ){
            $parent_id = $cart_item['product_id'];
        }
        $products_in_cart = array();
        $cart_items =  WC()->cart->get_cart();
        foreach( $cart_items as $cart_item ){
            if ($cart_item['product_id'] == $parent_id) {
                $product_id = $cart_item['variation_id']; // possibly array('attribute_pa_color'=>'black')
                if (!isset($_COOKIE['cur_product'])) {
                    setcookie('cur_product', $product_id, strtotime('+1 day'));//Sorting current product in cookies for reverse action
                }
                $woocommerce->cart->add_to_cart( 325836 );//Adding recruting video product in cart
                break;
            }
        }
    elseif($video == 0):
        global $woocommerce;
        $saved_product = $_COOKIE['cur_product'];//geting value 
        foreach( $woocommerce->cart->get_cart() as $cart_item ){
            $product_id = $cart_item['product_id'];
            wc()->cart->empty_cart();// clearing cart from recruiting video product
            $woocommerce->cart->add_to_cart( $saved_product );// reversing old product to cart
            setcookie('cur_product', null, strtotime('-1 day'));//reseting cookies
            break;
        }
    endif;
    

    $response = [
        'status' => 200,
        'message' => 'Works',
        'content' => true,      
    ];


    wp_reset_postdata();
    die(json_encode($response));
}

add_action('wp_ajax_do_rec_video', 'omt_rec_video');
add_action('wp_ajax_nopriv_do_rec_video', 'omt_rec_video');

