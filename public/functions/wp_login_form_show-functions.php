<?php

 

  
function wp_login_form_show(){
    
  
global $wpdb ;
global $woocommerce;
global $product;


$registry_item_table = $wpdb->prefix."wedding_registry_item"; 
$wpu_id=  get_current_user_id();  
$variation_id = $wpdb->get_row( 'SELECT variation_id FROM '.$registry_item_table.' WHERE wish_id ='.$wpu_id.'', ARRAY_A);
$products_id = $wpdb->get_row( 'SELECT product_id FROM '.$registry_item_table.' WHERE wish_id ='.$wpu_id.'', ARRAY_A);
$product_id= $products_id['product_id'];
   
$resultss = $wpdb->get_results( 'SELECT * FROM '.$registry_item_table.' WHERE wish_id ='.$wpu_id.'', OBJECT);
$num_rows = $wpdb->get_var("SELECT COUNT(*) FROM $registry_item_table"); /// number of rows

    // foreach started
    
  $registry_wishlist_table = $wpdb->prefix."wedding_registry_wishlists"; 
  $wpu_id=  get_current_user_id(); 
  


  $http_schema = 'http://';
  if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'])  {
    $http_schema = 'https://';
  }
    
  $temp_array = str_split($_SERVER['QUERY_STRING']); 
  $request_link  = $http_schema. $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ;
     

  $wpu_link_id=  $temp_array[0]; 
  $account = $wpdb->get_row( "SELECT goorm_firstname , bride_firstname  FROM $registry_wishlist_table WHERE wpuser_id='$wpu_link_id'", ARRAY_A);
  // $account = $wpdb->get_row( 'SELECT goorm_firstname , bride_firstname  FROM '.$registry_wishlist_table, ARRAY_A);
  

  $accountGroom= $account['goorm_firstname'];
  $accountBride= $account['bride_firstname'];
   
  $acount_page = get_page_by_path('wedding-giftregistry');
  $acount_pageId = $acount_page->ID;


  if(is_user_logged_in()){
    if($_SERVER['QUERY_STRING']){
      $wpu_link = $wpu_link_id;
      
    }else{
      $wpu_link = get_current_user_id();
      
    }
    
  }else{
    $wpu_link = $wpu_link_id;
    

  }
  $num_rows_id = $wpdb->get_var("SELECT COUNT(*) FROM $registry_item_table WHERE wish_id=$wpu_link"); /// number of rows
  
  // var_dump($_SERVER['QUERY_STRING']);
  
  $acount_pageLink = get_permalink($acount_pageId).'?'.$wpu_link.'&'.$accountGroom.'_'.$accountBride;

  
    // echo $acount_pageLink .'<br/>'; 
  
  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
   
  $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  //  echo $url; // Outputs: Full URL
  
   $variation_id = $wpdb->get_row( 'SELECT variation_id FROM '.$registry_item_table.' WHERE wish_id ='.$wpu_id.'', ARRAY_A);
   $products_id = $wpdb->get_row( 'SELECT product_id FROM '.$registry_item_table.' WHERE wish_id ='.$wpu_id.'', ARRAY_A);
   $product_id= $products_id['product_id'];
      
   $resultss = $wpdb->get_results( 'SELECT * FROM '.$registry_item_table.' WHERE wish_id ='.$wpu_link.'', OBJECT);
     
  if($url === $acount_pageLink): 

          // var_dump($resultss);
          ?>
          <section>

          <div class="container">
          <h2>Bordered Table quer</h2>
          <p>The .table-bordered class adds borders on all sides of the table and the cells:</p>            
          <table class="table table-bordered">
          <thead>
            <tr>
            <?php if(is_user_logged_in()):?>   <th> </th>  <?php endif;?>
              <th>PRODUCT</th>
              <th>PRICE</th>
              <th> QUANTITY	asas</th> 
            <th><?php if(is_user_logged_in()):?>RECEIVED QUANTITY<?php else: ?><br> DESIRED QUANTITY  <?php endif;?></th> 
            <th></th>
            </tr>
          </thead>
          <tbody id="registry-products">

          <?php
            foreach ( $resultss as $resu ): 
              
                  $product_id=$resu->product_id;
                  $variation_id=$resu->variation_id;
                  $product_new_id=$resu->product_id;
                  
                  if($variation_id==0){
                    $products = wc_get_product($product_id); 
                    $post_thumbnail_id = get_the_post_thumbnail_url( $products->get_id(),'thumbnail');
                    
                  }else{
                    $products = wc_get_product($variation_id);             
                    $post_thumbnail_id = get_the_post_thumbnail_url( $products->get_id(),'thumbnail');
                    
                  }


            ?>
            <tr>
            <form method="POST" action="">
            <?php 
            $wpu_links=get_current_user_id();
              ?>
            
                <?php if( $wpu_link_id == $wpu_links):  ?> <td><a href="" class="remove-pro"><i class="fa fa-trash" style="font-size: 25px;"></i> </a></td> <?php endif;?>
              <td> <img src="<?php echo $post_thumbnail_id; ?>"/><a href="<?php echo get_permalink($product_id); ?>" class="pl-4"><?php echo $products->get_name();?></a></td>
              <td><?php echo 'LKR &nbsp;' . number_format($products->get_price(), 2, '.', ' ,'); ?></td>
              <td>
                  <input type="number" class="btn-outline-warning btn buy-qty-<?php  if($variation_id == 0): echo $product_new_id; else: echo$variation_id; endif;?>" name="qtys" value="1" min="1" <?php if(!is_user_logged_in()): ?> max="<?php echo $resu->quantity;   endif; ?>"  qty="<?php echo  $product_new_id; ?>">
                  <input type="hidden" class="btn-outline-warning btn variable_id" value="<?php echo  $variation_id; ?>" name="variable_ids">
                  <input type="hidden" class="btn-outline-warning btn product_id" value="<?php echo  $product_id; ?>" name="product_ids">

              </td>
              <td><p><?php echo  $resu->quantity; ?></p></td>
              <td><button type="submit"  name="submit" class="btn btn-primary buy_this" id="buy_this<?php if($variation_id == 0): echo $product_new_id; else: echo$variation_id; endif;?>" pro_id="<?php echo $product_id ; ?>"  variable_id="<?php echo $variation_id ;?>"  wpu-id="<?php echo $wpu_id;?>" >Buy This</button></td>
            </form>
              </tr> 

          <?php

            

          endforeach; 
          if($num_rows ==0):
            
          ?> <tr id="post-<?php if($variation_id == 0){echo $product_id ;}else{echo $variation_id;} ?>"> 
          <td colspan=6 style="text-align:center;">There No Products Yet !</td>
         </tr> 

         <?php
         endif;
         ?>
           <script>  
jQuery(document).ready(function(){

  jQuery(document).on('click','.buy_this',function(event){
            // alert('asdad');
              event.preventDefault();
              console.log('sdasd');
              var buy_pro_id=jQuery(this).attr('pro_id');
              var buy_var_id=jQuery(this).attr('variable_id');
              var buy_wpu_id=jQuery(this).attr('wpu-id');
              if(buy_var_id==0){
                var buy_qty_id=buy_pro_id;
              }else{ 
                var buy_qty_id=buy_var_id; 
              }
              var buy_qty=jQuery('.buy-qty-'+buy_qty_id).val();
              var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

              // console.log(buy_var_id);  
  
              jQuery.ajax({
                 url: ajaxurl,
                   method:'post',
                  data: ({ 
                    action:'add_registry_item_cart',
                    'buy_pro_id':buy_pro_id,
                    'buy_var_id':buy_var_id,
                    'buy_qty':buy_qty,
                  }),
                  success:function(data){ 
                     
                    jQuery('#buy_this'+buy_qty_id).notify(
                        "Item Is Added To cart", 
                        { position:"left center", className: "success"  }
                      ); 
                     
                   },
                  error: function (xhr, textStatus, errorThrown) { 
   
                      jQuery('#buy_this'+buy_qty_id).notify(
                        "Item Is Not Add to cart", 
                        { position:"left center", className: "error"  }
                      );
                    
                  }
            }); 


            });
          });


            </script>
 
          </tbody>
          </table>
             <!-- ===============shre this=========== -->
             <?php          if($num_rows_id >0):

if(is_user_logged_in()){
  if($_SERVER['QUERY_STRING']){
    $wpu_link = $wpu_link_id;
    
  }else{
    $wpu_link = get_current_user_id();
    
  }
  
}else{
  $wpu_link = $wpu_link_id;
  

}

                       ?>

            <div class="row">
            <div class="col-md-3 ">
            </div>

              <div class="col-md-6 text-center">
      
              <img src="<?php echo plugins_url( "../css/images/share.jpg", __FILE__ );?>"         style="width:220px ;display: block;  margin: 25px auto;">
 
              <div id="share-buttons"> 
     
    
    <!-- Email -->
    <a href="mailto:?Subject=Gift Registry&amp;Body=<?php  echo urlencode($acount_pageLink);?>">
        <img src="https://simplesharebuttons.com/images/somacro/email.png" alt="Email" />
    </a>
 
    <!-- Facebook -->
    <a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($acount_pageLink);?>" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" />
    </a>
    
    <!-- Google+ -->
    <a href="https://plus.google.com/share?url=<?php echo urlencode($acount_pageLink);?>" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" />
    </a>
    
    <!-- LinkedIn -->
    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($acount_pageLink);?>" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/linkedin.png" alt="LinkedIn" />
    </a>
    
    <!-- Pinterest -->
    <a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());">
        <img src="https://simplesharebuttons.com/images/somacro/pinterest.png" alt="Pinterest" />
    </a> 
    <!-- Twitter -->
    <a href="https://twitter.com/share?url=<?php echo urlencode($acount_pageLink);?>" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" />
    </a>
       <!-- Print -->
       <a href="javascript:;" onclick="window.print()">
        <img src="https://simplesharebuttons.com/images/somacro/print.png" alt="Print" />
    </a> 

</div>

              </div> 
              <div class="col-md-3 ">
            </div>
              </div>    
                <?php         endif; ?>
        
                      <!-- ===============shre this=========== -->

          </div>

          </section>

          <?php  
  elseif(is_user_logged_in()): // else if (page is not equle to link)
//  if($url == $acount_pageLink OR is_page( 'wedding-giftregistry' ) )    {
// echo 'true';
// echo is_page( 'wedding-giftregistry' ) ;

//  }else{
//   echo 'false';
  
//  }
     if($url == $acount_pageLink && $_SERVER['QUERY_STRING'] ): 
      
      ?>
      <section>

      <div class="container">
      <h2>Bordered Tables log</h2>
      <p>The .table-bordered class adds borders on all sides of the table and the cells:</p>            
      <table class="table table-bordered">
      <thead>
        <tr>
          <th> </th>
          <th>PRODUCT</th>
          <th>PRICE</th>
          <th>DESIRED QUANTITY	</th> 
          <th>RECEIVED QUANTITY
      </th>  <th> 
      </th>

        </tr>
      </thead>
      <tbody id="registry-products">
      <?php
      // var_dump($resultss);
      foreach ( $resultss as $resu ): 
        
            $product_id=$resu->product_id;
            $variation_id=$resu->variation_id;
            if($variation_id==0){
              $products = wc_get_product($product_id); 
              $post_thumbnail_id = get_the_post_thumbnail_url( $products->get_id(),'thumbnail');
              
            }else{
              $products = wc_get_product($variation_id);             
              $post_thumbnail_id = get_the_post_thumbnail_url( $products->get_id(),'thumbnail');
              
            }

       ?>
      <tr id="post-<?php if($variation_id == 0){echo $product_id ;}else{echo $variation_id;} ?>">
      <form method="POST">


      <?php    if( $wpu_link_id &&  $wpu_links):  ?>
        <td><a href="" class="remove-pro" id="rm-<?php if($variation_id == 0){echo $product_id ;}else{echo $variation_id;} ?>" rm_pro_id="<?php echo $product_id ; ?>"  rm_variable_id="<?php echo $variation_id ;?>"  rm_wpu_id="<?php echo $wpu_id;?>"><i class="fa fa-trash" style="font-size: 25px;" message ></i> </a></td> 
          <?php endif; ?>
            <td> <img src="<?php echo $post_thumbnail_id; ?>"/><a href="<?php echo get_permalink($product_id); ?>" class="pl-4"><?php echo $products->get_name(); ?></a></td>
        <td><?php echo 'LKR &nbsp;' . number_format($products->get_price(), 2, '.', ' ,'); ?></td>
        <td>
            <input type="number" class="btn-outline-warning btn buy-qty-<?php  if($variation_id == 0): echo $product_id; else: echo$variation_id; endif;?>" value="<?php echo  $resu->quantity; ?>" min="1"  <?php if(!is_user_logged_in()): ?> <?php echo ' max="$resu->quantity;  "';  endif; ?> name="qtysss">
            <input type="hidden" class="btn-outline-warning btn variable_id" value="<?php echo  $variation_id; ?>" name="variables_ids">
             <input type="hidden" class="btn-outline-warning btn product_id" value="<?php echo  $product_id; ?>" name="products_ids">

        </td>
        <td><p><?php echo  $resu->received_qty; ?></p></td>
        <td><button type="submit"  name="submit"  class="btn btn-primary save_this"  id="save_this_<?php if($variation_id == 0){echo $product_id ;}else{echo $variation_id;} ?>" pro_id="<?php echo $product_id ; ?>"  variable_id="<?php echo $variation_id ;?>"  wpu-id="<?php echo $wpu_id;?>" >Save</button></td>
        </form>
        </tr> 

      <?php



      endforeach;
  if($num_rows ==0):
      ?>
       
       <tr id="post-<?php if($variation_id == 0){echo $product_id ;}else{echo $variation_id;} ?>"> 
       <td colspan=6 style="text-align:center;">There No Products Yet !</td>
       </tr> 
       <?php
       endif;
       ?>
   <script>
       /////////////////////////////remove item is started

   jQuery(document).on('click','.remove-pro',function (event) {
     
       event.preventDefault();
      var rmpro= jQuery(this).attr('rm_pro_id');
      var rmvar= jQuery(this).attr('rm_variable_id');
      var rmwpu =jQuery(this).attr('rm_wpu_id');
      var message =jQuery(this).attr('id');
if(rmvar==0){

var rmID=rmpro;

}else{
 var rmID=rmvar;
  
}
      var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
   
// console.log(message);
bootbox.confirm({
    message: "This is a confirm with custom button text and color! Do you like it?",
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

        console.log('This was logged in the callback: ' + result);
        jQuery.ajax({
                  url: ajaxurl,
                   method:'post',
                  data: ({ 
                    action:'delete_registry_item',
                    'rmpro':rmpro,
                    'rmvar':rmvar,
                    'rmwpu':rmwpu,
                  }),
                  success:function(data){
                    if(rmvar==0){
                      var message_check ='rm-'+rmpro;
                    }else{
                      var message_check ='rm-'+rmvar;

                    }
 
                    if(message == message_check ){
                     
                    jQuery('#'+message_check).notify(
                        "Item Is Deleted", 
                        { position:"right center", className: "success"  }
                      );

                      setTimeout(function(){
                      jQuery('#post-'+rmID).empty();}, 1000);
                     }
                     
                   },
                  error: function (xhr, textStatus, errorThrown) { 
 
                    if(rmvar==0){
                      var message_check ='rm-'+rmpro;
                    }else{
                      var message_check ='rm-'+rmvar;

                    }                  
                      // console.log(message_check);

                    if(message == message_check ){
                     
                      jQuery('#'+message_check).notify(
                        "Item Is Not Deleted", 
                        { position:"right center", className: "error"  }
                      );
                    }
                    
    
                  }
            }); 

      }else{
        console.log('This was logged in the callback: ' + result);


      }
    }
});

     
      //  console.log(rmpro,rmwpu,rmvar); 
      // alert('sadsd',rmpro);
    });

    /////////////////////////////remove item is closed
    /////////////////////////////started add to cart registry

      
jQuery(document).ready(function(){

  
  jQuery(document).on('click','.save_this',function(event){
            // alert('asdad');
              event.preventDefault();
              console.log('sdasd');
              var buy_pro_id=jQuery(this).attr('pro_id');
              var buy_var_id=jQuery(this).attr('variable_id');
              var buy_wpu_id=jQuery(this).attr('wpu-id');
              if(buy_var_id==0){
                var buy_qty_id=buy_pro_id;
              }else{ 
                var buy_qty_id=buy_var_id; 
              }
              var buy_qty=jQuery('.buy-qty-'+buy_qty_id).val();
              var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

              // console.log(buy_var_id);  
  
              jQuery.ajax({
                 url: ajaxurl,
                   method:'post',
                  data: ({ 
                    action:'save_registry_quantity',
                    'buy_pro_id':buy_pro_id,
                    'buy_var_id':buy_var_id,
                    'buy_qty':buy_qty,
                    'buy_prof_id':buy_wpu_id,
                  }),
                  success:function(data){ 
                     
                    jQuery('#save_this_'+buy_qty_id).notify(
                        "Saved item", 
                        { position:"left center", className: "success"  }
                      ); 
                     
                   },
                  error: function (xhr, textStatus, errorThrown) { 
   
                      jQuery('#save_this_'+buy_qty_id).notify(
                        "Item Is Not Saved", 
                        { position:"left center", className: "error"  }
                      );
                    
                  }
            }); 


            });
          });

 </script>
 
      </tbody>
      </table>
      </div>

      </section>
      <?php  
      
      elseif(is_page( 'wedding-giftregistry' ) &&  !$_SERVER['QUERY_STRING'] ):// echo is_page( 'wedding-giftregistry' ) ;

         if(is_user_logged_in()){
  
          
      $wpu_link = get_current_user_id();
      $accounts = $wpdb->get_row( "SELECT goorm_firstname , bride_firstname  FROM $registry_wishlist_table WHERE wpuser_id='$wpu_link'", ARRAY_A);
      
     
  $accountGrooms= $accounts['goorm_firstname'];
  $accountBrides= $accounts['bride_firstname'];
   
  $acount_page = get_page_by_path('wedding-giftregistry');
  $acount_pageId = $acount_page->ID;

  }else{
    $wpu_link = $wpu_link_id;
    $accounts = $wpdb->get_row( "SELECT goorm_firstname , bride_firstname  FROM $registry_wishlist_table WHERE wpuser_id=$wpu_link", ARRAY_A);
    
    $accountGrooms= $accounts['goorm_firstname'];
    $accountBrides= $accounts['bride_firstname'];
     

  }
   $acount_pageLinks = get_permalink($acount_pageId).'?'.$wpu_link.'&'.$accountGrooms.'_'.$accountBrides;
         
          ?>
        <section>
        
              <div class="container">
              <h2>Bordered Tables log</h2>
              <p>The .table-bordered class adds borders on all sides of the table and the cells:</p>            
              <table class="table table-bordered">
              <thead>
                <tr>
                  <th> </th>
                  <th>PRODUCT</th>
                  <th>PRICE</th>
                  <th>DESIRED QUANTITY	</th> 
                  <th>RECEIVED QUANTITY
              </th>  <th> 
              </th>
        
                </tr>
              </thead>
              <tbody id="registry-products">
              <?php
              // var_dump($resultss);
              foreach ( $resultss as $resu ): 
                
                    $product_id=$resu->product_id;
                    $variation_id=$resu->variation_id;
                    if($variation_id==0){
                      $products = wc_get_product($product_id); 
                      $post_thumbnail_id = get_the_post_thumbnail_url( $products->get_id(),'thumbnail');
                      
                    }else{
                      $products = wc_get_product($variation_id);             
                      $post_thumbnail_id = get_the_post_thumbnail_url( $products->get_id(),'thumbnail');
                      
                    }
        
               ?>
              <tr id="post-<?php if($variation_id == 0){echo $product_id ;}else{echo $variation_id;} ?>">
              <form method="POST">
        
        
                <td><a href="" class="remove-pro" id="rm-<?php if($variation_id == 0){echo $product_id ;}else{echo $variation_id;} ?>" rm_pro_id="<?php echo $product_id ; ?>"  rm_variable_id="<?php echo $variation_id ;?>"  rm_wpu_id="<?php echo $wpu_id;?>"><i class="fa fa-trash" style="font-size: 25px;" message ></i> </a></td> 
                <td> <img src="<?php echo $post_thumbnail_id; ?>"/><a href="<?php echo get_permalink($product_id); ?>" class="pl-4"><?php echo $products->get_name(); ?></a></td>
                <td><?php echo 'LKR &nbsp;' . number_format($products->get_price(), 2, '.', ' ,'); ?></td>
                <td>
                    <input type="number" class="btn-outline-warning btn buy-qty-<?php  if($variation_id == 0): echo $product_id; else: echo$variation_id; endif;?>" value="<?php echo  $resu->quantity; ?>" min="1"  <?php if(!is_user_logged_in()): ?> <?php echo ' max="$resu->quantity;  "';  endif; ?> name="qtysss">
                    <input type="hidden" class="btn-outline-warning btn variable_id" value="<?php echo  $variation_id; ?>" name="variables_ids">
                     <input type="hidden" class="btn-outline-warning btn product_id" value="<?php echo  $product_id; ?>" name="products_ids">
        
                </td>
                <td><p><?php echo  $resu->received_qty; ?></p></td>
                <td><button type="submit"  name="submit"  class="btn btn-primary save_this"  id="save_this_<?php if($variation_id == 0){echo $product_id ;}else{echo $variation_id;} ?>" pro_id="<?php echo $product_id ; ?>"  variable_id="<?php echo $variation_id ;?>"  wpu-id="<?php echo $wpu_id;?>" >Save</button></td>
                </form>
                </tr> 
        
              <?php
        
        
        
              endforeach;
          if($num_rows_id < 1):
              ?>
               
               <tr id="post-<?php if($variation_id == 0){echo $product_id ;}else{echo $variation_id;} ?>"> 
               <td colspan=6 style="text-align:center;">There No Products Yet !</td>
               </tr> 
               <?php
               endif;
               ?>
           <script>
               /////////////////////////////remove item is started
        
           jQuery(document).on('click','.remove-pro',function (event) {
             
               event.preventDefault();
              var rmpro= jQuery(this).attr('rm_pro_id');
              var rmvar= jQuery(this).attr('rm_variable_id');
              var rmwpu =jQuery(this).attr('rm_wpu_id');
              var message =jQuery(this).attr('id');
        if(rmvar==0){
        
        var rmID=rmpro;
        
        }else{
         var rmID=rmvar;
          
        }
              var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
           
        // console.log(message);
        bootbox.confirm({
            message: "This is a confirm with custom button text and color! Do you like it?",
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
        
                console.log('This was logged in the callback: ' + result);
                jQuery.ajax({
                          url: ajaxurl,
                           method:'post',
                          data: ({ 
                            action:'delete_registry_item',
                            'rmpro':rmpro,
                            'rmvar':rmvar,
                            'rmwpu':rmwpu,
                          }),
                          success:function(data){
                            if(rmvar==0){
                              var message_check ='rm-'+rmpro;
                            }else{
                              var message_check ='rm-'+rmvar;
        
                            }
         
                            if(message == message_check ){
                             
                            jQuery('#'+message_check).notify(
                                "Item Is Deleted", 
                                { position:"right center", className: "success"  }
                              );
        
                              setTimeout(function(){
                              jQuery('#post-'+rmID).empty();}, 1000);
                             }
                             
                           },
                          error: function (xhr, textStatus, errorThrown) { 
         
                            if(rmvar==0){
                              var message_check ='rm-'+rmpro;
                            }else{
                              var message_check ='rm-'+rmvar;
        
                            }                  
                              // console.log(message_check);
        
                            if(message == message_check ){
                             
                              jQuery('#'+message_check).notify(
                                "Item Is Not Deleted", 
                                { position:"right center", className: "error"  }
                              );
                            }
                            
            
                          }
                    }); 
        
              }else{
                console.log('This was logged in the callback: ' + result);
        
        
              }
            }
        });
        
             
              //  console.log(rmpro,rmwpu,rmvar); 
              // alert('sadsd',rmpro);
            });
        
            /////////////////////////////remove item is closed
            /////////////////////////////started add to cart registry
        
              
        jQuery(document).ready(function(){
        
          
          jQuery(document).on('click','.save_this',function(event){
                    // alert('asdad');
                      event.preventDefault();
                      console.log('sdasd');
                      var buy_pro_id=jQuery(this).attr('pro_id');
                      var buy_var_id=jQuery(this).attr('variable_id');
                      var buy_wpu_id=jQuery(this).attr('wpu-id');
                      if(buy_var_id==0){
                        var buy_qty_id=buy_pro_id;
                      }else{ 
                        var buy_qty_id=buy_var_id; 
                      }
                      var buy_qty=jQuery('.buy-qty-'+buy_qty_id).val();
                      var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
        
                      // console.log(buy_var_id);  
          
                      jQuery.ajax({
                         url: ajaxurl,
                           method:'post',
                          data: ({ 
                            action:'save_registry_quantity',
                            'buy_pro_id':buy_pro_id,
                            'buy_var_id':buy_var_id,
                            'buy_qty':buy_qty,
                            'buy_prof_id':buy_wpu_id,
                          }),
                          success:function(data){ 
                             
                            jQuery('#save_this_'+buy_qty_id).notify(
                                "Saved item", 
                                { position:"left center", className: "success"  }
                              ); 
                             
                           },
                          error: function (xhr, textStatus, errorThrown) { 
           
                              jQuery('#save_this_'+buy_qty_id).notify(
                                "Item Is Not Saved", 
                                { position:"left center", className: "error"  }
                              );
                            
                          }
                    }); 
        
        
                    });
                  });
        
         </script>
         
              </tbody>
              </table>
                    <!-- ===============shre this=========== -->
                    <?php          if($num_rows_id >0):
                       ?>

            <div class="row">
            <div class="col-md-3 ">
            </div>

              <div class="col-md-6 text-center">
              <?php echo $acount_pageLinks; ?>
              <img src="<?php echo plugins_url( "../css/images/share.jpg", __FILE__ );?>"         style="width:220px ;display: block;  margin: 25px auto;">
 
              <div id="share-buttons"> 
     
     <!-- Email -->
    <a href="mailto:?Subject=Simple Share Buttons&amp;Body=<?php echo urlencode($acount_pageLink);  ?>">
        <img src="https://simplesharebuttons.com/images/somacro/email.png" alt="Email" />
    </a>
 
    <!-- Facebook -->
    <a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($acount_pageLink); ?>" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" />
    </a>
    
    <!-- Google+ -->
    <a href="https://plus.google.com/share?url=<?php echo urlencode($acount_pageLink);?>" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" />
    </a>
    
    <!-- LinkedIn -->
    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($acount_pageLink);?>" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/linkedin.png" alt="LinkedIn" />
    </a>
    
    <!-- Pinterest -->
    <a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());">
        <img src="https://simplesharebuttons.com/images/somacro/pinterest.png" alt="Pinterest" />
    </a> 
    <!-- Twitter -->
    <a href="https://twitter.com/share?url=<?php echo urlencode($acount_pageLink);?>" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" />
    </a>
       <!-- Print -->
       <a href="javascript:;" onclick="window.print()">
        <img src="https://simplesharebuttons.com/images/somacro/print.png" alt="Print" />
    </a> 

</div>

              </div> 
              <div class="col-md-3 ">
            </div>
              </div>    
                <?php         endif; ?>
        
                      <!-- ===============shre this=========== -->

              </div>

              </section>
              <?php
       else:
        echo'true no products';
        
      endif;

        
             
  else:
        ?>
        
        <section>
    <div class="container"> 
      <div class="row"> 
          <div class="col-sm-6 offset-md-3">
              <h2 class="text-secondary"> Searche Here</h2>
              <form>
                  <div class="form-group">
                  <label class="col-form-label" for="formGroupExampleInput">Search by Email Address</label>
                  <input type="email" class="form-control" id="formGroupExampleInput" placeholder="Email Address">
                  </div>
                  <div class="form-group">
                  <label class="col-form-label" for="formGroupExampleInput2">Search by Name </label>
                  <input type="text" class="form-control" id="formGroupExampleInput1" placeholder="Name">
                  <input type="submit" class="button button-primary mt-3"> 
                   	<a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Create Registry','woothemes'); ?>" class="button btn-warning"><?php _e(' Create Registry','woothemes'); ?></a>

                  </div>
              </form>
      
          </div> 
      </div> 
    </div> 
    </section> 
        
        <?php

    endif;   
} ///wp_login_form_show closed


add_action( 'wp_ajax_delete_registry_item', 'delete_registry_item' );

function delete_registry_item() {
  global $wpdb; // this is how you get access to the database
  $rmvar=$_POST['rmvar']; 
  $rmpro=$_POST['rmpro'];
   $rmwpu=$_POST['rmwpu'];
  
  $wedding_registry_iteme = $wpdb->prefix."wedding_registry_item";
  $productcheck = $wpdb->get_row( 'SELECT * FROM '.$wedding_registry_iteme.' WHERE wish_id ='.$rmwpu.' AND product_id='.$rmpro.'', ARRAY_A);
  
   $productcheck_pro= $productcheck['product_id'];
   $productcheck_var= $productcheck['variation_id'];
   $productcheck_qty= $productcheck['quantity'];
   $productcheck_wish_id= $productcheck['wish_id'];
   
  
  
   if(isset($_POST['rmvar'])){
   
     $wedding_registry_item = $wpdb->prefix."wedding_registry_item";
  
     $rmpro=$_POST['rmpro'];
     $rmvar=$_POST['rmvar'];
     $rmwpu=$_POST['rmwpu'];
     if($rmpro == $productcheck_pro && $rmwpu == $productcheck_wish_id &&  $rmvar== $productcheck_var ){
  
       // $wpdb->query($wpdb->prepare( "UPDATE $wedding_registry_item SET quantity=CONCAT($qty+$productcheck_qty)  WHERE wish_id= $productcheck_wish_id AND variation_id= $productcheck_var"));
  
      //  }else 
      //  {
        //  error_log('true');
  
         $wpdb->delete( 
           $wedding_registry_item, 
           array( 
             'wish_id' => $rmwpu, 
             'product_id'  => $rmpro,
              'variation_id' => $rmvar  
           ),  
           array( 
             '%s', //data type is string
             '%s',
             '%s',
            
           ) 
         ); 
  
       }
  
   
   
   } 
    wp_die();
}

add_action( 'wp_ajax_add_registry_item_cart', 'add_registry_item_cart' );
add_action( 'wp_ajax_nopriv_add_registry_item_cart', 'add_registry_item_cart' );


function  add_registry_item_cart(){

  global $wpdb ;
  global $woocommerce;
  
  
  // add to 
  $quantities= $_POST['buy_qty'];
  $variation_id= $_POST['buy_var_id'];
  $product_id= $_POST['buy_pro_id'];
     
   WC()->cart->add_to_cart( $product_id, $quantities, $variation_id, $variation = array(), $cart_item_data = array() );


wp_die();

}



add_action('wp_ajax_save_registry_quantity', 'save_registry_quantity'); 

function  save_registry_quantity(){

 global $wpdb ;
 global $woocommerce;
 
 
 // add to 
 $quantities= $_POST['buy_qty'];
 $variation_id= $_POST['buy_var_id'];
 $product_id= $_POST['buy_pro_id'];
 $buy_prof_id= $_POST['buy_prof_id'];
 
 //  WC()->cart->add_to_cart( $product_id, $quantities, $variation_id, $variation = array(), $cart_item_data = array() );
 
 $wedding_registry_item = $wpdb->prefix."wedding_registry_item";
 error_log($wedding_registry_item);
 
         $wpdb->query($wpdb->prepare( "UPDATE $wedding_registry_item SET quantity=$quantities  WHERE wish_id= $buy_prof_id AND variation_id= $variation_id AND product_id=$product_id"));

//  $productcheck = $wpdb->get_row( 'SELECT * FROM '.$wedding_registry_iteme.' WHERE wish_id ='.$rmwpu.' AND product_id='.$product_id.'', ARRAY_A);
 

wp_die();

}

?>