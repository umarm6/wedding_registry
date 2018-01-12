<?php

/**
 * Never worry about cache again!
 */
function my_load_scripts() {
    
     
     //styles
     wp_enqueue_script( 'jquery', plugins_url( '../js/jquery.min.js', __FILE__ ), false, '4.0.0', 'all');  
     wp_enqueue_style( 'bootstraps', plugins_url('../css/bootstrap.min.css', __FILE__), false, '4.0.0', 'all');  
     
     wp_enqueue_style( 'font-awesome', plugins_url('../css/font-awesome.min.css', __FILE__), false, '1.0.0', 'all');  
     wp_enqueue_style( 'jquery-ui', plugins_url('../css/jquery-ui.min.css', __FILE__), false, '1.0.0', 'all');   
     wp_enqueue_style( 'custom', plugins_url('../css/registry-public.css', __FILE__), false, '1.0.0', 'all');  
   
       
     //scripts
    
      wp_enqueue_script( 'jqueryui', plugins_url( '../js/jquery.min.js', __FILE__ ), false, '1.12.0', 'all');  
      wp_enqueue_script( 'jqueri', plugins_url( '../js/jquery-ui.min.js', __FILE__ ), false, '1.12.0', 'all');  
      wp_enqueue_script( 'jquery', plugins_url( '../js/jquery.min.js', __FILE__ ), true, '3.30', 'all');  
      wp_enqueue_script( 'popper', plugins_url( '../js/popper.min.js', __FILE__ ), false, '4.0.0', 'all');  
      wp_enqueue_script( 'bootstraps', plugins_url( '../js/bootstrap_2.min.js', __FILE__ ), false, '4.0.0', 'all'); 
      wp_enqueue_script( 'notify', plugins_url( '../js/notify.min.js', __FILE__ ), false, '4.0.0', 'all'); 
      wp_enqueue_script( 'bootbox', plugins_url( '../js/bootbox.min.js', __FILE__ ), false, '4.0.0', 'all'); 
      
      
      
     wp_enqueue_script( 'custom_js', plugins_url( '../js/wedding-gift-registry.js', __FILE__ ), false, '1.0.0', 'all');  
     
     
    
    }

?>