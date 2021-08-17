<?php
require 'data/config.php';
$request = $_SERVER['REQUEST_URI'];
$baseUrl = "/post_ads/petites_annonces";
require "./templates/header.php";

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
    default:
        http_response_code(404);
        require  './templates/404.php';
        break;
}