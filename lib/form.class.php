<?php
/** 
  * Please Do not remove this comment, this class can be modified based on the GNU Public License
  * @author Sarpong Abdul-Rahman <fadanash@gmail.com>
  * @license GPL
  * @license http://opensource.org/licenses/gpl-license.php GNU Public License
  * @Released on 30th Oct 2015
  * @Version 1.0.0
  */
/*
 * Class Create Html Form from a class */
class Form{
	 //form attributes
	 private $htmlForm;
	
	 private  $formName;
	 private $action;
	 private $method;
	 protected $inputName;
	 private   $extra_attr;
	 
	 private $formInputs = array(); 
	 private $groupFormInputs = array();
	 public  $selOptions = array();
     public $dataListOptions = array();
	 
	 function __construct($name,$action="",$method="get",$extra_attr=""){
		$this->formName = $name;
		$this->action   =  $action;
		$this->method   = $method;
		$this->extra_attr  = $extra_attr;
		
	 }
	 public function startForm(){
	 	$this->htmlForm = "<form action=\"{$this->action}\" name=\"{$this->formName}\" id=\"{$this->formName}\" method=\"{$this->method}\" {$this->extra_attr}> \n";
		return $this->htmlForm;
	 }
    
	 public function inputLabel($for,$name){
	    return"<label for=\"$for\">$name:</label>";
	 }
    
	 public function addFormElem($element){
         $this->setFormField(null,$element);
     }
    
     public  function inputField($type,$name,$value='',$optional_attr=''){
        return"<input type=\"{$type}\" name=\"{$name}\" id=\"{$name}\" value=\"{$value}\" $optional_attr>";
                }
     public  function uploadField($id,$name,$optional_attr=''){
        return"<input type=\"file\" name=\"{$name}\" id=\"{$id}\" $optional_attr>";
                }
     public function textAreaField($name,$value='',$rows='',$cols='',$optional_attr=''){
			$extra_arr = (strlen($rows)>0||strlen($cols)>0)?"rows =\"$rows\" cols=\"$cols\"":"";
		return "<textarea name=\"$name\" id=\"$name\" $extra_arr $optional_attr>$value</textarea>";
	 }
	/*Select Options*/
     public function selectOptions($name,array $options,$postback_field){ 
            $output = "<select name=\"{$name}\" id=\"{$name}\">  \n";
            foreach($options as $key=>$option){
              $output .= ($key == $postback_field)?"<option value=\"{$key}\" selected =\"selected\">{$option}</option>":"<option value=\"{$key}\">{$option}</option> \n";                     
             }      
            $output .="</select>"; return $output;
	 }

	 public function dataList($name,array $options){ 
	    $output = "<datalist id=\"{$name}\">  \n";
	 	foreach($options as $option){
	 	$output .= "<option label=\"{$option}\" value=\"{$option}\" />";
		}
	    $output .="</datalist>\n"; return $output;
	 }
	 public function radioButton($label,$name,$value='',$checked=false,$inline_style="display:inline"){
	   $checked = ($checked==true)?"checked=\"checked\"":"";
	   return "<span style=\"{$inline_style}\"><label><input type=\"radio\" name=\"{$name}\" value=\"{$value}\" $checked />".ucfirst("{$label}")."</label></span>";
	 }
	 public function checkBox($label,$name,$value='',$checked=false,$inline_style="display:block"){
	   $checked = ($checked==true)?"checked=\"checked\"":"";
	   return "<span style=\"{$inline_style}\"><label><input type=\"checkbox\" name=\"{$name}\" value=\"{$value}\" $checked />".ucfirst("{$label}")."</label></span>";
	 }
	 public function setFormField($label='',$field='',$error=''){
	 	if($label<>null){
	 	$this->formInputs[$label] = (strlen($error)>0)?array($field,$error):array($field);
		}else{
		$this->formInputs[] = array($field);	
		}
		return $this->formInputs;
	 }
	 public function groupFormFields($grouplable,$label,$field,$error){
        return array_merge($this->groupFormInputs,array($grouplable=>$this->setFormField($label,$field,$error))); 
	 }
	 public function endForm(){
	 	return $this->htmlForm = "\n</form> ";
	 }
	 //End of form elements
	 /*This Method Displays the form on the screen with specified format
	  * Left Labling, 
	  * Top Labling,
	  * Form Grouping,
	  * Upload Labling,
	  * Login Labling,
	  * Bootscrap Labling
	  * */
    
	 public function DisplayForm($layout,$message=""){
	 	    $message = strlen($message)>0?$message:$message; 
	 	    switch($layout){
			 case"Left Labling":
				$output ="<div id=\"formWrapper\">";
				  $output .= $message; 
				 $output  .=$this->startForm();
				 foreach($this->formInputs as $label =>$data){
                     $label = (!is_numeric($label)?$label:null);
				     $input = array_key_exists(0, $data)?$data[0]:$data[0]; 
				 	 $error = (array_key_exists(1, $data))?$data[1]:null;
				 $output .= $message;
				 $output .=($label<>null)?"<div class=\"inputfield inputlabel-left\">{$label}{$input} \n":"<div class=\"inputfield inputlabel-left\">{$input} \n";
				 $output .=(strlen($error)>0)?"<p class=\"error\">{$error}</p></div>\n":"</div>";	 
				 }
				 $output .=$this->endForm()."</div>\n";
				  return $output;
			 break;
			 case"Top Labling":
				 /*display form */
				 $output ="<div id=\"formWrapper\">";
				 $output .= $message;  
				 $output .= "<ol class=\"app-form\">";
				 $output .= $this->startForm();
				 foreach($this->formInputs as $label=>$data){
                  $label = (!is_numeric($label)?$label:null);
				  $input = array_key_exists(0, $data)?$data[0]:$data[0]; 
				  $error = (array_key_exists(1,$data))?$data[1]:null; 
				  $output .=($label<>null)?"<li class=\"label\">{$label}<br/>{$input} \n":"<li class=\"label\">{$input} \n";
				 $output .=(strlen($error)>0)?"\n <p class=\"error\">{$error}</p></li> ":"</li> \n";	 
				 }
				 $output .=$this->endForm()."</ol>";
				 $output .="</div>";
				 return $output;
			break;
			
			  case"Form Grouping":
				$output ="<div id=\"formWrapper\">";
				  $output .= $message; 
				 $output  .=$this->startForm();
				 foreach($this->groupFormInputs as $fieldset=>$formInputs){
				  $output .="<div class=\"app-form\">";
				  foreach($formInputs as $label =>$data){
                    $label = (!is_numeric($label)?$label:null);
				    $input = array_key_exists(0, $data)?$data[0]:$data[0]; 
				 	$error = (array_key_exists(1, $data))?$data[1]:null;
				 	$output .= $message;
				 	$output .=($label<>null)?"<div class=\"app-form\">{$label}{$input} \n":"<div class=\"app-form\">{$input} \n";
				 	$output .=(strlen($error)>0)?"<p class=\"error\">{$error}</p></div>\n":"</div>";
                    }
                    $output .="</div>";	
				 }
                    $output .=$this->endForm()."</div>\n";
				  return $output;
			 break;
			case"Upload Labling":
				  //puts 
				$output ="<div id=\"uploadWrapper\">";
				  $output .=$this->startForm();
				 foreach($this->formInputs as $label =>$data){
                    $label = (!is_numeric($label)?$label:null);
				    $input = array_key_exists(0, $data)?$data[0]:$data[0]; 
				 	$error = (array_key_exists(1, $data))?$data[1]:null;
				 $output .= $message;
				 $output .=($label<>null)?"<div class=\"app-form\">{$label}{$input} \n":"<div class=\"app-form\">{$input}\n";
				 $output .=(strlen($error)>0)?"<p class=\"error\">{$error}</p></div>\n":"</div>";	 
				 }
				 $output .=$this->endForm()."</div>";
				  return $output;
			break;
			case "Login Labling":
				 /*Display Login form */
				 $output ="<div id=\"loginWrapper\">";
				 $output .= $message;  
				 $output .= "<ul class=\"app-form login\">";
				 $output .= $this->startForm();
				 foreach($this->formInputs as $label =>$data){
                     $label = (!is_numeric($label)?$label:null);
				     $input = isset($data[0])?$data[0]:$data[0]; 
				     $input = array_key_exists(0, $data)?$data[0]:$data[0]; 
				 	 $error = (array_key_exists(1, $data))?$data[1]:null;
				 $output .= $message;	  
				 $output .=(strlen($label)<=1)?"<li>{$input} \n":"<li>{$label}<br/>{$input} \n";	 
				 }
				 $output .=$this->endForm();
				 $output .="</ul></div>";
				 return $output;
				break;
			 case"Bootscrap Labling":
				$output ="<div id=\"formWrapper\" class=\"formgroup\">";
				 $output .= $message; 
				 $output .= "<div class=\"inputfield inputlabel-top\">";
				 $output .= $this->startForm();
				 foreach($this->formInputs as $label =>$data){
                   $label = (!is_numeric($label)?$label:null);
				   $input = array_key_exists(0, $data)?$data[0]:$data[0]; 
				   $error = (array_key_exists(1, $data))?$data[1]:null; 
				 $output .=($label<>null)?"<div>{$label}<br/>{$input} \n":"<div>{$input} \n";
				 $output .=(strlen($error)>0)?"\n <p class=\"error\">{$error}</p></div> ":"</div> \n";	 
				 }
				 $output .=$this->endForm()."</div>";
				 $output .="</div>";
				 return $output;
			 break;
			default:
			 return null;
			break;
	 	    }
	 }
}

/**
 *@Method Form Validation Class
 */
class FormValidator{
 private $field_errors= array();
 public  $upload_fieldname;
//Checks for required empty fields
 public function check_requiredFields(array$required_array){
 	     foreach ($required_array as $fieldname) {
		    if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){
	  	    $this->field_errors[$fieldname] = "*".ucfirst($fieldname)." is required";
	  	  }
	   }
	 return $this->field_errors;
 }
 //Checks for bad characters if field names
 public function check_invalidChars(array $required_array,$regex="#[a-zA-Z ]#i"){
 	     foreach ($required_array as $fieldname) {
             if(!empty($_POST[$fieldname]) &&
                preg_replace($regex,"",$_POST[$fieldname])){
            $this->field_errors[$fieldname] = "*".ucfirst($fieldname)." is not allowed";
	  	  }
	   }
	 return $this->field_errors;	
 }
 //Checks for required fields length //key =>value pair
   public function check_FieldLength(array $required_len_array){
 	   foreach($required_len_array as $fieldname => $maxlen){
	  	  if(!empty($_POST[$fieldname]) && strlen(trim($_POST[$fieldname],"\r\n")) < 3){
	  	  $this->field_errors[$fieldname] = "*".ucfirst($fieldname)." is too short";
	  	  }
	  	  if(!empty($_POST[$fieldname]) && strlen(trim($_POST[$fieldname],"\r\n")) > $maxlen){
	  	  $this->field_errors[$fieldname] = "*".ucfirst($fieldname)." is too long";
	  	}
	  }
	 return $this->field_errors;
  }
  //Check for Select Option is null;
  public function check_selectField(array $option_array){
  	 foreach($option_array as $option =>$selval){
  	 	 if($_POST[$option] == $selval){
  	 	 	$this->field_errors[$option] = "*".ucfirst($option)." is required";
  	 	 }
  	}
	 return $this->field_errors;
  }
  /*  Check email fields */
  public function check_EmailAddr($emailaddr){
  	if(!empty($_POST[$emailaddr]) && !preg_match( "#^[_\w-]+(\.[_\w-])*@[_\w-]+(\.[\w]+)*(\.[\w]{2,3})$#i",$_POST[$emailaddr])){
		$this->field_errors[$emailaddr] ="* Invalid email address provided";
	}
	return $this->field_errors;
  }
  /*** Checks if file uploaded is verified */
  public function check_uploadFiletype($filetype,array $mimetype, $filename){
      //var_dump($filetype);
  	if(!array_key_exists($filetype,$mimetype)&& !empty($filename)){
	  	 $this->field_errors[$this->upload_fieldname] = "*".ucfirst($filename)." is not allowed,choose the correct format"; 
		}
    return $this->field_errors;
  }
   /*** Checks if file uploaded is already exists */
  public function check_uploadFileExists($filelocation,$filename){
  	    if(file_exists($filelocation) && !empty($filename)){
	   	$this->field_errors[$this->upload_fieldname] = "*File ".ucfirst($filename)." already exists";
	   	}
		return $this->field_errors;
  }
   /*** Checks if file uploaded file size */
  public function check_uploadFileSize($filesize,$filename){
  	   if(($filesize > $_REQUEST['MAX_FILE_SIZE'] || $filesize > UploadFiles::SET_MAX_FILE_SIZE)&& !empty($filename)){
	     $this->field_errors[$this->upload_fieldname] = "*File ".ucfirst($filename)." is too large";
	  	}
	   return $this->field_errors;
  }
  /* Checks to find if passwords match in two fields. */
 public function check_PasswordFields($password,$confirmpass){
 	    if(strcasecmp($_POST[$password], $_POST[$confirmpass]) != 0){
		$this->field_errors[$confirmpass] ="* Password entered did not match"; 
		}
   return $this->field_errors;
  }
  //Checks for required fields length //key =>value pair
   public function check_PasswordLength(array $pass_len_array){
 	   foreach($pass_len_array as $fieldname => $minlen){
	  	if(!empty($_POST[$fieldname])){
            if(strlen(trim($_POST[$fieldname])) < $minlen){
             $this->field_errors[$fieldname] = "* Password is too short must be at least {$minlen} characters";
              }  
	  	  }
	  }
	 return $this->field_errors;
  }
    
  //Checks for bad characters if field names
 public function check_UsernameChars(array $required_array){
 	     foreach ($required_array as $fieldname) {
		  if(!empty($_POST[$fieldname]) && preg_replace("#[a-zA-Z0-9_-]#i","",$_POST[$fieldname])){
            $this->field_errors[$fieldname] = "*".ucfirst($fieldname)." is not allowed";
	  	  }
	   }
	 return $this->field_errors;	
 }
 /* Checks dates by formates in dd/mm/yyyy */
 public function checkFormDate($dateformat='09/10/2013'){
 	$regex ="~^[0-9]{2}\\/[0-9]{2}\\/[0-9]{4}|[0-9]{2}\-[0-9]{2}\-[0-9]{4}$~";
     if(!empty($_POST[$dateformat]) && !preg_match($regex, $_POST[$dateformat])){
     	$this->field_errors[$dateformat] ="* Invalid date format,must be dd/mm/yyyy";
      }
	 return $this->field_errors;
 }
 public function check_number($number,$format=''){
 	    $format = ($format=="phone")?"/[0-9-?]/":"/[0-9]/";
 		if(!empty($_POST[$number]) && !preg_match($format,$_POST[$number])){
		$this->field_errors[$number]= "* {$number} must be digits";
 	}
	return $this->field_errors;
 }
 public function check_Radio_n_CheckBox($items_array,$checkeditem){
 	 //put validation rules
 }
 /* Display Errors in a form */
 public function displayErrors(array$error_array){
	$output = "<ol class=\"errors\">";
	foreach($error_array as $error) {
	  $error = str_ireplace("_", " ", $error);
	  $output .="<li> " . $error . "</li>";
    }
	$output .="</ol>";
	return $output;
 }
  /* Display Errors in a form */
 public function displayErrorField(array $err_array,$fieldname){	
 	if(is_array($err_array)){
 	   foreach($err_array as $key=>$value){
 	  	$err_array[$key] = str_ireplace("_", " ", $value);
 	    }
 	    if(array_key_exists($fieldname, $err_array)){
           return $err_array[$fieldname];
 	    }
	 }
   }
 }
?>

