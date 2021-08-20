<?php
if(isset($session_restricted) && !isset($_SESSION['login'])){
    if($session_restricted)
        header("Location: $baseUrl/");
       //echo $baseUrl;
}
