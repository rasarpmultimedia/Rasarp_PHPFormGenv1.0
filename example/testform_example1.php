<?php
include_once"../lib/buildform.class.php";
/**
 * How to use the from class: implement it like this 
 */
try{
$createform = new BuildForm("textform",filter_var($_SERVER["PHP_SELF"]),"post");
echo $createform->formHtml("<p>Sign Up Form :)</p>");
// $firstname= array("label"=>"*Firstname","type"=>"text","name"=>"firstname","value"=>"","required"=>true,"optionalattr"=>"class=\"formclass\" placeholder=\"Enter name here\"");
// $lastname = array("label"=>"*Lastname","type"=>"text","name"=>"lastname","value"=>"","required"=>true,"optionalattr"=>"class=\"formclass\" placeholder=\"Enter name here\"");
$email = array("label"=>"*Email Address","type"=>"email","name"=>"email","value"=>"","optionalattr"=>"class=\"formclass\" placeholder=\"Enter your email here\"");
 //$password= array("label"=>"*Password","type"=>"password","name"=>"pass","value"=>"","required"=>true,"optionalattr"=>"class=\"formclass\"");
$submit   = array("type"=>"submit","name"=>"submit","value"=>"Register Me","optionalattr"=>"class=\"formclass\"");
$hidden   = array("type"=>"hidden","name"=>"submit","value"=>"Register Me","optionalattr"=>"class=\"formclass\"");

$createform->createInputField(
	   /* Do this in PHP 5.4 or above 
	    * ["label"=>"*Lastname","type"=>"text","name"=>"lastname",
	    * "value"=>"","required"=>true,
	    * "optionalattr"=>"class=\"formclass\" placeholder=\"Enter name here\""]
	    */
	   array("label"=>"*Enter Firstname","type"=>"text",
	   		 "name"=>"firstname","value"=>"","required"=>true,
	         "optionalattr"=>"class=\"formclass\" placeholder=\"Enter name here\"")
	   );
$createform->createInputField(
			array("label"=>"*Enter Lastname",
			"type"=>"text","name"=>"lastname","value"=>"",
			"required"=>true,"optionalattr"=>"class=\"formclass\" placeholder=\"Enter name here\""));
$createform->createInputField($email);
//$createform->createInputField($password);
$createform->createTextField(array("label"=>"*Type Your Message",
	   		 "name"=>"comments","cols"=>40,"rows"=>10,"value"=>"",
	         "optionalattr"=>"class=\"formclass\" placeholder=\"Type your message here\""));
	
$gender=array("label"=>"Select your Gender",
              "radiogroup"=>array(		  	 array("radiolabel"=>"male","checked"=>$createform->checkedRadioValue("gender","male"),"name"=>"gender","value"=>"male"),       	 array("radiolabel"=>"female","checked"=>$createform->checkedRadioValue("gender","female"),"name"=>"gender","value"=>"female"))
             );
			
$sex=array("label"=>"Choose your sex","name"=>"sex",
		  	"options"=>array("....","male"=>"Male","female"=>"Female"));

$recipes=array("label"=>"Choose your favourite foods",
		 	   "checkboxes"=>array(
		 	   array("checklabel"=>"Banku and Tilapia","name"=>"recipes[]","value"=>"Banku and Tilapia","checked"=>$createform->checkedBoxValue("recipes",'Banku and Tilapia')),
	     	   array("checklabel"=>"Rice and Stew","name"=>"recipes[]","value"=>"Rice and Stew","checked"=>$createform->checkedBoxValue("recipes",'Rice and Stew')),
	     	   array("checklabel"=>"Fried Rice and Chicken","name"=>"recipes[]","value"=>"Fried Rice and Chicken","checked"=>$createform->checkedBoxValue("recipes","Fried Rice and Chicken")),
			   array("checklabel"=>"Gari Foto and Chicken","name"=>"recipes[]","value"=>"Gari Foto and Chicken","checked"=>$createform->checkedBoxValue("recipes","Gari Foto and Chicken"))
               ));
$createform->createCheckBox($recipes);
$createform->createSelectField($sex);
$createform->createRadioButton($gender);
$createform->createInputField($hidden);
//$createform->createInputField($hidden);
$createform->createInputField($submit);
//shows entire form on screen
echo $createform->displayForm("Top Labling");
}catch(Exception $e){
 //Debug Problem here	$e->getMessage()
}


?>