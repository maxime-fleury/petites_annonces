<?php
if(isset($session_restricted) && !isset($_SESSION['login'])){
    if($session_restricted)
        header("Location: $baseUrl/");
}
$input_types = array(
    'INTEGER' => "number",
    'VARCHAR' => "text"
);
$form_= "<style>  
input{
      border-radius: 30px; height:2em; width:15em;
      padding:10px;
    }
.password-input{
    margin-left:5px;
}
.password-input input{
    width:12em;
    margin-top: 2px;
}
</style>";
if(isset($form_length)){
    $form_ .= "<style>input[type=password],input[type=text],input[type=mail],input[type=number]{
        border-radius: 30px; height:2em; width:" . $form_length . "em!important;
      }</style>";
}
//'form' => 0, hidden from all forms
//'form' => 1, never hidden
//'form' => 2, not hidden when $form_type = edit | register 
$form_ .= "<form action='#' method='POST' class='text-center mt-3 text-white bg-dark row g-3 align-items-center'>";
foreach($class_elements as $key => $fvalue){//generate form
    if($form_type === "register" | $form_type === "edit"){
        if($fvalue['form'] != 0){//if 0 always hidden
            $form_ = createInput($key, $fvalue, $form_, $input_types, $form_names);
        }//if $fvalue['null'] = true  => not REQUIRED
    }else{
        if($fvalue['form'] == 1){//if 1 never hidden
            $form_ = createInput($key, $fvalue, $form_, $input_types, $form_names);
        }
    }
}
function createInput($key, $kvalue, $form_, $it, $form_names){
    $form_ .= '<div class="form-group mb-3"><label for="' . $key . '"> ' . ucfirst($form_names[$key]) . '</label><br>';
    if($key!= "password" && $key != 'email') $form_ .= "<input id='" . $key . "' name='" . $key . "' type='". $it[$kvalue['type']] .  "'" . (!$kvalue['null'] ? " required='required'" : "") . ">";
    else if($key === "password")$form_ .=  "<span class='password-input input-group mb-3 d-inline-block'><img class='input-group-text d-inline-block input-group-prepend' width='45px' src='https://toppng.com/uploads/preview/this-is-a-graphic-reation-of-a-pad-lock-username-and-password-icon-115534595184fsadfncq6.png'  id='basic-addon1'/><input id='" . $key . "' name='" . $key . "' placeholder='**********' type='password'" . (!$kvalue['null'] ? " required='required'" : "") . "></span>";
    else if($key === "email") $form_ .=  "<input id='" . $key . "' name='" . $key . "' type='mail'" . (!$kvalue['null'] ? " required='required'" : "") . ">";
    $form_ .= '</div>';
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
        echo '$obj->set'.ucfirst($DATA[$i]).'(\''.addslashes($nvalue).'\');';
        echo "<br>";
        eval('$obj->set'.ucfirst($DATA[$i]).'(\''.addslashes($nvalue).'\');');
        //eval('echo $obj->get'.$DATA[$i].'(\''.$nvalue.'\');');
    }
    switch($form_type){
        case 'register':
            if(isset($session_restricted)){
                if($session_restricted && issert($_SESSION['userId'])){
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