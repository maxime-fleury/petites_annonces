<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' rel='stylesheet'>
    <link href='style.css' rel='stylesheet'>
    <title><?php echo $title; ?></title>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a href='<?php echo $baseUrl;?>/index' class="navbar-brand">Accueil</a>
    <div class='d-flex align-items-center'>
    <form action="<?php echo $baseUrl;?>/search" method='POST' class="d-flex align-items-center">
      <input class="form-control me-2" type="search" name='search' placeholder="Rechercher" aria-label="Rechercher">
      <input class="btn btn-outline-success" type="submit" value='Rechercher'>Rechercher
    </form>
    </div>
    <div class='d-flex align-items-center'>
    <?php
if(isset($_SESSION['login'])){
    ?>
    <?php echo "<div class='m-1'><a class='btn btn-primary'href='$baseUrl/pm'><i class='fas fa-envelope'></i></a></div><div class='m-1'> <a class='btn btn-secondary' href='$baseUrl/my'>Mes annonces</a></div> <div><a class='btn btn-success' href='$baseUrl/add'>Ajouter une annonce</a></div><a href='$baseUrl/disconnect' class='justify-content-end m-1 btn btn-primary'>Se déconnecter</a>";?>
    <?php
}
else{
    ?>
        <?php echo "<a href='$baseUrl/connexion' class='justify-content-end m-1 btn btn-primary'>Se connecter</a>";?>
    <?php
}
?></div>
  </div>
</nav>
   
<div class='p-4'></div><!-- need some spacing at top for the navbar  -->
