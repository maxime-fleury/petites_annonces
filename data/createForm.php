<?php
if(isset($session_restricted) && !isset($_SESSION['login'])){
    if($session_restricted)
        header("Location: $baseUrl/index/Erreur vous n'êtes pas connectés");
       //echo $baseUrl;
}
$input_types = array(
    'INTEGER' => "number",
    'VARCHAR' => "text"
);
$form_= "<style>  
input[type=text], select, label, input[type=password], input[type=number], input[type=mail]{
    border-radius:30px;  
    padding:10px;
    }
.password-input input{
    width:12em;
    margin-top: 2px;
}
</style>";

//'form' => 0, hidden from all forms
//'form' => 1, never hidden
//'form' => 2, not hidden when $form_type = edit | register 
if(isset($arg) && !empty($arg)){
    $ucform_class = ucfirst($form_class); 
    eval("\$LObj = new $ucform_class();");
    $LObj->load(intval($arg));
    $obj_empty = false;
}
else{ $ucform_class = ucfirst($form_class); eval("\$LObj = new $ucform_class();"); $obj_empty = true; }
$form_ .= "<form action='#' method='POST' class='form-floating text-center mt-3 pt-3 pb-3 text-white bg-dark row g-3 align-items-center'>";
foreach($class_elements as $key => $fvalue){//generate form
    if($form_type === "register" | $form_type === "edit"){
        if($fvalue['form'] != 0){//if 0 always hidden
            $form_ = createInput($key, $fvalue, $form_, $input_types, $form_names, $LObj, $obj_empty, $cat);
        }//if $fvalue['null'] = true  => not REQUIRED
    }else{
        if($fvalue['form'] == 1){//if 1 never hidden
            $form_ = createInput($key, $fvalue, $form_, $input_types, $form_names, $LObj, $obj_empty, $cat);
        }
    }
}
function createInput($key, $kvalue, $form_, $it, $form_names, $LObj, $obj_empty, $cat){
    //$form_ .= "<div class='d-flex w-" . $w . "'>";
    $form_ .= '<div class="form-group  pt-1 pb-1 m-auto form-floating w-75 ">';
    if($key!= "password" && $key != 'email' && $key != "cat") {
        $uckey = ucfirst($key);
        $form_ .= "<input value='";
        if(!$obj_empty) eval("\$form_ .= \$LObj->get$uckey();");
        $form_ .= "' placeholder=' ' class='text-input form-control is-invalid' id='" . $key . "' name='" . $key . "' type='". $it[$kvalue['type']] .  "'" . (!$kvalue['null'] ? " required='required'" : "") . ">";
    }
    else if($key === "password"){
        $form_ .=  "<input value='";
        if(!$obj_empty) eval("\$form_ .= \$LObj->get$uckey();");
        $form_ .= "' id='" . $key . "' name='" . $key . "' placeholder='**********' type='password'" . (!$kvalue['null'] ? " class='password-input form-control is-invalid' required='required'" : "") . "></span>";
    }
    else if($key === "email"){
        $form_ .=  "<input value='";
        if(!$obj_empty) eval("\$form_ .= \$LObj->get$uckey();");
        $form_ .=  "'placeholder='mail' class='text-input form-control is-invalid' id='" . $key . "' name='" . $key . "' type='mail'" . (!$kvalue['null'] ? " required='required'" : "") . ">";
    }
    else if($key === "cat"){
        $form_ .= "
        <select class='text-input form-control is-invalid' name='$key' id='$key'>";
        $count = 0;
        foreach($cat->getCat() as $realcats){
            $form_ .= "<option  value='".$cat->getDefaultImage()[$count]."'>$realcats</option>";
            $count++;
        }
        if(!$obj_empty) eval("\$form_ .= \$LObj->get$uckey();");
         }
    $form_ .= '<label class="text-dark" for="' . $key . '"> ' . ucfirst($form_names[$key]) . '</label></div>';
    //$form_ .= "</div>";
    return $form_;
}
$form_ .=  "<input type='submit' class='btn btn-primary'></form>";
//FORM VALIDATOR
$form_is_valid = true;
$DATA = array();
$data_count = 0;
foreach($class_elements as $key => $jvalue){
    if($form_type === "register" || $form_type === "edit"){
        if($jvalue['form'] != 0){//if 0 always hidden
            if( (!isset($_POST[$key])) || (empty($_POST[$key]))){
                //data must exist and not be empty
                if(!$jvalue['null'])//only when its required
                    $form_is_valid = false;
            }
            else{
                $DATA[$data_count++] = $key;
            }
        }//if $value['null'] = true  => not REQUIRED
    }else{
        if($jvalue['form'] == 1){//if 1 never hidden
            if( (!isset($_POST[$key])) || (empty($_POST[$key]))){
                //data must exist and not be empty
                if(!$jvalue['null'])//only when its required
                    $form_is_valid = false;
            }
            else{
                $DATA[$data_count++] = $key;
            }
        }
    }
}
if($form_type === "edit"){
   if($LObj.exists()){
       
   }
   echo "test";
}
if($form_is_valid){
    echo "Le formulaire est bien validé";
    eval('$obj = new ' . $form_class . '();');
    if(isset($arg) && !empty($arg)){
        $obj->load(intval($arg));
    }
    for($i = 0; $i < $data_count; $i++){
        $nkey = $DATA[$i];
        $nvalue = addslashes($_POST[  $DATA[$i] ]);
        //set all posts values to the object
        //echo '$obj->set'.ucfirst($DATA[$i]).'(\''.addslashes($nvalue).'\');';
        echo "<br>";
        eval('$obj->set'.ucfirst($DATA[$i]).'(\''.addslashes($nvalue).'\');');
        //eval('echo $obj->get'.$DATA[$i].'(\''.$nvalue.'\');');
    }
    switch($form_type){
        case 'register':
            if(isset($session_restricted)){
                if($session_restricted && isset($_SESSION['userId'])){
                    $obj->setUserId($_SESSION['userId']);
                    echo "registered";
                }
            }
            eval('$obj->addToDb();');
            echo "registered";
            header("Location: $baseUrl/index/Bravos !");
        break;
        case 'connexion':
            if($obj->loadUserFromDb()==1){
               echo " vous êtes bien connecté !" . htmlspecialchars($obj->getLogin(), ENT_QUOTES, 'UTF-8');
               $_SESSION['login'] = htmlspecialchars($obj->getLogin(), ENT_QUOTES, 'UTF-8');
               $_SESSION['userId'] = intval($obj->getId());
               header("Location: $baseUrl/index/Vous-vous êtes bien connecté !");
            }
        break;
        case 'edit':
            if(isset($session_restricted)){
                if($session_restricted && isset($_SESSION['userId'])){
                    //$obj->setUserId($_SESSION['userId']);

                }
            }
            echo "edit";
            $obj->edit(intval($arg));
            header("Location: $baseUrl/index/Vous-avez bien édité votre annonce");
            break;
    }
}