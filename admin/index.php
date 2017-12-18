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
                    global $table;
 
                    $results = $wpdb->get_results( 'SELECT * FROM  wp_wedding_registry_registry', OBJECT );

                    foreach ( $results as $Users ){
                    $userId= $Users->reg_id;
                    $bride_FirstName= $Users->bride_FirstName;
                    $bride_LastName= $Users->bride_LastName; 

                    echo'<th scope="row">'.$userId.'</th>
                        <td>'.$bride_LastName.'</td>
                        <td>'.$bride_LastName.'</td>
                        <td>'.$bride_FirstName.'</td> 
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
        
        wp_enqueue_script('my-admin-jquery-js', plugins_url('js/jquery.min.js', __FILE__)); 
        
        wp_enqueue_script('my-admin-popper-js',plugins_url('js/popper.min.js', __FILE__));   	
        wp_enqueue_script('my-admin-bootstrap-js', plugins_url('js/bootstrap.min.js', __FILE__)); 	 	
        wp_enqueue_script('my-admin-theme-js', plugins_url('js/wedding-gift-registry-admin.js', __FILE__));
        
    }
	add_action('admin_enqueue_scripts', 'my_admin_theme_style');
	add_action('login_enqueue_scripts', 'my_admin_theme_style'); 


?>