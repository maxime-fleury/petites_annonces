<?php
if(isset($session_restricted) && !isset($_SESSION['login'])){//need to be connected
    if($session_restricted)
        header("Location: $baseUrl/Vous devez être connectés !");
       //echo $baseUrl;
}
if((isset($arg) && !empty($arg))){//need to have some args
    if(!is_int($arg)){
        $arg = intval($arg);
    }
}
else{
    header("Location: $baseUrl/index/Raté !");//no args no delete
}
$ucform_class = ucfirst($form_class); 
eval("\$Obj = new $ucform_class();");
echo "\$Obj = new $ucform_class();";
$Obj->load(intval($arg));

if(intval($Obj->getUserId()) === intval($_SESSION['userId'])){
    $Obj->delete();
    //great let's redirect to index
    header("Location: $baseUrl/index/Vous avez bien supprimé votre annonce !");
}
else{
    header("Location: $baseUrl/index/Erreur, ceci n'est pas votre annocne !");
}