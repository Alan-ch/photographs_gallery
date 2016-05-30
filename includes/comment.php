<?php 
// if it's going to need the database, then it's 
// probably smart to require it before we start

require_once(LIB_PATH.DS.'database.php');

class Comment extends DatabaseObject {
	
	protected static $table_name="comments";
	protected static $db_fields =array('photograph_id','created','author','body');
	
	public $id;
	public $photograph_id;
	public $created;
	public $author;
	public $body;
	
	// we create a method called make (like a factory that returns an instance to us).
	// "new" is a reserved word so we use "make" or "build"
	public static function make($photo_id, $author="Anonymous" , $body=""){
		// make check before the code always..
		if(!empty($photo_id) && !empty($author) && !empty($body)){
			
		$comment = new Comment();
		$comment->photograph_id=(int)$photo_id;
		$comment->created = strftime("%Y-%m-%d %H:%M:%S" , time());// we don't need to send time in make we use the current time by time().
		$comment->author=$author;
		$comment->body = $body;
		return $comment;
		}else{
			
			return false ;
		}
	}
	
	public static function find_comments_on($photo_id=0){
		
		global $database;
		$sql = "SELECT * FROM " . self::$table_name;
		$sql.= " WHERE photograph_id=" . $database->escape_value($photo_id);
		$sql.= " ORDER BY created ASC";
		return self::find_by_sql($sql);// will allow to us to find the comments that belong to that photograph.
		
		
		
	}
	
	public function try_to_send_notification(){
		
		
		
		
		
    //require_once("phpmailer/class.phpmailer.php");
	
    //require_once("phpmailer/class.smtp.php");
    $mail = new PHPMailer();

    // ---------- adjust these lines ---------------------------------------
    $mail->Username = "abc@gmail.com"; // your GMail user name
    $mail->Password = "xyz"; 
    $mail->AddAddress("abc@hotmail.com","photo Gallery Admin"); // recipients email
    $mail->FromName = "Photo_gallery"; // readable name

    $mail->Subject = "New photo Gallery Comment";
    //$mail->Body    = "A new comment has been received."; 
    //-----------------------------------------------------------------------

    $mail->Host = "smtp.gmail.com"; // GMail
    $mail->Port = 465;
	 $mail->SMTPSecure = 'ssl';
    $mail->IsSMTP(); // use SMTP
	$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // turn on SMTP authentication
    $mail->From = $mail->Username;
	
	$created= datetime_to_text($this->created);
	 $mail->Body    ="
A new comment has been received in the Photo Gallery \n\r

At {$created}, {$this->author} wrote:\n\r

	{$this->body}";

 
    if(!$mail->Send())
        echo "Mailer Error: " . $mail->ErrorInfo;
    else
        echo "Message has been sent";
  
	}
	
	
	
}

?>