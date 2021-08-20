<?php
if(isset($_SESSION['login'])){
    unset($_SESSION['login']);
    unset($_SESSION['userId']);
    $baseUrl = "/post_ads/petites_annonces";
    header("Location: $baseUrl/index/Vous-vous êtes bien déconnectés !");
}
else{
    header("Location: $baseUrl/index/Vous n'êtes pas connectés !");
}