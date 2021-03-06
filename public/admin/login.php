<?php 
// we cant use the path here because when this page first loads , it has know how to get that initialize.php
require_once("../../includes/initialize.php");


if($session->is_logged_in()) {
	
	redirect_to("index.php");
	
}

// remember to give your form's submit tag a name="submit" attribute!
if(isset($_POST['submit'])){
	// form has been submitted.
	
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	
	// check database to see if username/password exist.
	$found_user = User::authenticate($username,$password);
	if($found_user){
		
		$session->login($found_user);
		log_action('login',"{$found_user->username}:logged in");
		redirect_to("index.php");
		
	}else{
		// username/password combo was not found in the database
		
		$message = "Username /password combination incorrect.";
		
	}
	
}else{ // Form has not been submitted.
        $message="";
		$username = "";
		$password = "";
	}


?>

<html>

<head>
<title> photo Gallery </title>
<link href="../stylesheets/main.css" media="all" rel="stylesheet" type="text/css"/>
</head>

<body>
<div id="header">
  <h1> photo Gallery </h1>
  </div>
   
  <div id="main">
     <h2> Staff Login </h2>
	 <?php echo output_message($message); ?>
	 
	 <form action="login.php" method="post">
	 
	 <table>
	 
	 <tr>
	 <td> Username: </td>
	 <td> 
	 <input type = "text" name= "username" maxlength="30" value="<?php echo htmlentities($username); ?>" />
	 </td>
	 </tr>
	 
	 <tr>
	 <td> Password: </td>
	 <td> 
	 <input type = "password" name= "password" maxlength="30" value= "<?php echo htmlentities($password); ?>" />
	 </td>
	 </tr>
	 
	 <tr>
	 <td colspan="2">
	 <input type = "submit" name= "submit" value= "Login " />
	 </td>
	 </tr>
	 
	 </table>
	 
	 </form>
	 <a href="../index1.php "> &laquo; view photos </a> <br/>
	 
	 </div>
	 
	 
	 <div id="footer"> copyright <?php echo date("Y",time());?>, Allam Chaeib </div>
</body>

</html>	 
<?php if(isset($database)){$database->close_connection();}