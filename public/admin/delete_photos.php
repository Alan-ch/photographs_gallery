<?php
require_once("../../includes/initialize.php");?>

<?php    if(!$session->is_logged_in()) {
	
redirect_to("login.php");} ?>

<?php 
// must have an ID
if(empty($_GET['id'])){
	$session->message("No photograph ID was provided");
	redirect_to("index.php");
	
}
	$photo = Photograph::find_by_id($_GET['id']);
	if($photo){
	//$sql= "SELECT * FROM comments WHERE photograph_id ={$photo->id} ";
	//$result_set=Comment::find_by_sql($sql);
	//$nbcmt=$database->num_rows($result_set);
	if(!($photo->comments())) {
	   if( $photo->destroy()){// if does exist and a method to delete than ok.
		$session->message("the photo {$photo->filename} was deleted.");
	   redirect_to("list_photos.php");}else{
		   
		   // failed can't be destroyed 
		   $session->message("the photo could not be  deleted PB?");
	redirect_to("list_photos.php");
	   }
		
	}else{
		// failed the nb of coments is >0
		$session->message("the photo could not be  deleted because we still have ". count($photo->comments()) . " comments.");
	redirect_to("list_photos.php");
		
	}
	
	
	
	
	}else{
		$session->message("the photo could not be  deleted.");
	redirect_to("list_photos.php");
	}
  ?>
  
  <?php if(isset($database)){$database->close_connection();} 
  
  //here because i don't actually have a header and footer on this page , i am just going to do the little bit of housekeeping to make sure that my 
  // database connection is closed.
  // it closes by itself , but it is alaways a good practice to close it but yourself.
  ?>
  