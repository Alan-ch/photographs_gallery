<?php
require_once("../../includes/initialize.php");?>

<?php    if(!$session->is_logged_in()) {
	
redirect_to("login.php");} ?>

<?php 
$photo = Photograph::find_by_id($_GET['id']);

if(!$photo ){// if does not exist
		$session->message("the photo could not be located");
	redirect_to("list_photos.php");
		
	}
	

 $comments = $photo->comments();
?>
<?php include_layout_template('admin_header.php'); ?>
<h2>comments on <?php echo $photo->filename;?></h2>


<?php echo output_message($message); ?>

<div id="comments">
 
     <?php foreach($comments as $comment): ?>
	    <div class="comment" style="margin-bottom:2em;">
		
		  <div class="author">
		     <?php echo htmlentities($comment->author);?> wrote: 
		  </div>
		  
		  <div class="body">
		      <?php echo strip_tags($comment->body,'<strong><em><p>');?>
		  </div>
		  
		  <div class="meta-info" style=" font-size: 0.8em;">
		     <?php echo datetime_to_text($comment->created);?>
		  </div>
		  
		  <div class="actions" style="font-size : 0.8em;">
		     <a href="delete_comment.php?id=<?php echo $comment->id;?>">  Delete Comment </a>
			 
			 </div>
		  	  
       </div>
     <?php endforeach;?>
	 <?php if(empty($comments)) {echo "No Comments.";}?>
	 
</div>


	
	 

<br/>
<br/>
<a href="list_photos.php "> &laquo; Back </a> <br/>

<?php include_layout_template('admin_footer.php'); ?>