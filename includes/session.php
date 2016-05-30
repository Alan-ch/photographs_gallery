<?php 




	// A class to help work with Sessions
	// In our case , primarily to manage logging users in and out
	
	// keep in mind when working with sessions that it is generally 
	// indivisable to store DB_related objects in sessions
	
	class Session{
	
	  private $logged_in = false ;
	  public $user_id;
	  public $message ;
	  
	  
	
	  
	   function __construct(){
		   // it figures out the cookie and it binds the session for us.(if there wasn't a previous session than create one).
		  session_start(); 
		   $this->check_login();
		   
		   //check and see if we have any messages that have previously been set.
		   $this->check_message();
		   
		   if($this->logged_in){
			   
			  // actions to take right away if user is logged in 
		   }else{
			   // actions to take right away if user is not logged in
			   
		   }
        }
		
		// check if the person is logged in or not..(this is like the bank teller!!).[we can read but we cant write to $logged_in]
		public function is_logged_in(){
			return $this->logged_in;
		}
		
		// when someone logs in from a webpage. so they enter they username and password
		public function login($user){
			// database should find user based on username/password
			if($user){
				$this->user_id = $_SESSION['user_id'] = $user->id;
				$this->logged_in = true ;
				
				
			}
			
		}
		public function logout(){
			unset($_SESSION['user_id']);
			unset($this->user_id);
			$this->logged_in = false ;
			
		}
		
		
		private function check_login(){
			
			if(isset($_SESSION['user_id'])) {
				$this->user_id = $_SESSION['user_id'];
				$this->logged_in = true ;
				
			} else {
				unset($this->user_id);
				$this->logged_in = false ;
				
			}
			
			
		}
		
		private function check_message(){
			// Is there a mesage stored in the SESION array?
			if(isset($_SESSION['message'])){
				// Add it as an attribute and erase the stored version
				
				$this->message = $_SESSION['message'];
				unset($_SESSION['message']);
			}else{
				$this->message="";
			}
			
			
		}
		
		  // this function has dual duty set_message and get_message according to $msg.
		  // so PHP can tell the difference between the function called message and the attribute called message.
		public function message($msg=""){// $msg its optional it may not be sent.
		
		  if (!empty($msg)){
			  
			  // here "set_message"
			  // make sure you understand why $this->message = $msg wouldn't work.//-> difference between global array SESSION and a object Session.
			  $_SESSION['message']=$msg;
			  
		  }else{
			  // here "get_message"
			  return $this->message;
		  }
			
			
			
		}
		
		
		
		
	}
	$session = new Session();
	$message=$session->message();// get_message
	
	
	
?>