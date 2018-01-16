<?php  


// function included
include_once('functions/scritpts-functions.php'); 
include_once('functions/wp_login_form_show-functions.php'); 
include_once('functions/registry_form_show-functions.php');
include_once('functions/registry_save_ajax-function.php');
include_once('functions/after_add_cart-functions.php'); 
// include_once('functions/after_buy-function.php');

// function Shortcodes
 
add_shortcode( 'wedding_giftregistry', 'wp_login_form_show' );
add_shortcode( 'wedding_giftregistry_form', 'registry_form_show' );

 
//function Actions
add_action('wp_enqueue_scripts', 'my_load_scripts'); 
add_action( 'wp_ajax_my_action', 'my_action' );
add_action( 'wp_ajax_nopriv_my_action', 'my_action' );  
add_action( 'woocommerce_after_add_to_cart_button', 'add_content_after_addtocart_button_func' );

  
 
add_action('woocommerce_order_status_completed', 'process_payment');
 
    function process_payment($order_id){
        global $wpdb;
        global $woocommerce;

        $wedding_registry_item = $wpdb->prefix."wedding_registry_item";
 
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            
              
            $whishlisID = $cart_item['whishlisID']; 
            $prodID = $cart_item['product_id']; 
            $varID = $cart_item['variation_id']; 
            $quantity = $cart_item['quantity']; 


            $productcheck = $wpdb->get_row( "SELECT received_qty FROM $wedding_registry_item  WHERE wish_id =$whishlisID AND product_id=$prodID", ARRAY_A);
            
            $productcheck_qty= $productcheck['received_qty'];
            
            error_log($productcheck_qty);

            $wpdb->query($wpdb->prepare( "UPDATE $wedding_registry_item SET received_qty=CONCAT($quantity+$productcheck_qty)  WHERE wish_id=$whishlisID AND variation_id=$varID AND product_id=$prodID"));
            
            // $wpdb->query($wpdb->prepare( "UPDATE $wedding_registry_item SET quantity=$quantities  WHERE wish_id=$buy_prof_id AND variation_id=$variation_id AND product_id=$product_id"));
            
            // $wpdb->update( 
            //     $wedding_registry_item, 
            //     array( 
            //         'received_qty' => $quantity,	// string
            //      ), 
            //     array( 'wish_id' => $whishlisID,
            //             'variation_id' => $varID,
            //             'product_id' =>$prodID,
            //          ), 
            //     array( 
            //          '%d'	// value2
                      
            //     ), 
            //     array( '%d','%d','%d' ) 
            // );
    
        }

       
         

       
    }

?>