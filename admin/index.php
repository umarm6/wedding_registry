<?php  

// Added To Dash Board Menu
    add_action( 'admin_menu', 'Menu_registry' ); 

    function Menu_registry(){ 
        
        
    $page_title = 'Wedding Gift Registry';
    $menu_title = 'Wedding Gift Registry';
    $capability = 'manage_options';
    $menu_slug  = 'wedding-gift-registry';
    $function   = 'wedding_gift_registry';
    $icon_url   = 'dashicons-id';
    $position   = 9;

    add_menu_page( $page_title,
                    $menu_title, 
                    $capability, 
                    $menu_slug, 
                    $function, 
                    $icon_url, 
                    $position );
                    

                    
    }     
    




 /* Add custom menu item and endpoint to WooCommerce My-Account page */

function my_custom_endpoints() {
    add_rewrite_endpoint( 'edit-registry', EP_ROOT | EP_PAGES );
}

add_action( 'init', 'my_custom_endpoints' );

function my_custom_query_vars( $vars ) {
    $vars[] = 'edit-registry';

    return $vars;
}

add_filter( 'query_vars', 'my_custom_query_vars', 0 );

function my_custom_flush_rewrite_rules() {
    flush_rewrite_rules();
}

add_action( 'init', 'my_custom_flush_rewrite_rules' );

function my_custom_my_account_menu_items( $items ) {
    $items = array(
        'dashboard'         => __( 'Dashboard', 'woocommerce' ),
        'edit-registry'      => __( 'Edit Registry', 'woocommerce' ),     
        'orders'            => __( 'Orders', 'woocommerce' ),
        'downloads'       => __( 'Downloads', 'woocommerce' ),
        'edit-address'    => __( 'Addresses', 'woocommerce' ),
        //'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
        'edit-account'      => __( 'Edit Account', 'woocommerce' ),
        'customer-logout'   => __( 'Logout', 'woocommerce' ),
    );

    return $items;
}

add_filter( 'woocommerce_account_menu_items', 'my_custom_my_account_menu_items' );

function my_custom_endpoint_content() {
 
do_shortcode('[wedding_giftregistry_form]');
}

add_action( 'woocommerce_account_edit-registry_endpoint', 'my_custom_endpoint_content' );





// Added To Dash Board Menu Content
 
    function wedding_gift_registry(){
        global $wpdb;
    
        echo '<h3 class="pt-5 pb-3">Wedding Gift Registrants</h3>'; 
    // check if WooCommerce is activated
    
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        
        ?> 
    
    <section>
        <table class="table text-center">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Username</th>
                <th scope="col">View</th>
                <th scope="col">Delete</th> 
                </tr>
            </thead>
            <tbody>

                <?php	function getUsers(){
                    global $wpdb;  
                    $prefix= $wpdb->prefix;
                    $table = $prefix."wedding_registry_wishlists"; 
                    
                    $results = $wpdb->get_results( 'SELECT * FROM '.$table.'', OBJECT );

                    foreach ( $results as $Users ){
                    $wId= $Users->id;
                    $groom_FirstName= $Users->goorm_firstname;
                    $bride_LastName= $Users->bride_lastname; 
                    $message= $Users->message; 
                    
                    echo'<th scope="row">'.$wId.
                     '</th>
                        <td>'.$groom_FirstName.'</td>
                        <td>'.$bride_LastName.'</td>
                        <td>'.$message.'</td> 
                        <td><a href=""><i class="fa fa-eye" aria-hidden="true"></i> 	</a></td>
                        <td class="table-danger"><a href="" ><i class="fa fa-trash" aria-hidden="true"></i>
                        </a></td>
                        </tr>   ';
                    }
                }

                getUsers();
                ?>

            </tbody>
        </table>
    
    </section>
        
        <?php
            
        } else {
            echo '
            <div class="alert alert-danger" role="alert">
            Please Install WooCommerce
        </div>
        ';
        }
            
    }


  // Add Styles To Admin  
    function my_admin_theme_style() {

        wp_enqueue_style('my-admin-theme', plugins_url('css/wedding-gift-registry-admin.css', __FILE__));
        wp_enqueue_style('my-admin-bootstrap', plugins_url('css/bootstrap.min.css', __FILE__));
        wp_enqueue_style('font-awesome', plugins_url('css/font-awesome.min.css', __FILE__));
        wp_enqueue_style('modal', plugins_url('css/jquery.modal.min.css', __FILE__));
        
         
        wp_enqueue_script('my-admin-jquery-js', plugins_url('js/jquery.min.js', __FILE__));  
        wp_enqueue_script('my-admin-popper-js',plugins_url('js/popper.min.js', __FILE__));   	
        wp_enqueue_script('my-admin-bootstrap-js', plugins_url('js/bootstrap.min.js', __FILE__)); 	 	
        wp_enqueue_script('my-admin-theme-js', plugins_url('js/wedding-gift-registry-admin.js', __FILE__));
        wp_enqueue_script('my-admin-modal-js', plugins_url('js/modal.min.js', __FILE__));
        
         
         
    }
	add_action('admin_enqueue_scripts', 'my_admin_theme_style');
	add_action('login_enqueue_scripts', 'my_admin_theme_style'); 


    

    
?>