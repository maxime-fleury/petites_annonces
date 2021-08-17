<?php
$input_types = array(
    'INTEGER' => "number",
    'VARCHAR' => "text"
);

//'form' => 0, hidden from all forms
//'form' => 1, never hidden
//'form' => 2, not hidden when $form_type = edit | register 
$form_ = "<form action='#' method='POST'>";
foreach($class_elements as $key => $value){//generate form
    if($form_type === "register" | $form_type === "edit"){
        if($value['form'] != 0){//if 0 always hidden
            $form_ .= $key . ": ";
            if($key!= "password" && $key != 'email') $form_ .= "<input id='" . $key . "' name='" . $key . "' type='". $input_types[$value['type']] .  "'" . (!$value['null'] ? " required='required'" : "") . ">";
            else if($key === "password")$form_ .=  "<input id='" . $key . "' name='" . $key . "' type='password'" . (!$value['null'] ? " required='required'" : "") . ">";
            else if($key === "email") $form_ .=  "<input id='" . $key . "' name='" . $key . "' type='mail'" . (!$value['null'] ? " required='required'" : "") . ">";
        }//if $value['null'] = true  => not REQUIRED
    }else{
        if($value['form'] == 1){//if 1 never hidden
            $form_ .=  $key . ": ";
            if($key!= "password" && $key != 'email') $form_ .=  "<input id='" . $key . "' name='" . $key . "' type='". $input_types[$value['type']] .  "'" . (!$value['null'] ? " required='required'" : "") . ">";
            else if($key === "password") $form_ .=  "<input id='" . $key . "' name='" . $key . "' type='password'" . (!$value['null'] ? " required='required'" : "") . ">";
            else if($key === "email") $form_ .=  "<input id='" . $key . "' name='" . $key . "' type='mail'" . (!$value['null'] ? " required='required'" : "") . ">";
        }
    }
}
$form_ .=  "<input type='submit'></form>";
//FORM VALIDATOR
$form_is_valid = true;
$DATA = array();
$data_count = 0;
foreach($class_elements as $key => $value){
    if($form_type === "register" || $form_type === "edit"){
        if($value['form'] != 0){//if 0 always hidden
            if( (!isset($_POST[$key])) || (empty($_POST[$key]))){
                //data must exist and not be empty
                if(!$value['null'])//only when its required
                    $form_is_valid = false;
            }
            else{
                $DATA[$data_count++] = $key;
            }
        }//if $value['null'] = true  => not REQUIRED
    }else{
        if($value['form'] == 1){//if 1 never hidden
            if( (!isset($_POST[$key])) || (empty($_POST[$key]))){
                //data must exist and not be empty
                if(!$value['null'])//only when its required
                    $form_is_valid = false;
            }
            else{
                $DATA[$data_count++] = $key;
            }
        }
    }
}
if($form_is_valid){
    echo "Le formulaire est bien validé";
    eval('$obj = new ' . $class . '($dbh);');
    for($i = 0; $i < $data_count; $i++){
        $nkey = $DATA[$i];
        $nvalue = $_POST[  $DATA[$i] ];
        
        eval('$obj->set'.$DATA[$i].'(\''.$nvalue.'\');');
        //eval('echo $obj->get'.$DATA[$i].'(\''.$nvalue.'\');');
    }
    switch($form_type){
        case 'register':
            eval('$obj->addToDb();');
        break;
    }
}