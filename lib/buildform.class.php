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
include_once"processform.class.php";
class BuildForm{
	 /**
	   * Use this class to create Input Objects / Fields / Forms
	   * @param $field , data type is array type
	   * usage $field = array("label"=>"Firstname","type"=>"text","name"=>"firstname","value"=>"","required"=>true,"optionalattr"=>"class=\"formclass\" placeholer=\"Enter name here\"")
	   * @param array elements attributes: 
	   * "label"=>"" for field label,
	   * "type"=>"" for input field type attribute  default to "type"="text" if ignored,
	   * "value"=>"" for input field value attribute default to "value"="" if ignored,
	   * "optionalattr"=>"" use it to add more attribute to any field, it is optional
	   * "cols"=>"","rows"=>""  use this attributes for textarea fields or multiline input fields
	   * "options"=>array("optionvalue"=>"value","optionvalue"=>"value") use this attributes for select options in select dropdown fields
	   * $field=array("label"=>"Gender","radiogroup"=>array(array("name"=>"male","value"=>"","required"=>true,"checked"=>true),											        array("name"=>"male","value"=>"","required"=>true,"checked"=>true),..)) use this attributes for radio and checkbox fields
	   * 
	   * @method createInputField(array$field,$makevalid=null)  visibility public
	   * @method createTextField(array$field,$makevalid=null)   visibility public
	   * @method createUploadField(array$field,$makevalid=null) visibility public
	   * @method createSelectField(array$field,$makevalid=null) visibility public
	   * @method createUploadField(array$field,$makevalid=null) visibility public
	   * @method createRadioButton(array$field,$makevalid=null) visibility public
	   * @method createCheckBox(array$field,$makevalid=null)	visibility public
       * @method checkedBoxValue($check_name,$value) visiblity public
       * @method checkedRadioValue($check_name,$value) visiblity public
	   * @method displayForm($layout,$message="")    visibility public display to form to screen
	   * 
	   **/
	  protected $process;
	  protected $validate;
	  protected $form;
	  protected $input_keys=array();
      public $form_heading;
    
    
	  public function __construct($name="",$action="",$method="get",$extra_attr=""){
	  	$this->form = new Form($name,$action,$method,$extra_attr);
	  	$this->process = new ProcessForm;
      }
    
	  public function startForm(){
	  	    $this->form->startForm();
	  }
    
	  public function endForm(){
	  	    $this->form->endForm();
	  }
    
   
    
	  public function createInputField(array$field,$makevalid=null){
		   //prep vals
$label =(array_key_exists("label",$field) && $field["label"] != null)?$this->form->inputLabel($field["name"], ucfirst($field["label"])):null;
$type  =(array_key_exists("type", $field))?$field["type"]:$field["type"] = "text";//default type to text
				 $name  =(array_key_exists("name", $field))?$field["name"]:$field["name"] = "";
				 $value =(array_key_exists("value", $field))?$field["value"]:$field["value"] = "";
				 $optional =(array_key_exists("optionalattr", $field))?$field["optionalattr"]:null;
				//Set form Input Field
  $this->form->setFormField($label,$this->form->inputField($type,$name,$this->process->post($name,$value),$optional),$makevalid);
		  
      }
    
	 //Creates a text area field
    public function createTextField(array $field,$makevalid=null){
	  	//prep vals
			     $name  =(array_key_exists("name", $field))?$field["name"]:null;
			     $value =(array_key_exists("value", $field))?$field["value"]:$field["value"] = "";
			     $label = (array_key_exists("label",$field) && $field["label"] != null)?$this->form->inputLabel($name, ucfirst($field["label"])):null;
				 $optional = (array_key_exists("optionalattr", $field))?$field["optionalattr"]:null;
				 $rows = (array_key_exists("rows", $field))?$field["rows"]:null;
				 $cols = (array_key_exists("cols", $field))?$field["cols"]:null;
				
				 $this->form->setFormField($label,
				 $this->form->textAreaField($name,$this->process->post($name,$value),$rows,$cols,$optional),$makevalid); 
		
	  }
	 
	  public function createUploadField(array $field,$makevalid=null){
	  	//prep vals
          		 $id =(array_key_exists("id", $field))?$field["id"]:$field["id"] = "";	            $name =(array_key_exists("name", $field))?$field["name"]:$field["name"] = "";
			     $value = (array_key_exists("value", $field))?$field["value"]:$field["value"] = "";
			     $label = (array_key_exists("label",$field) && $field["label"] != null)?$this->form->inputLabel($field["name"], ucfirst($field["label"])):null;
				 $optional = (array_key_exists("optionalattr", $field))?$field["optionalattr"]:null;
				 //Set form  Field
                 $this->form->setFormField($label,$this->form->uploadField($id,$name,$optional),$makevalid); 
	   }
	  
    public function createSelectField(array $field,$makevalid=null){
	  	   //prep vals
			     $name =(array_key_exists("name", $field))?$field["name"]:$field["name"] = "";
			     $value = (array_key_exists("value", $field))?$field["value"]:null;
			     $label = (array_key_exists("label",$field) && $field["label"] != null)?$this->form->inputLabel($field["name"], ucfirst($field["label"])):null;
				 $options = (array_key_exists("options", $field))?$field["options"]:array();
				 //Set form  Field
          $this->form->setFormField($label,
				 $this->form->selectOptions($name,$options,$this->process->post($name,$value)),$makevalid);
	   }
  
    /*
		 * use this attributes for radio and checkbox fields
		 * $field=array("label"=>"Reciepies","checkboxes"=>array(array("checklabel"=>"male","name"=>"gender","value"=>"","checked"=>$this->checkedBoxValue("name","value")),
	     * 									array("checklabel"=>"female",,"name"=>"gender","value"=>"","checked"=>$this->checkedBoxValue("name","value")),..)) 
		 */
   
    public function checkedBoxValue($check_name,$value){
          
          if($_POST && $value!=null){
			 $name = $check_name;
			 preg_match("/^[a-z_-]+/",$name,$name_matches);
			 if(isset($_POST[$name_matches[0]])){
                 return in_array($value,$_POST[$name_matches[0]])?true:false;
			 }
		  }
	  }
  
    public function checkedRadioValue($check_name,$value,$postbackval=''){
        if(isset($_POST[$check_name])){
         return $this->process->post($check_name)=="$value"?true:false;
        }else{
         return $this->process->post($check_name,$postbackval)=="$value"?
             true:false;
        }
    }
    
    public function createRadioButton(array $field,$makevalid=null){
		$addradiogroup =""; $radiobuttons = array();
	  	if(array_key_exists("radiogroup",$field)){
		   $radiobutton = count($field["radiogroup"]);
			for($key=0; $key<$radiobutton; $key++){
  
			//prep vals
			$label = (array_key_exists("label",$field) && $field["label"] != null)?$this->form->inputLabel($field["radiogroup"][$key]["name"], ucfirst($field["label"])):null;
			$name  = (array_key_exists("name", $field["radiogroup"][$key]))?$field["radiogroup"][$key]["name"]:$field["radiogroup"][$key]["name"] = "";
			$value = (array_key_exists("value",$field["radiogroup"][$key]))?$field["radiogroup"][$key]["value"]:$field["radiogroup"][$key]["value"] = "";
			$radiolabel = (array_key_exists("radiolabel", $field["radiogroup"][$key]))?$field["radiogroup"][$key]["radiolabel"]:$field["radiogroup"][$key]["radiolabel"] = "";
	        $checked = (array_key_exists("checked",$field["radiogroup"][$key]))?$field["radiogroup"][$key]["checked"]:$field["radiogroup"][$key]["checked"] = false;
			$addradiogroup .= $this->form->radioButton(ucfirst($radiolabel),$name,$value,$checked);
			}
		//Set form  Field 
	   $this->form->setFormField($label,$addradiogroup,$makevalid);
	  }
     }
	 	
    //check box field
	  public function createCheckBox(array $field,$makevalid=null){
	    $addcheckboxes = array(); 
		$addcheckbox ='';
	  	if(array_key_exists("checkboxes",$field)){
		   $checkboxes = count($field["checkboxes"]);
            
			for($key=0; $key<$checkboxes; $key++){
			//prep vals
			$label = (array_key_exists("label",$field) && $field["label"] != null)?$this->form->inputLabel($field["checkboxes"][$key]["name"], ucfirst($field["label"])):null;
			$name  = (array_key_exists("name",$field["checkboxes"][$key]))?$field["checkboxes"][$key]["name"]:$field["checkboxes"][$key]["name"] = "";
			$value = (array_key_exists("value",$field["checkboxes"][$key]))?$field["checkboxes"][$key]["value"]:$field["checkboxes"][$key]["value"] = "";
			$checked = (array_key_exists("checked",$field["checkboxes"][$key]))?$field["checkboxes"][$key]["checked"]:$field["checkboxes"][$key]["checked"] = false;
            $style = (array_key_exists("style",$field["checkboxes"][$key]))?$field["checkboxes"][$key]["style"]:$field["checkboxes"][$key]["style"] = "display:block";
                
			$checklabel = (array_key_exists("checklabel",$field["checkboxes"][$key]))?$field["checkboxes"][$key]["checklabel"]:null;
			
			$addcheckbox .= $this->form->checkBox(ucfirst($checklabel),$name,$value,$checked,$style);/**/
			}
		//Set form  Field 
	    $this->form->setFormField($label,$addcheckbox,$makevalid);
		 }
	   }
    public function formHtml($element){
           return $this->form->addFormElem($element);
      }
    public function displayForm($layout,$message=""){
         $form_ouptput = "";
         $form_ouptput .= $this->form_heading;
	  	 $form_ouptput .=$this->form->DisplayForm($layout,$message="");
        return  $form_ouptput;
	 }

}
?>