<?php
require_once("../../includes/initialize.php");?>

<?php    if(!$session->is_logged_in()) {
	
redirect_to("login.php");} ?>
<?php

$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';

 if($_GET['clear']== 'true'){
	file_put_contents($logfile, '');// put nothing in the file
	//Add the first log entry 
 log_action('Logs cleared',"by User ID  {$session->user_id}");
 redirect_to('logfile.php?clear');// important
 // redirect to this same page so that the URL won't have "clear = true " anymore.
 }

 ?>
 
 <?php include_layout_template('admin_header.php');?>
 <a href="index.php "> &laquo; Back </a> <br/>
 <br/>
 <h2> Log File </h2>
 
 <p> <a href="logfile.php?clear=true"> clear log file </a>  </p>
 
 <?php 
 if(file_exists($logfile) && is_readable($logfile) && $handle = fopen($logfile,'r')){// read
 
    echo "<ul class= \"log_entries\">";// to use css
	
	  while(!feof($handle)){
		  
		  $entry = fgets($handle);// line by line
		  if(trim($entry)!=""){// to avoid an empty line
			  echo "<li> {$entry} </li>";
		  }
		  
	  }
	  echo "</ul>";
	  
	   fclose($handle);
	   
		  
	}else {
		
	echo " could not read from {$logfile}.";}
	
	?>
