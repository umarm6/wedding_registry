<?php


function add_content_after_addtocart_button_func() {
    global $woocommerce;
    global $product;
    global $variation;
     
    $pro_id = $product->get_id();
    $pro_type = $product->get_type ();
      
    // foreach ( $items as $item ) {
     
    //     $product = wc_get_product( $item['product_id'] );
     
    //     // Now you have access to (see above)...
     
    //     $product->get_type();
    //   $por_name=  $product->get_name();
    //     // etc.
    //     // etc.
    //     echo '<a href="" class="single_registry_to_cart_button button " pro-name="'.$pro_name.'">Add to Registry</a>';
  
  
  
    // }
    
           // Echo content.
   
    global $wpdb;
    $registry_wishlist_table = $wpdb->prefix."wedding_registry_wishlists"; 
    $wpu_id=  get_current_user_id(); 
      
    $checkuser = $wpdb->get_row( 'SELECT wpuser_id FROM '.$registry_wishlist_table.' WHERE wpuser_id ='.$wpu_id.'', ARRAY_A);
  
    $cwhck= $checkuser['wpuser_id'];
     
   
     if( $product->is_type( 'simple' ) ){
      
      // a simple product
   
      
      echo '<a href="" class="single_registry_to_cart_button button add_to_registry " id="add_to_registry'.$pro_id.'"  pro-id="'.$pro_id.'"  click-'.$pro_id.'  prof-id="'.$cwhck.'" >Add to Registry</a>';
      if (!is_user_logged_in() ) : ////if user not loged
        
      ?>
    
      <script>

        jQuery(document).ready(function () {
          var prod_id = "<?php echo $pro_id; ?>";
console.log(prod_id);
          jQuery('#add_to_registry'+prod_id).click(function (event) {
          
            event.preventDefault(); 
          
            bootbox.alert({
              size: "big", 
              title: "", 
              message: "Please sign in Before add to registry!",
              backdrop: true
              });
            
          
          });     
      
        });
      </script>
    
      <?php
          elseif( $cwhck== 0) :////if user not create registry

            $my_account_link = get_permalink( get_option('woocommerce_myaccount_page_id') );
            $edit_acount_link = $my_account_link . 'edit-registry';
        ?>
              <script>
                      jQuery(document).ready(function () {

                    var prod_id = "<?php echo $pro_id; ?>";
                    console.log(prod_id);
                    jQuery('#add_to_registry'+prod_id).click(function (event) {
                  
                    event.preventDefault(); 
                  
                    bootbox.alert({
                      size: "big", 
                      title: "", 
                      message: "Please create registry first!	<a href='<?php echo $edit_acount_link; ?>' class='button btn-warning'>Create Registry</a>",
                      backdrop: true
                      });
                    
                  
                  });     
              
                });
              </script>
        <?php

      else:    
          ?>
          
      <script>
        jQuery(document).ready(function () {
          
          var prod_id = "<?php echo $pro_id; ?>";
console.log(prod_id);
          jQuery('#add_to_registry'+prod_id).click(function (event) {
           
          
             var pro_id= jQuery(this).attr('pro-id'); 
             <?php
                    if ( is_product() ){
                      echo "var qty= jQuery('div.quantity .qty').val();";
                      
                    }else{
                      echo "var qty=1;";
                      
                    }                     
             ?>
            var prof_id= jQuery(this).attr('prof-id'); 
            var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
         
       //   var data = {
          //   'action': 'registry_cart',
          //   'whatever': 1234
          // };
          // if(qty==''){
          //   newqty =1;
          // }else{
          //   newqty =qty;
          // }
          
    
          $.ajax({
                  type: "POST", 
                   url: ajaxurl,
                  data: ({
                  action: 'registry_cart',
                  'pro_id':pro_id,
                  'qty':qty,
                  'prof_id':prof_id,
                  }),
                  success:function(data){
                    jQuery('#add_to_registry'+prod_id).notify(
                        "Item Is added to registry", 
                        { position:"bottom center", className: "success"  }
                      );
                  },
                  error: function (xhr, textStatus, errorThrown) { 
    
                    jQuery('#add_to_registry'+prod_id).notify(
                        "Item Is added to registry", 
                        { position:"bottom center", className: "error"  }
                      );
    
                  }
            });
            event.preventDefault(); 
    
            });     
      
    
        });
      </script>
          
          
          <?php
       endif;
  
      
      
    } elseif( $product->is_type( 'variable' ) ){
      
      // a variable product 
      $url = get_permalink( $pro_id );
   
      if ( !is_product() ){
        
        // yipee, this works!
        echo '<a href="'. $url.'" class="single_var_registry_to_cart_button button"  pro-id="'.$pro_id.'"  prof-id="'.$cwhck.'" >View More to Registry</a>';
        
      }else{     
        echo '<a href="'. $url.'" class="single_var_registry_to_cart_button button add_to_registry_rm"  pro-id="'.$pro_id.'"  prof-id="'.$cwhck.'" >View More to Registry</a>'; 
        echo '<a href="" class="single_var_registry_to_cart_button button add_to_registry " id="add_to_registry'.$pro_id.'"  pro-id="'.$pro_id.'"  prof-id="'.$cwhck.'" >Add to Registry</a>';
        
        ?>

      <script>
        jQuery(document).ready(function () {
           jQuery('body.woocommerce-page .product-type-variable .summary.entry-summary form .add_to_registry_rm').remove(); 

            jQuery('section.up-sells.upsells.products .product-type-variable .add_to_registry').remove(); 
            jQuery('section.related.products .product-type-variable .add_to_registry').remove();

        });
        </script>

        <?php
      }
     
      
      
  
      
      if (!is_user_logged_in()) :
        
      ?>
    
      <script>
        jQuery(document).ready(function () {
          var prod_id = "<?php echo $pro_id; ?>";
console.log(prod_id);
          jQuery('#add_to_registry'+prod_id).click(function (event) {
          
            event.preventDefault(); 
          
            bootbox.alert({
              size: "big", 
              title: "", 
              message: "Please sign in Before add to registry!",
              backdrop: true
              });
            
          
          });     
      
        });
      </script>
    
      <?php
          
          elseif( $cwhck== 0) :////if user not create registry
            
                        $my_account_link = get_permalink( get_option('woocommerce_myaccount_page_id') );
                        $edit_acount_link = $my_account_link . 'edit-registry';
                    ?>
                          <script>
                            jQuery(document).ready(function () {
                            var prod_id = "<?php echo $pro_id; ?>";
                            console.log(prod_id);
                            jQuery('#add_to_registry'+prod_id).click(function (event) {
                              
                                event.preventDefault(); 
                              
                                bootbox.alert({
                                  size: "big", 
                                  title: "", 
                                  message: "Please create registry first!	<a href='<?php echo $edit_acount_link; ?>' class='button btn-warning'>Create Registry</a>",
                                  backdrop: true
                                  });
                                
                              
                              });     
                          
                            });
                          </script>
                    <?php
                    
                  else:
    
          ?>
          
      <script>
        jQuery(document).ready(function () {
          var prod_id = "<?php echo $pro_id; ?>";
          console.log(prod_id);
          jQuery('#add_to_registry'+prod_id).click(function (event) {          
          var select_option= jQuery('table.variations .value select').val();
          if(select_option==""){
  
             jQuery('#add_to_registry'+prod_id).notify(
                        "please choose an option", 
                        { position:"bottom center", className: "error"  }
                      );
          }else{
            var pro_id= jQuery('.add_to_registry').attr('pro-id'); 
            var qty= jQuery('div.quantity .qty').val();
            var prof_id= jQuery('.add_to_registry').attr('prof-id'); 
            var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
          var vari=  jQuery('form.variations_form.cart .single_variation_wrap .variations_button input.variation_id').val();
  
      console.log(vari);
      //   var data = {
          //   'action': 'registry_cart',
          //   'whatever': 1234
          // };
          
    
          $.ajax({
                  type: "POST", 
                   url: ajaxurl,
                  data: ({
                  action: 'registry_cart',
                  'vari': vari,
                  'pro_id':pro_id,
                  'qty':qty,
                  'prof_id':prof_id,
                  }),
                  success:function(data){
                    jQuery('#add_to_registry'+prod_id).notify(
                        "Item Is added to registry", 
                        { position:"bottom center", className: "success"  }
                      );
                  },
                  error: function (xhr, textStatus, errorThrown) { 
    
                    jQuery('#add_to_registry'+prod_id).notify(
                        "Item Is Not added to Registry", 
                        { position:"bottom center", className: "error"  }
                      );
    
                  }
            });
  
          }
            
    
            event.preventDefault(); 
    
            });     
      
    
        });
      </script>
          
          
          <?php
        endif;
  
      
    }
   
  
    
  }
  
  
  add_action( 'wp_ajax_registry_cart', 'registry_cart' );
   add_action( 'wp_ajax_nopriv_registry_cart', 'registry_cartaction' );
  
  function registry_cart() {
      global $wpdb; // this is how you get access to the database
       
  $pro_id=$_POST['pro_id'];
  $qty=$_POST['qty'];
  $prof_id=$_POST['prof_id'];
  
  $wedding_registry_iteme = $wpdb->prefix."wedding_registry_item";
  $productcheck = $wpdb->get_row( 'SELECT * FROM '.$wedding_registry_iteme.' WHERE wish_id ='.$prof_id.' AND product_id='.$pro_id.'', ARRAY_A);
  
    $productcheck_pro= $productcheck['product_id'];
    $productcheck_var= $productcheck['variation_id'];
    $productcheck_qty= $productcheck['quantity'];
    $productcheck_wish_id= $productcheck['wish_id'];
    
 

    if(isset($_POST['vari'])){
    
      $wedding_registry_item = $wpdb->prefix."wedding_registry_item";

      $vari=$_POST['vari'];
      
      if($pro_id == $productcheck_pro && $prof_id == $productcheck_wish_id &&  $vari== $productcheck_var ){

         $wpdb->query($wpdb->prepare( "UPDATE $wedding_registry_item SET quantity=CONCAT($qty+$productcheck_qty)  WHERE wish_id= %d AND variation_id=%d",$productcheck_wish_id,$productcheck_var));

        }else 
        {
          error_log($productcheck_var);
  
          $wpdb->insert( 
            $wedding_registry_item, 
            array( 
              'wish_id' => $prof_id, 
              'product_id'  => $pro_id,
              'quantity'  => $qty,
              'variation_id' => $vari 
              
            ), 
            array( 
              '%s', //data type is string
              '%s',
              '%s',
              '%s',
            
            ) 
          ); 

        }

    
    
    }else{
      
      $wedding_registry_item = $wpdb->prefix."wedding_registry_item";
      if($pro_id == $productcheck_pro && $prof_id == $productcheck_wish_id ){
        
        // error_log('equal');
           $wpdb->query($wpdb->prepare( "UPDATE $wedding_registry_item SET quantity=CONCAT($qty+$productcheck_qty)  WHERE wish_id=%d AND product_id=%d ",$productcheck_wish_id,$productcheck_pro ));
        
     
              }else 
              {
        $wpdb->insert( 
          $wedding_registry_item, 
          array( 
              'wish_id' => $prof_id, 
            'product_id'  => $pro_id,
            'quantity'  => $qty,
              
          ), 
          array( 
            '%s', //data type is string
            '%s',
            '%s',
          // '%s',
          
          ) 
        ); 
    
      }
    }
   
  
  wp_die();
  }

  
?>