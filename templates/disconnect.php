<?php
if(isset($_SESSION['login'])){
    unset($_SESSION['login']);
    unset($_SESSION['userId']);
    $baseUrl = "/post_ads/petites_annonces";
    header("Location: $baseUrl/");
}
else{
    echo "Vous n'êtes pas connecté ! <a href='./index/1'>retour</a>";
}