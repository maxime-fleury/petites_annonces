<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' rel='stylesheet'>
    <title><?php echo $title; ?></title>
</head>
<body>
    <?php
if(isset($_SESSION['login'])){
    ?>
    <div class='position-fixed top-0 end-0'>
    <?php echo "<a href='$baseUrl/disconnect' class='btn btn-primary'>Se déconnecter</a>";?>
    </div>
    <?php
}
else{
    ?>
    <div class='position-fixed top-0 end-0'>
        <?php echo "<a href='$baseUrl/connexion' class='btn btn-primary'>Se connecter</a>";?>
    </div>
    <?php
}
?>
<div class='p-4'></div><!-- need some spacing at top for the navbar  -->
