<h1> Connecter-vous !</h1>
<?php
$baseUrl = "/post_ads/petites_annonces";
if(isset($_SESSION['login'])){
    header("Location: $baseUrl/");
}
?>
<div> <?php echo $form_;?>
</div>

<p class='position-absolute end-0 mt-3'>Pas de compte ?<a href='./inscription' class='btn btn-primary btn-sm'>Inscrivez-vous !</a></p>