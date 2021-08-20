<h1 class='text-center pb-2 text-success'> Inscrivez-vous !</h1>
<div style='max-width:  100%; overflow-x: hidden;'>
     <?php echo $form_;
     $baseUrl = "/post_ads/petites_annonces";
     if(isset($_SESSION['login'])){
         header("Location: $baseUrl/index/Vous êtes connecté !");
     }
     ?>
</div>
