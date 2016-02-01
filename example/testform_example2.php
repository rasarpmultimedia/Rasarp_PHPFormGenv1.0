<?php
include_once"../lib/buildform.class.php";
/**
 * How to use the from class: implement it like this 
 */
try{
/** Process Forms and Validate Errors **/
  $process = new ProcessForm;
  $validate = $process->validate();   
if($process->submitForm()){
  
  $required = array("firstname","lastname","username","email");
  $process->errorinfo = array_merge(
      $process->errorinfo,$validate->check_requiredFields($required));
  
    
  $check_invalidchars = array("firstname","lastname","username");
  $process->errorinfo = array_merge(
  $process->errorinfo,$validate->check_invalidChars($check_invalidchars));
    
  $requiredlen = array("firstname"=>50,"lastname"=>50,"username"=>30);
  $process->errorinfo = array_merge(
      $process->errorinfo,$validate->check_FieldLength($requiredlen));
  
  $selectedindex = array("gender"=>"--Select Your Gender--");
  $process->errorinfo = array_merge($process->errorinfo,$validate->check_selectField($selectedindex));

  //validate password
array_push($required,"password");
$process->errorinfo = array_merge($process->errorinfo,$validate->check_PasswordLength(array("password"=>6)));
  $process->errorinfo = array_merge($process->errorinfo,$validate->check_requiredFields($required));
  $process->errorinfo = array_merge($process->errorinfo,$validate->check_PasswordFields("password", "cpassword"));

   
/** Insert Data into Database **/
 $process->message("You have successfully registered {$process->post("firstname")}");
 if($process->successflag){
     echo "<p style='background:white;text-align:center'>Hooray your form is ready to be inserted into the database :)</p>";
    //echo "Form_submitted - ".$process->post("firstname");
     //$rec::$tablefields = array('fieldname1'=>'?','fieldname2'=>'?',...);
    //array("firstname","lastname","gender","username","email","password","cpassword",); //$sql = $query->getTable("users");
// $result = $query->tablefields = array('fieldname1'=>'?','fieldname2'=>'?');
    
 // return parent::setData($key,$result);
 }
}


$form = new BuildForm("signupform",filter_var($_SERVER["PHP_SELF"]),"post"/*,"onsubmit=\"return false\""*/);
$form->form_heading =$form->formHtml("<h2>User Sign Up Form </h2>");
  
//First name
  $form->createInputField(
    array("label"=>"*Firstname","type"=>"text",
	   		 "name"=>"firstname","value"=>"",
	         "optionalattr"=>"class=\"forminput\" placeholder=\"Enter Firstname\""),$validate->displayErrorField($process->errorinfo,"firstname"));
	//Last name
  $form->createInputField(
    array("label"=>"*Lastname","type"=>"text",
	   		 "name"=>"lastname","value"=>"",
	         "optionalattr"=>"class=\"forminput\" placeholder=\"Enter Lastname\""),$validate->displayErrorField($process->errorinfo,"lastname"));
  //Gender
  $form->createSelectField(
      array("label"=>"*Gender","name"=>"gender","value"=>"",
      "options"=>array("--Select Your Gender--"=>"--Select Your Gender--","M"=>"Male","F"=>"Female")),$validate->displayErrorField($process->errorinfo,"gender"));
  
  //Username
  $form->createInputField(
    array("label"=>"*Username","type"=>"text",
	   		 "name"=>"username","value"=>"","required"=>true,
	         "optionalattr"=>"class=\"forminput\" placeholder=\"Enter Username \""),$validate->displayErrorField($process->errorinfo,"username"));

  //Email
  
  $form->createInputField(
    array("label"=>"*Email","type"=>"email",
	   		 "name"=>"email","value"=>"","optionalattr"=>"class=\"forminput\" placeholder=\"Enter Email: someone@example.com\""),$validate->displayErrorField($process->errorinfo,"email"));

 //Password
  $form->createInputField(
    array("label"=>"*Password","type"=>"password",
	   		 "name"=>"password","value"=>"",
	         "optionalattr"=>"class=\"forminput\" placeholder=\"Enter Password\""),$validate->displayErrorField($process->errorinfo,"password")
	  );
 //Confirm Password
  $form->createInputField(
    array("label"=>"*Confirm Password","type"=>"password",
	   		 "name"=>"cpassword","value"=>"",
	         "optionalattr"=>"class=\"forminput\" placeholder=\"Enter Your Password Again \""),$validate->displayErrorField($process->errorinfo,"cpassword"));
    
//Terms and Conditions

$form->formHtml("<p style=\"width:auto;padding:5px;\">By Clicking on Register Me you agree with our  Terms and Conditions there in.</p>");

//Submit Form;
$form->createInputField(
    array("type"=>"submit","name"=>"register",
          "value"=>"Register Me","optionalattr"=>"class=\"forminput-button\""));



echo $form->displayForm("Top Labling");
}catch(Exception $e){
 //Debug Problem here	$e->getMessage()
}


?>