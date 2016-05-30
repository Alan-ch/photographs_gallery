<?php 
require_once("../includes/initialize.php");?>

<?php 
// must have an ID
if(empty($_GET['id'])){
	$session->message("No photograph ID was provided");
	redirect_to("index1.php");
	
}
	$photo = Photograph::find_by_id($_GET['id']);
	
	if(!$photo ){// if does not exist
		$session->message("the photo could not be located");
	redirect_to("index1.php");
		
	}
	
	if(isset($_POST['submit'])){
		
		$author = trim($_POST['author']);
		$body = trim($_POST['body']);
		
		$new_comment = Comment::make($photo->id,$author,$body);// return an object of comment or false
		
	// to test before 
	    if($new_comment && $new_comment->save()) {// if true and the save succeed then
			// comment saved
			// No message needed; seen the comment is proof enough.
			
			// send email here (notification for new comment)
			$new_comment->try_to_send_notification();
			
			
			
			//Important ! you could just let the page render from here.
			// But then if the page is reloaded , the form will try to resubmit the comment. so redirect instead:
			redirect_to("photo.php?id={$photo->id}");
			// now its not a POST request it's a GET request and the author and the body get cleared from the form ..
	
		}else{
			// Failed
			$message = "there was an error that prevented the comment from being saved.";
			
			
		}
		
	
	}else{
		
		$author ="";
		$body="";
		
	}
	 //$comments = Comment::find_comments_on($photo->id); 
	 $comments = $photo->comments();
	
	
	
	// example of template chapter 
	// include('photo_template.php);
	// and delete all the code after this and replace by this template
	
	?>
	
	<?php include_layout_template('header.php'); ?>
	
	<a href="index1.php "> &laquo; Back </a> <br/><br/>
	
	<div style=" margin-left:20px ;">
  <img src="<?php echo $photo->image_path();?>" width="700px" height="700px" />   </a>
 
 <p> <?php echo $photo->caption; ?> </p>
 
 </div>
 
 <!-- list comments -->
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
		  	  
       </div>
     <?php endforeach;?>
	 <?php if(empty($comments)) {echo "No Comments.";}?>
	 
</div>
	 
			 
			
		  
			 
		
 
 <div id=" comment-form">
 
     <h3>New Comment </h3>
	 
	 <?php echo output_message($message); ?> <?php // output any error we have ?>
	 
	 <form action="photo.php?id=<?php echo $photo->id;?>" method="post">
	   <table>
	   
	     <tr>
		    <td>Your Name:</td>
			<td><input type="text" name="author" value="<?php echo $author;?>" /></td>
		 </tr>
         
		  <tr>
		    <td>Your Comment:</td>
			<td>  <textarea  name="body" cols="40" rows="8" ><?php echo $body;?> </textarea> </td>
		 </tr>
		 
		  <tr>
		    <td>&nbsp;</td>
			<td><input type="submit" name="submit" value="Submit Comment" /></td>
		 </tr>
		 
		</table>
	 
	 </form>
	 
</div>
		 
			
	 
	
	
	
	<?php include_layout_template('footer.php'); ?>
  


