<?php
require_once(LIB_PATH.DS.'database.php');
class  DatabaseObject {
	
	
	
	
		// common Database Methods
	public static function find_all() {
		
		// self or User we can use both..
		//global $database;
		//$result_set = $database->query("SELECT * FROM users");
		 return static::find_by_sql("SELECT * FROM ".static::$table_name);
		 
		
	}
	
	public static function find_by_id($id=0) {
		
		
		global $database;
		$result_array = static::find_by_sql("SELECT * FROM ".static::$table_name."  WHERE id=". $database->escape_value($id)." LIMIT 1 ");
		//$result_set = $database->query("SELECT * FROM users WHERE id={$id}");
		//$found = $database->fetch_array($result_set);
	    return !empty($result_array) ? array_shift($result_array) : false;
	/*   if(!empty($result_array)){
	   return array_shift($result_array);}
	   else{
		   return false;
	   }*/
		// another solution here.
		//return $result_array[0];
		
		
	}
	
	public static function find_by_sql($sql=""){
		
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while($row = $database->fetch_array($result_set)){
			$object_array[]= static::instantiate($row);
		}
		return $object_array;
		
		
	}

	public static function count_all(){
		global $database;
		$sql = "SELECT COUNT(*) FROM ".static::$table_name;
		$result_set = $database->query($sql);
		$row=$database->fetch_array($result_set);
		return array_shift($row);
		
		
		
	}
	private static  function instantiate($record){
		// could check that $record exists and is an array
		//$object      = new self;
		$object  = new static ;
		//or $class_name= get_called_class();
		//$object = new $class_name;
/* $object->id         = $record['id'];
 $object->username   = $record['username'];
 $object->password   = $record['password'];
 $object->first_name = $record['first_name'];
 $object->last_name  = $record['last_name'];
 return $object;
 */
 
 // More dynamic , short _form approach:
 foreach($record as $attribute => $value){
	 if($object->has_attribute($attribute)){
		 
		 $object->$attribute = $value;
	 }
 }
 return $object;
 
 
 
 
	}
	
	protected  function attributes(){
		 // return an associate array of attribute keys and their values
		 
		 $attributes = array();
		 foreach(static::$db_fields as $field){
			 
			 if(property_exists($this,$field)){
				 $attributes[$field] = $this->$field ;// here $this->field we use dynamique field to access.
				 // key or name       =   value
			 }
			 
		 }
		 return $attributes ;// the new array of attributes who corresspond to db attributes.
		 }
		 
		//return get_object_vars($this);
		 
		 
	 
	 
	protected  function sanitized_attributes(){
		 
		 global $database ;
		 $clean_attributes = array();
		 
		 // sanitize the values before submitting 
		 // note : does not alter the actual value of each attribute 
		 
		 foreach($this->attributes() as $key => $value){
			 
			 $clean_attributes[$key] = $database->escape_value($value);
			 
		 }
		 return $clean_attributes;
		  
	 }
	
	private function has_attribute($attribute){
		// get_object_vars returns an associative array with all attributes 
		// (incl. private ones!) as the keys and their current values as the value
		
		$object_vars = get_object_vars($this);
		// we don't care about the value , we just want to know if the key exists 
		// will return true or false.
		
		return array_key_exists($attribute,$object_vars);
		
		
	}
	public function save(){
		
		// A new record won't have an id yet.
		
		return isset($this->id) ? $this->update() : $this->create();
		
	}
	
    public  function create(){
		 
		 global $database ;
		 // Don't forget your SQL syntax and good habits:
		 // - INSERT INTO table (key,key) VALUES ('value','value')
		 // - single_quotes around all values
		 // - escape all values to prevent SQL injection 
		 
		 $attributes  = $this->sanitized_attributes();
		 
		 $sql = "INSERT INTO ". static::$table_name." (";// users we define it on the top by $table_name
		 $sql .= join(", ",array_keys($attributes));
		//$sql .= "filename,type,size,caption";
		 $sql .= ") VALUES ('";
		 
		/* $sql .= $database->escape_value($this->filename) ."', '";
		 $sql .= $database->escape_value($this->type) ."', '";
		 $sql .= $database->escape_value($this->size) ."', '";
	     $sql .= $database->escape_value($this->caption) ."')"; */
		 
		$sql .= join("', '", array_values($attributes));
		 $sql .= "')";
		 
		   if($database->query($sql)){
			   $this->id =$database->insert_id();// $id attribute of the object we must update it because id i don't know what is the id increment(auto increment ) in the database..
			   return true ;
		   }else {
			   return false;
		   }
			   
		   }
		   
	public function update(){
			 global $database ;
		 // Don't forget your SQL syntax and good habits:
		 // - UPDATE table SET KEY='value', key='value' WHERE condition
		 // - single_quotes around all values
		 // - escape all values to prevent SQL injection 
		 $attributes  = $this->sanitized_attributes();
		 
		 $attribute_pairs = array();
		 
		 foreach($attributes as $key => $value){
			 
			 $attribute_pairs[] ="{$key}='{$value}'";
		 }
		 
		 $sql = "UPDATE ".static::$table_name." SET ";
		 $sql.= join(", ", $attribute_pairs);
		 
		/* $sql .= "username='". $database->escape_value($this->username) ."', ";
		 $sql .= "password='". $database->escape_value($this->password) ."', ";
		 $sql .= "first_name='". $database->escape_value($this->first_name) ."', ";
		 $sql .= "last_name='". $database->escape_value($this->last_name) ."'"; */
		 
		 $sql .= " WHERE id=". $database->escape_value($this->id) ;// space before WHERE
		  $database->query($sql);
		  return ($database->affected_rows() == 1) ? true : false ;
		}
	 
	public function delete(){
		   global $database ;
		 // Don't forget your SQL syntax and good habits:
		 // - DELETE FROM table WHERE condition LIMIT 1
		 // - escape all values to prevent SQL injection 
		 // - use LIMIT 1
		 
		 $sql = "DELETE FROM ".static::$table_name;
		 $sql .= " WHERE id=". $database->escape_value($this->id);// id of the current object
		 $sql .= " LIMIT 1";
		 
		 $database->query($sql);
		 return ($database->affected_rows() == 1) ? true : false;
		  
		  
	  }
	
	
	
}
	












?>