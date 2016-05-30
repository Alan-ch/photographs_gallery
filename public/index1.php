<?php 
require_once("../includes/initialize.php");
//require_once("../includes/database.php");// load the database file
//require_once("../includes/functions.php");
//require_once("../includes/user.php");

//$junk = new Junk();
//$record = User::find_by_id(1);

?>
<?php 
 // 1.the current page number ($current_page)
  $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
  
  // 2. records per page ($per_page)
  $per_page=3;
  
  // 3.total record count ($total_count)
  $total_count = Photograph::count_all();


?>




<?php 
// here we ue pagination instead
// Find all the photos
// we call our static find all method 
//$photos = Photograph::find_all();// $photos an array of instances that we created

$pagination = new Pagination($page,$per_page,$total_count);
//Instead of finding all records , just find the records for this page.

$sql= " SELECT * FROM photographs ";
$sql .= "LIMIT {$per_page}";
$sql .= " OFFSET {$pagination->offset()}";

$photos = Photograph::find_by_sql($sql);

// Need to add ?page=$page to all links we want to maintain the  
//current page(or store $page in $session)


?>
<?php include_layout_template('header.php'); ?>

<h2>photographs</h2>
  
 
<a href="admin/login.php "> &laquo; Back </a> <br/>
<br/>



 <?php foreach($photos as $photo): // here i used colon : not { curly brackets} i can use either notation ?>
 <?php //in div we use some css just make each photos floating right next the other .. ?>
<div style="float: left; margin-left:15px ;">
 <a href="photo.php?id=<?php echo $photo->id;?>">  <img src="<?php echo $photo->image_path();?>" width="200" height="250" />   </a>
 
 <p> <?php echo $photo->caption; ?> </p>
 
 </div>
 
 
<?php endforeach ; ?>	

<div id="pagination" style="clear: both;" >
<?php

if($pagination->total_pages() > 1){
	
	if($pagination->has_previous_page()){
		echo "<a href =\"index1.php?page=";
		echo $pagination->previous_page();
		echo "\">&laquo; Previous </a>";
	}
	echo " &nbsp";
	
for($i=1 ; $i<= $pagination->total_pages(); $i++){
	
	if($i==$page){
		echo " <span class =\"selected\">{$i}</span>";
		echo "&nbsp";
	}else{
	
	echo " <a href =\"index1.php?page={$i}\">{$i} </a> ";
	echo "&nbsp";}
	
	
	
}
	
	
	
	echo " &nbsp";
	if($pagination->has_next_page()){
		echo "<a href =\"index1.php?page=";
		echo $pagination->next_page();
		echo "\">Next &raquo; </a>";
	}	
		
}	
		
		


?>


</div>


<?php include_layout_template('footer.php'); ?>












	 

































