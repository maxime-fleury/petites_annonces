<?php
class cat{
    private $cat;
    private $cntCat;
    private $defaultImage;
    public function __construct(){
        $this->cntCat = 0;
    }
    public function addCat($newCat, $url){
        $this->cat[$this->cntCat] = $newCat;
        $this->defaultImage[$this->cntCat] = $url;
        $this->cntCat++;
        return $this;
    }
    public function getCat(){
        return $this->cat;
    }
    public function getDefaultImage(){
        return $this->defaultImage;
    }

}
$cat = new cat();
$cat->addCat("Travail", "https://www.carenews.com/sites/default/files/styles/og_image/public/2020-08/neuf-sites-job-sens-carenews.png?itok=vxQTN5Kz")
    ->addCat("Vente", "https://www.annonce-beaute.com/wp-content/uploads/2020/05/Fotolia_158864494_Subscription_Monthly_M.jpg")
    ->addCat("Achat", "https://cdn.futura-sciences.com/buildsv6/images/wide1920/7/b/7/7b78a33f22_50163712_e-commerce-thodonal-adobe-stock.jpg")
    ->addCat("Immobillier", "https://images.prismic.io/figaroimmo/c6b0443a-e737-454d-8b0d-9d64977bd598_vendre-deconfinement.jpg?auto=compress,format&rect=0,0,1000,667&w=720&h=480")
    ->addCat("Location", "https://www.auditat.fr/userfiles/image/obligations_locations_1.jpg")
    ->addCat("Informatique", "https://cdn.futura-sciences.com/buildsv6/images/largeoriginal/9/4/0/940b22eda6_50170334_code-informatique.jpg");