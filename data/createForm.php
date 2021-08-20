<?php
if(isset($session_restricted) && !isset($_SESSION['login'])){
    if($session_restricted)
        header("Location: $baseUrl/");
       //echo $baseUrl;
}
$input_types = array(
    'INTEGER' => "number",
    'VARCHAR' => "text"
);
$form_= "<style>  
input[type=text], label, input[type=password], input[type=number], input[type=mail]{
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
$form_ .= "<form action='#' method='POST' class='form-floating text-center mt-3 pt-3 pb-3 text-white bg-dark row g-3 align-items-center'>";
foreach($class_elements as $key => $fvalue){//generate form
    if($form_type === "register" | $form_type === "edit"){
        if($fvalue['form'] != 0){//if 0 always hidden
            $form_ = createInput($key, $fvalue, $form_, $input_types, $form_names, 50);
        }//if $fvalue['null'] = true  => not REQUIRED
    }else{
        if($fvalue['form'] == 1){//if 1 never hidden
            $form_ = createInput($key, $fvalue, $form_, $input_types, $form_names, 50);
        }
    }
}
function createInput($key, $kvalue, $form_, $it, $form_names, $w){
    //$form_ .= "<div class='d-flex w-" . $w . "'>";
    $form_ .= '<div class="form-group  pt-1 pb-1 m-auto form-floating w-75 ">';
    if($key!= "password" && $key != 'email') $form_ .= "<input placeholder=' ' class='text-input form-control is-invalid' id='" . $key . "' name='" . $key . "' type='". $it[$kvalue['type']] .  "'" . (!$kvalue['null'] ? " required='required'" : "") . ">";
    else if($key === "password")$form_ .=  "<input id='" . $key . "' name='" . $key . "' placeholder='**********' type='password'" . (!$kvalue['null'] ? " class='password-input form-control is-invalid' required='required'" : "") . "></span>";
    else if($key === "email") $form_ .=  "<input placeholder='mail' class='text-input form-control is-invalid' id='" . $key . "' name='" . $key . "' type='mail'" . (!$kvalue['null'] ? " required='required'" : "") . ">";
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
if($form_is_valid){
    echo "Le formulaire est bien validé";
    eval('$obj = new ' . $form_class . '();');
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
                }
            }
            eval('$obj->addToDb();');
        break;
        case 'connexion':
            if($obj->loadUserFromDb()==1){
               echo " vous êtes bien connecté !" . htmlspecialchars($obj->getLogin(), ENT_QUOTES, 'UTF-8');
               $_SESSION['login'] = htmlspecialchars($obj->getLogin(), ENT_QUOTES, 'UTF-8');
               $_SESSION['userId'] = intval($obj->getId());
               
            }
    }
}