<?php
require_once("../../includes/initialize.php");?>

<?php    if(!$session->is_logged_in()) {
	
redirect_to("login.php");} ?>

<?php 
// Find all the photos
// we call our static find all method 
//$photos = Photograph::find_all();// $photos an array of instances that we created


// 1.the current page number ($current_page)
  $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
  
  // 2. records per page ($per_page)
  $per_page=5;
  
  // 3.total record count ($total_count)
  $total_count = Photograph::count_all();

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
<?php include_layout_template('admin_header.php'); ?>
<h2>photographs</h2>
  <?php echo output_message($message); ?>
<table class = "bordered">
<tr>
	<th> Image </th>
	<th> Filename  </th>
	<th> Caption  </th>
	<th> Size   </th>
	<th> Type   </th>
	<th> Comments  </th>
	<th> &nbsp;  </th>
 </tr>
 <?php foreach($photos as $photo): // here i used colon : not { curly brackets} i can use either notation ?>
 <tr>
	<td><img src="../<?php echo $photo->image_path();?>" width="100" /></td>
    <td><?php echo $photo->filename ; ?></td>
    <td><?php echo $photo->caption ; ?></td>
	<td><?php echo $photo->size_as_text() ;?></td>
	<td><?php echo $photo->type ;?></td>
	<td> <a href="comments.php?id=<?php echo $photo->id; ?>" ><?php echo count($photo->comments())?> Comments </a> </td>
	<td> <a href="delete_photos.php?id=<?php echo $photo->id; ?>" > Delete photo </a> </td>
	
	
</tr>
<?php endforeach ; ?>	
</table>
<br/>
<br/>
<div id="pagination" >
<?php

if($pagination->total_pages() > 1){
	
	if($pagination->has_previous_page()){
		echo "<a href =\"list_photos.php?page=";
		echo $pagination->previous_page();
		echo "\">&laquo; Previous </a>";
	}
	echo " &nbsp";
	
for($i=1 ; $i<= $pagination->total_pages(); $i++){
	
	if($i==$page){
		echo " <span class =\"selected\">{$i}</span>";
		echo "&nbsp";
	}else{
	
	echo " <a href =\"list_photos.php?page={$i}\">{$i} </a> ";
	echo "&nbsp";}
	
	
	
}
	
	
	
	echo " &nbsp";
	if($pagination->has_next_page()){
		echo "<a href =\"list_photos.php?page=";
		echo $pagination->next_page();
		echo "\">Next &raquo; </a>";
	}	
		
}	
		
		


?>


</div>
<br/>

<a href="photo_upload.php"> Upload a new photograph </a>
<br/>
<br/>
<br/>
<a href="index.php "> &laquo; Back </a> <br/>

<?php include_layout_template('admin_footer.php'); ?>












	 