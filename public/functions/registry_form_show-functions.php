<?php 
function registry_form_show(){ 

  
  global $wpdb;
  $registry_wishlist_table = $wpdb->prefix."wedding_registry_wishlists"; 
  $wpu_id=  get_current_user_id(); 
   
  $checkuser = $wpdb->get_row( 'SELECT wpuser_id FROM '.$registry_wishlist_table.' WHERE wpuser_id ='.$wpu_id.'', ARRAY_A);
  
  
  $cwhck= $checkuser['wpuser_id'];
 

  if($cwhck == $wpu_id):
    
  $results = $wpdb->get_results( 'SELECT * FROM '.$registry_wishlist_table.' WHERE wpuser_id ='.$wpu_id.'', OBJECT);
  foreach ( $results as $result ): 
   ?>
<section>
    <div class="container"> 
        <div class="row"> 
            <div class="col-sm-12">
                <h2 class="text-secondary text-center"> Edit Your Registry Here</h2>
                <form id="editRegistry" name="editRegistry" action="" method="post">
                <div class="form-row">
                      <label for="inputTitle">Title</label> 
                      <input type="text" class="form-control" id="inputitle" name="inputitle" placeholder="Place Your Title" value="<?php if (is_object($result)) : echo $result->title; endif;?>"> 
                </div>  
                
                <div class="form-row pt-2 pb-2">
                  <h4 class="active">Groom Info</h4>
                </div>  
                <div class="form-row  p-0">
                  <div class="form-group col-md-6">
                    <label for="groom_firstname">Groom First Name</label>
                    <input type="text" class="form-control" id="groom_firstname" name="groom_firstname" placeholder="Groom First Name" value="<?php if (is_object($result)) : echo $result->goorm_firstname; endif;?>">
                  </div>
                  <div class="form-group col-md-6">
                  <label for="groom_lastname">Groom Last Name</label>
                  <input type="text" class="form-control" id="groom_lastname" name="groom_lastname" placeholder="Groom Last Name" value="<?php if (is_object($result)) : echo $result->goorm_lastname; endif;?>">
                  </div>
                </div>
                <div class="form-row  p-0">
                  <div class="form-group col-md-6">
                    <label for="groom_email">Groom Email</label>
                    <input type="email" class="form-control" id="groom_email" name="groom_email" placeholder="Groom Email" value="<?php if (is_object($result)) : echo $result->goorm_email; endif;?>" >
                  </div>
                  <div class="form-group col-md-6">
                  <label for="groom_mobile">Groom Mobile</label>
                  <input type="text" class="form-control" id="groom_mobile" name="groom_mobile" placeholder="Groom Mobile" value="<?php if (is_object($result)) : echo $result->goorm_mobile; endif;?>"> 
                  </div>
                </div> 
                <div class="form-row pt-2 pb-2">
                  <h4 class="active">Bride Info</h4>
                </div> 
                
                <div class="form-row  p-0">
                  <div class="form-group col-md-6">
                    <label for="bride_firstname">Bride First Name</label>
                    <input type="text" class="form-control" id="bride_firstname" name="bride_firstname" placeholder="Bride First Name" value="<?php if (is_object($result)) : echo $result->bride_firstname; endif;?>">
                  </div>
                  <div class="form-group col-md-6">
                  <label for="bride_lastname">Bride Last Name</label>
                  <input type="text" class="form-control" id="bride_lastname" name="bride_lastname" placeholder="Bride Last Name" value="<?php if (is_object($result)) : echo $result->bride_lastname; endif;?>">
                  </div>
                </div>
                <div class="form-row  p-0">
                  <div class="form-group col-md-6">
                    <label for="bride_email">Bride Email</label>
                    <input type="email" class="form-control" id="bride_email" name="bride_email" placeholder="Bride Email"  value="<?php if (is_object($result)) : echo $result->bride_email; endif;?>">
                  </div>
                  <div class="form-group col-md-6">
                  <label for="bride_mobile">Bride Mobile</label>
                  <input type="text" class="form-control" id="bride_mobile" name="bride_mobile" placeholder="Groom Mobile" value="<?php if (is_object($result)) : echo $result->bride_mobile; endif;?>">
                  </div>
                </div> 
                <div class="form-row pt-2 pb-2">
                  <h4 class="active">General Info</h4>
                </div> 
                
                <div class="form-row  p-0">
                  <div class="form-group col-md-6">
                    <label for="wedding_date">Event Date</label>
                    <input type="text" class="form-control" id="wedding_date" name="wedding_date" placeholder="Select Event Date" value="<?php if (is_object($result)) : echo $result->event_date_time; endif;?>">
                  </div>
                  <div class="form-group col-md-6">
                  <label for="event_location">Event location </label>
                  <input type="text" class="form-control" id="event_location" name="event_location" placeholder="Your Event location " value="<?php if (is_object($result)) : echo $result->event_location; endif;?>">
                  </div>
                </div> 
                <div class="form-row ">
                    <label for="message">Message for guests</label>
                    <textarea rows="10" cols="" name="message" class="form-control" id="message" placeholder="Messages..."><?php if (is_object($result)) : echo $result->message; endif;?></textarea> 
                </div>  

                <div class="form-row">
                <div id="display" class="col-sm-12"> </div>
                <button type="submit" class="btn btn-primary col-sm-5 offset-sm-4" name="submit"  id="submit">Save</button>
                </div>    
              </form> 
        
            </div> 
        </div> 
    </div> 
</section>
<?php        
break; 
endforeach;
else:
?>

<section>
    <div class="container"> 
        <div class="row"> 
            <div class="col-sm-12">
                <h2 class="text-secondary text-center"> Edit Your Registry Here</h2>
                <form id="editRegistry" name="editRegistry" action="" method="post">
                <div class="form-row">
                      <label for="inputTitle">Title</label> 
                      <input type="text" class="form-control" id="inputitle" name="inputitle" placeholder="Place Your Title" > 
                </div>  
                
                <div class="form-row pt-2 pb-2">
                  <h4 class="active">Groom Info</h4>
                </div>  
                <div class="form-row  p-0">
                  <div class="form-group col-md-6">
                    <label for="groom_firstname">Groom First Name</label>
                    <input type="text" class="form-control" id="groom_firstname" name="groom_firstname" placeholder="Groom First Name" >
                  </div>
                  <div class="form-group col-md-6">
                  <label for="groom_lastname">Groom Last Name</label>
                  <input type="text" class="form-control" id="groom_lastname" name="groom_lastname" placeholder="Groom Last Name" >
                  </div>
                </div>
                <div class="form-row  p-0">
                  <div class="form-group col-md-6">
                    <label for="groom_email">Groom Email</label>
                    <input type="email" class="form-control" id="groom_email" name="groom_email" placeholder="Groom Email"  >
                  </div>
                  <div class="form-group col-md-6">
                  <label for="groom_mobile">Groom Mobile</label>
                  <input type="text" class="form-control" id="groom_mobile" name="groom_mobile" placeholder="Groom Mobile"  > 
                  </div>
                </div> 
                <div class="form-row pt-2 pb-2">
                  <h4 class="active">Bride Info</h4>
                </div> 
                
                <div class="form-row  p-0">
                  <div class="form-group col-md-6">
                    <label for="bride_firstname">Bride First Name</label>
                    <input type="text" class="form-control" id="bride_firstname" name="bride_firstname" placeholder="Bride First Name" >
                  </div>
                  <div class="form-group col-md-6">
                  <label for="bride_lastname">Bride Last Name</label>
                  <input type="text" class="form-control" id="bride_lastname" name="bride_lastname" placeholder="Bride Last Name"  >
                  </div>
                </div>
                <div class="form-row  p-0">
                  <div class="form-group col-md-6">
                    <label for="bride_email">Bride Email</label>
                    <input type="email" class="form-control" id="bride_email" name="bride_email" placeholder="Bride Email"  >
                  </div>
                  <div class="form-group col-md-6">
                  <label for="bride_mobile">Bride Mobile</label>
                  <input type="text" class="form-control" id="bride_mobile" name="bride_mobile" placeholder="Groom Mobile"  >
                  </div>
                </div> 
                <div class="form-row pt-2 pb-2">
                  <h4 class="active">General Info</h4>
                </div> 
                
                <div class="form-row  p-0">
                  <div class="form-group col-md-6">
                    <label for="wedding_date">Event Date</label>
                    <input type="text" class="form-control" id="wedding_date" name="wedding_date" placeholder="Select Event Date"  >
                  </div>
                  <div class="form-group col-md-6">
                  <label for="event_location">Event location </label>
                  <input type="text" class="form-control" id="event_location" name="event_location" placeholder="Your Event location " >
                  </div>
                </div> 
                <div class="form-row ">
                    <label for="message">Message for guests</label>
                    <textarea rows="10" cols="" name="message" class="form-control" id="message" placeholder="Messages..."></textarea> 
                </div>  

                <div class="form-row">
                <div id="display" class="col-sm-12"> </div>
                <button type="submit" class="btn btn-primary col-sm-5 offset-sm-4" name="submit"  id="submit">Save</button>
                </div>    
              </form> 
        
            </div> 
        </div> 
    </div> 
</section>

<?php

endif;


 
?> 

<script>

 
jQuery(document).ready(function(){
	
	 
		jQuery( "form#editRegistry #submit" ).click(function( event ) { 

		 jQuery('form#editRegistry #submit').html('Saving...');
     var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";


			var title=	$('#inputitle').val();
			var g_fname=	$('#groom_firstname').val();
			var g_lname=	$('#groom_lastname').val();
			var g_email=	$('#groom_email').val();
			var g_mobile=	$('#groom_mobile').val();
			var b_fname=	$('#bride_firstname').val();
			var b_lname=	$('#bride_lastname').val();
			var b_email=	$('#bride_email').val();
			var b_mobile=	$('#bride_mobile').val();
			var wedding_date=	$('#wedding_date').val();
			var event_location=	$('#event_location').val();
			var message=	$('#message').val();

      var valid = [title,g_fname,g_lname,g_email,g_mobile,b_fname,b_lname,b_email,b_mobile,wedding_date,event_location,message];
			
			
			// var values = $(this).serialize();

    var data = {
			'action': 'my_action',
      'title':valid[0],
      'g_fname':valid[1],
      'g_lname':valid[2],
      'g_email':valid[3],
      'g_mobile':valid[4],
      'b_fname':valid[5],
      'b_lname':valid[6],
      'b_email':valid[7],
      'b_mobile':valid[8],
      'w_date':valid[9],
      'e_location':valid[10],
      'e_message':valid[11]
 
    };
     
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response, textStatus, jqXHR) {
      jQuery('form#editRegistry #submit').html('Save');

      if(textStatus="success"){
        $("button#submit").notify(
        "Saved Your Detiles",
        { position:"left", className: "success"  }
      );

      jQuery('form#editRegistry #submit').html('Save');

      }else{

        $("button#submit").notify(
        "Your Detiles are not saved",
        { position:"left", className: "error"  }
      );

      jQuery('form#editRegistry #submit').html('Save');
      }
  
      
    });
 
    event.preventDefault();
 
	 });

 

  jQuery( function() {
 
    jQuery( "#wedding_date" ).datepicker({
      showAnim: 'drop',
      minDate:0,
      dateFormat:'dd-mm-yy',
      timepickerScrollbar:'true',
      } );
 
  } );

});
  </script>

<?php
      
 }
 ?>