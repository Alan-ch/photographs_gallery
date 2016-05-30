<?php
require_once("../../includes/initialize.php");?>

<?php    if(!$session->is_logged_in()) {
	
redirect_to("login.php");} ?>

<?php 
// must have an ID
if(empty($_GET['id'])){
	$session->message("No comment ID was provided");
	redirect_to("list_photos.php");
	
}
	$comment = Comment::find_by_id($_GET['id']);
	if($comment && $comment->delete()){// if does exist and a method to delete than ok.
		$session->message("the comment of {$comment->author} was deleted.");
	redirect_to("comments.php?id= {$comment->photograph_id}" );
		
	}else{
		$session->message("the comment could not be  deleted.");
		redirect_to("comments.php?id= {$comment->photograph_id}" );
	}
  ?>
  
  <?php if(isset($database)){$database->close_connection();} 
  
  //here because i don't actually have a header and footer on this page , i am just going to do the little bit of housekeeping to make sure that my 
  // database connection is closed.
  // it closes by itself , but it is alaways a good practice to close it but yourself.
  ?>
  