<?php  


// function included
include_once('functions/scritpts-functions.php'); 
include_once('functions/wp_login_form_show-functions.php'); 
include_once('functions/registry_form_show-functions.php');
include_once('functions/registry_save_ajax-function.php');
include_once('functions/after_add_cart-functions.php');


// function Shortcodes
 
add_shortcode( 'wedding_giftregistry', 'wp_login_form_show' );
add_shortcode( 'wedding_giftregistry_form', 'registry_form_show' );

 

//function Actions
add_action('wp_enqueue_scripts', 'my_load_scripts'); 
add_action( 'wp_ajax_my_action', 'my_action' );
add_action( 'wp_ajax_nopriv_my_action', 'my_action' );  
add_action( 'woocommerce_after_add_to_cart_button', 'add_content_after_addtocart_button_func' );

add_action( 'woocommerce_after_shop_loop_item', 'add_content_after_addtocart_button_func' );


?>