<?php  

// Add Styles To Admin  
function my_admin_theme_style() {
    
            wp_enqueue_style('my-admin-theme', plugins_url('css/wedding-gift-registry-admin.css', __FILE__));
            wp_enqueue_style('my-admin-bootstrap', plugins_url('css/bootstrap.min.css', __FILE__));
            wp_enqueue_style('font-awesome', plugins_url('css/font-awesome.min.css', __FILE__));
            wp_enqueue_style( 'jquery-ui', plugins_url('css/jquery-ui.min.css', __FILE__), false, '1.0.0', 'all');   
            
            // wp_enqueue_style('modal', plugins_url('css/jquery.modal.min.css', __FILE__));
            
             
            wp_enqueue_script('my-admin-jquery-js', plugins_url('js/jquery.min.js', __FILE__));  
            wp_enqueue_script('my-admin-popper-js',plugins_url('js/popper.min.js', __FILE__));   	
            wp_enqueue_script( 'bootstraps', plugins_url( 'js/bootstrap_2.min.js', __FILE__ ), false, '4.0.0', 'all'); 
            wp_enqueue_script( 'notify', plugins_url( '/js/notify.min.js', __FILE__ ), false, '4.0.0', 'all'); 
          wp_enqueue_script( 'bootbox', plugins_url( '/js/bootbox.min.js', __FILE__ ), false, '4.0.0', 'all'); 
            wp_enqueue_script('my-admin-theme-js', plugins_url('js/wedding-gift-registry-admin.js', __FILE__));
    
    
             
             
             
        }
        add_action('admin_enqueue_scripts', 'my_admin_theme_style');
        add_action('login_enqueue_scripts', 'my_admin_theme_style'); 
    
    
        

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
    <script>
    jQuery(document).ready(function(){
        var wid= jQuery('.removebtn').attr('wid');

        jQuery('.removebtn').click(function(event){
            event.preventDefault();

            var wid= jQuery(this).attr('wid');
            console.log(wid);  

            var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

            bootbox.confirm({
                message: "Do You Want To remove Whishlists?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                  if(result == true){

                    jQuery.ajax({
                          url: ajaxurl,
                           method:'post',
                          data: ({ 
                            action:'delete_registry_whishlis',
                             'wid':wid,
                          }),
                          success:function(data){ 
                            jQuery('#remove'+wid).notify(
                                "Wishlist Is Deleted", 
                                { position:"left center", className: "success"  }
                              );
        
                              setTimeout(function(){
                              jQuery('#'+wid).empty();}, 1500);
                             },
                          error: function (xhr, textStatus, errorThrown) { 
                          }
                        });

                   }else{

                   }
                }
            });
        });

  });

    </script>
    <section>
        <table class="table text-center">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Groom Name</th>
                <th scope="col">Groom Email</th>
                <th scope="col">Bride Name</th>
                <th scope="col">Bride Email</th> 
                 <th scope="col">Delete</th> 
                </tr>
            </thead>
            <tbody>

                <?php	 
                    global $wpdb;  
                    $prefix= $wpdb->prefix;
                    $table = $prefix."wedding_registry_wishlists"; 
                    $table2 = $prefix."wedding_registry_item"; 
                    
                     $results = $wpdb->get_results("SELECT * FROM  $table", OBJECT );
                  
                        foreach ( $results as $Users ){   
                        $wId= $Users->id;
                        $groom_FirstName= $Users->goorm_firstname;
                        $groom_LasttName= $Users->goorm_lastname;
                        $groom_Email= $Users->goorm_email;

                        $bride_FirstName= $Users->bride_firstname;
                        $bride_LasttName= $Users->bride_lastname;
                        $bride_Email= $Users->bride_email;

                         
                        $bride_LastName= $Users->bride_lastname; 
                        $message= $Users->message; 
    
                        
                        echo'  <tr scope="row" id="'.$wId.'"> 
                                    <td>'.$wId. '</td>
                                    <td>'.$groom_FirstName.' '.$groom_LasttName.'</td>
                                    <td>'.$groom_Email.'</td>
                                    <td>'.$bride_FirstName.' '.$bride_LasttName.'</td>
                                    <td>'.$bride_Email.'</td>  
                                    <td class="table-danger">
                                        <a href="" class="removebtn" id="remove'.$wId.'" wid="'.$wId.'">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                            </tr>   ';        
                        }             
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


add_action('wp_ajax_delete_registry_whishlis', 'delete_registry_whishlis'); 

function  delete_registry_whishlis(){

 global $wpdb ;
 global $woocommerce;
  
 $wedding_registry_item = $wpdb->prefix."wedding_registry_wishlists";

 
 // add to 
 $wid= $_POST['wid']; 

  $wpdb->delete($wedding_registry_item, array( 'id' => $wid ), array( '%d' ) );

wp_die();

}
  

    
?>