<?php

error_log('asdadasdasda');

 
 global $wpdb;
 $prefix= $wpdb->prefix;
 $table = $prefix."wedding_registry_wishlists";

 var_dump($_POST);
 // or
 print_r($_POST);

 error_log('aedfasdad');


$mail=$_POST['bride_email'];

error_log($maile);
error_log('asdadad');
 

$wpdb->insert($table, array('goorm_email' => $mail));


   
if(isset($_POST['bride_email'])){ 
 echo'dfgdfgdfg';
}
?>