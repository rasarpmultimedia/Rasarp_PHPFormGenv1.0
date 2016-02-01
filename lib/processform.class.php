<?php
/** 
  * Please Do not remove this comment, this class can be modified based on the GNU Public License
  * @author Sarpong Abdul-Rahman <fadanash@gmail.com>
  * @license GPL
  * @license http://opensource.org/licenses/gpl-license.php GNU Public License
  * @Released on 30th Oct 2015
  * @Version 1.0.0
  */
include_once"form.class.php";
/*
Form Processing Class this class is use to create forms validate and process form all at once*/
class  ProcessForm{
	 public $successflag = true;
	 public $errorinfo = array();//add each error to the end of this array
	 public $successmsg="";
	 public $message;
	 public function submitForm(){
	 	  return ($_SERVER["REQUEST_METHOD"]=="POST"?true:false);
	 } 
	 public function post($poststr,$input_val=''){
	 	return (isset($_POST[$poststr]))?trim(filter_var($_POST[$poststr],FILTER_SANITIZE_STRING)):htmlentities($input_val);
	 }
	 public function postFiles($poststr,$input_val=''){
	 	return (isset($_FILES[$poststr]["name"]))?strip_tags($_FILES[$poststr]["name"]):htmlspecialchars($input_val);
	 }
	//displays both errors and success messages
	 public function message($msg=''){
	 	//if no errors are found
	 if(count($this->errorinfo)==0 && $this->successflag == true){
	   $this->successmsg .= $msg;
	 }else{
	 	// Display Error Msg Here
		  if(count($this->errorinfo)==1){
		  	$this->successflag = false;
		  	$msg = "There is ".count($this->errorinfo)." error in the form field";
		  }elseif(count($this->errorinfo) > 1){
		  	$this->successflag = false;
		  	$msg = "There are ".count($this->errorinfo)." errors in the form fields";
		  }
		} 
	   return $this->message = ($this->successflag==true)?"<p class=\"successmsg\">".$this->successmsg."</p>":"<p class=\"error\">".$msg."</p>";
	 }
      /* This function validate input forms */
	 public static function validate(){
	 	return new FormValidator;
	 	
	 }
}

?>