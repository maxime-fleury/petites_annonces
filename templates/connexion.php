<h1 class='text-center pb-2 text-success'> Connecter-vous !</h1>
<?php
echo $form_;
$baseUrl = "/post_ads/petites_annonces";
if(isset($_SESSION['login'])){
    header("Location: $baseUrl/index/Vous êtes connecté !");
}
?>
<div> 
</div>

<p class='position-absolute end-0 mt-3'>Pas de compte ?<a href='./inscription' class='btn btn-primary btn-sm'>Inscrivez-vous !</a></p>