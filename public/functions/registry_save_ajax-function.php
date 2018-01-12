<?php



function my_action() {
	global $wpdb; // this is how you get access to the database

$wpu_id=  get_current_user_id();
$contactus_table = $wpdb->prefix."wedding_registry_wishlists";


$checkuser = $wpdb->get_row( 'SELECT wpuser_id FROM '.$contactus_table.' WHERE wpuser_id ='.$wpu_id.'', ARRAY_A);


$cwhck= $checkuser['wpuser_id'];
// error_log($cwhck == $wpu_id);
if($cwhck == $wpu_id){


$title=$_POST['title'];
$g_fname=$_POST['g_fname'];
$g_lname=$_POST['g_lname'];
$g_email=$_POST['g_email'];
$g_mobile=$_POST['g_mobile'];
$b_fname=$_POST['b_fname'];
$b_lname=$_POST['b_lname'];
$b_email=$_POST['b_email'];
$b_mobile=$_POST['b_mobile'];
$w_date=$_POST['w_date'];
$e_location=$_POST['e_location'];
$e_message=$_POST['e_message'];
 
 

$registry_wishlists = $wpdb->prefix."wedding_registry_wishlists";
 $wpdb->update( 
   $registry_wishlists, 
   array( 
      'title' => $title, 
      'wpuser_id' => $wpu_id, 
      'goorm_firstname'  => $g_fname,
      'goorm_lastname'  => $g_lname,
      'goorm_email' => $g_email,
      'goorm_mobile' => $g_mobile,
      'bride_firstname' => $b_fname,
      'bride_lastname' => $b_lname,
      'bride_email' => $b_email,
      'bride_mobile' => $b_mobile,
      'event_date_time' => $w_date,
      'event_location' => $e_location,     
      'message' => $e_message,
      
   ),
   array( 'wpuser_id' => $wpu_id ), 
   
   array( 
     '%s', //data type is string
     '%s',
     '%s',
     '%s',
     '%s',
     '%s', //data type is string
     '%s',
     '%s',
     '%s',
     '%s',
     '%s'  
   ), 
   array( '%d' ) 
   
   
 );



}else{



  $title=$_POST['title'];
  $g_fname=$_POST['g_fname'];
  $g_lname=$_POST['g_lname'];
  $g_email=$_POST['g_email'];
  $g_mobile=$_POST['g_mobile'];
  $b_fname=$_POST['b_fname'];
  $b_lname=$_POST['b_lname'];
  $b_email=$_POST['b_email'];
  $b_mobile=$_POST['b_mobile'];
  $w_date=$_POST['w_date'];
  $e_location=$_POST['e_location'];
  $e_message=$_POST['e_message'];
   
  
   
  $registry_wishlists = $wpdb->prefix."wedding_registry_wishlists";
   $wpdb->insert( 
     $registry_wishlists, 
     array( 
        'title' => $title, 
        'wpuser_id' => $wpu_id, 
        'goorm_firstname'  => $g_fname,
        'goorm_lastname'  => $g_lname,
        'goorm_email' => $g_email,
        'goorm_mobile' => $g_mobile,
        'bride_firstname' => $b_fname,
        'bride_lastname' => $b_lname,
        'bride_email' => $b_email,
        'bride_mobile' => $b_mobile,
        'event_date_time' => $w_date,
        'event_location' => $e_location,     
        'message' => $e_message,
        
     ), 
     array( 
       '%s', //data type is string
       '%s',
       '%s',
       '%s',
       '%s',
       '%s', //data type is string
       '%s',
       '%s',
       '%s',
       '%s',
       '%s'  
     ) 
   );

}
   
  

	wp_die(); // this is required to terminate immediately and return a proper response
}


?>