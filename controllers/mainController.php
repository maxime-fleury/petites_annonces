<?php
session_start();
require 'data/config.php';
require 'controllerManager.php';
$cm = new controllerManager();
$baseUrl = $cm->getBaseUrl();
$title = "Welcome !";
require "./templates/header.php";

$cm->
addRoute(
    "/",
    array("baseUrl::$baseUrl","show_class::ads", "amount::5", "show_type::pages", "showby::cards", "show_names::title=Titre;descr=Description;pic=Image;cat=Categorie;price=Prix"),
    array( "User", "ads", "show"),
    array( "index" )
)->addRoute(
    "/index",
    array("baseUrl::$baseUrl","show_class::ads", "amount::5", "show_type::pages", "showby::cards", "show_names::title=Titre;descr=Description;pic=Image;cat=Categorie;price=Prix"),
    array( "User", "ads", "show"),
    array( "index" )
)->addRoute(
    "/inscription",
    array( "form_class::User", "form_type::register" ),
    array( "User", "createForm" ),
    array( "inscription" )
)->addRoute(
    "/test",
    null,
    array( "entityManager" ),
    null
)->addRoute(
    "/connexion",
    array( "form_class::User", "form_type::connexion" ),
    array( "User", "createForm" ),
    array( "connexion" )
)->addRoute(
"/a",//path
    array("baseUrl::$baseUrl", "show_class::ads", "show_type::details"),//vars for $x = y "x::y", can add as many as you want
    array( "User", "ads", "show" ),// require all ./data/{var1}.php, ./data/{var2.php} ... can add as many as you want
    array( "annonce" )// require all ./template/{page1}.php ...... can add as many as you want
)->addRoute(
"/add",//path
    array( "baseUrl::$baseUrl","form_class::ads", "form_type::register", "session_restricted::true", "relation::userId", "form_length::25" ),
    array( "User", "ads", "createForm" ),
    array( "add" )
)
->addRoute(
    "/disconnect",
    null,
    null,
    array("disconnect")
)
->addRoute(
    "/delete",
    array("baseUrl::$baseUrl","form_class::ads", "session_restricted::true"),
    array("User", "ads", "delete"),
    null
)
->addRoute(
    "/edit",
    array( "baseUrl::$baseUrl","form_class::ads", "form_type::edit", "session_restricted::true", "form_length::25" ),
    array( "User", "ads", "createForm" ),
    array( "add" )
)
->redirect();
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>';
echo "

<script>
var option = {
    animation:true,
    delay:3500,
    autohide: true
};
var toastElList = [].slice.call(document.querySelectorAll('.toast'))
var toastList = toastElList.map(function (toastEl) {
  return new bootstrap.Toast(toastEl, option)
})
toastList[0].show();
</script>";

/*
switch ($request) {
    case $baseUrl . '/' :
        require './templates/index.php';
        break;
    case $baseUrl . '' :
        require './templates/index.php';
        break;
    case $baseUrl . '/inscription' :
        require './data/User.php';
        $form_class = "User";
        $form_type = "register";
        require './data/createform.php';//generate form
        require  './templates/inscription.php';//use $form_
        break;
    case $baseUrl . '/test':
        require './data/entityManager.php';
        break;
    default:
        http_response_code(404);
        require  './templates/404.php';
        break;
}*/