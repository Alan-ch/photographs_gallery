<?php 
require_once("../../includes/initialize.php");
//require_once('../../includes/functions.php');
//require_once('../../includes/session.php');
//require_once('../includes/database.php')
if(!$session->is_logged_in()) {
	redirect_to("login.php");
	
}?>
<?php 
// you may want to note , mx_file_size is a potential candidate for something that could be a static attribute of our photograph class.
$max_file_size  = 1048576;  // expressed in bytes 
							//   10240 = 10 KB
							//   102400 = 100 KB
							// 1048576 = 1 MB
							//  10485760 = 10 MB
	
	
if(isset($_POST['submit'])){
   $photo = new Photograph();
   $photo->caption = $_POST['caption'];
$photo->attach_file($_FILES['file_upload']);   
  
  if($photo->save_with_file()){
	  // sucess
	  
	 $session->message( " photograph uploaded successfully.");
	 redirect_to("list_photos.php");
	  
  }else{
	  // failure
	  // we'll join together whatever errors the object has , // array of errors join them together with the br tag.
	  $message = join("<br/>",$photo->errors);
	  
  }
}
							
?>
<?php include_layout_template('admin_header.php');?>
   
   <h2> Photo Upload </h2>
   
   <?php echo output_message($message); ?>
   
   <form action ="photo_upload.php" enctype="multipart/form-data" method="POST">
   
     <input type ="hidden" name ="MAX_FILE_SIZE" value ="<?php echo $max_file_size; ?>" />
	 
	 <p> <input type ="file" accept="image/*" name ="file_upload" /> </p>
	 
	 <p> Caption : <input type ="text" name="caption" value ="" /> </p>
	 
	 <input type ="submit" name="submit" value =" Upload" />
	 
	 </form>
   


   
   
	 
<?php include_layout_template('admin_footer.php');?>
	 
	 
	 


