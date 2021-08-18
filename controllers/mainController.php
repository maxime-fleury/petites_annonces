<?php
require 'data/config.php';
require 'controllerManager.php';
$title = "Welcome !";
require "./templates/header.php";
$cm = new controllerManager();
$cm->addRoute(
        "/",
        null,
        null,
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
        null,//vars for $x = y "x::y", can add as many as you want
        array( "User", "ads" ),// require all ./data/{var1}.php, ./data/{var2.php} ... can add as many as you want
        array( "annonce" )// require all ./template/{page1}.php ...... can add as many as you want
    )->addRoute(
        "/add",//path
        array( "form_class::ads", "form_type::register" ),
        array( "User", "ads", "createForm" ),
        array( "connexion" )
        );
$cm->redirect();


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