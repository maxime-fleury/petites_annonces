<?php
require "config.php";
$class = "Ads";
$class_elements = array(
    'id' => array("type" => 'INTEGER', "length" => 15, "null" => false, "isPrimary" => true, "form" => 0),
    'title' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
    'pic' => array("type" => 'VARCHAR', "length" => 255, "null" => true, "isPrimary" => false, "form" => 1),
    'descr' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
    'cat' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
    'price' => array("type" => 'INTEGER', "length" => 10, "null" => false, "isPrimary" => false, "form" =>1),
);
//'form' => 0, hidden from all forms
//'form' => 1, never hidden
//'form' => 2, not hidden when $form_type = edit | register 
$class_elements_str = getClassStr($class_elements);
setupClass($class, $dbname, $dbh, $class_elements_str); //check if table exist, else create it !
class Ads{
    private $id;
    private $title;
    private $pic;
    private $descr;
    private $cat;
    private $price;
    private $userid;
    public function  __construct($dbh){

    }

    public function getPrice(){
        return $this->price;
    }
    public function getId(){
        return $this->id;
    }
    public function getPic(){
        return $this->pic;
    }
    public function getCat(){
        return $this->cat;
    }
    public function getDescr(){
        return $this->descr;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getUserId(){
        return $this->userid;
    }
    public function setPrice($price){
        $this->price = $price;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setPic($pic){
       $this->pic = $pic;
    }
    public function setCat($cat){
        $this->cat = $cat;
    }
    public function setDesc($descr){
        $this->descr = $descr;
    }
    public function setTitle($title){
        $this->title = $title;
    }
    public function setUserId($id){
        $this->userid = $id;
    }
    public function createAd($dbh){
        $this->id = "";
    }
}
$ads = new Ads($dbh);

/*
foreach($class_elements as $key => $value){
   echo $key . " " . $value["type"];
};

class Ads{
    private $_methods;
    public function createClass($class_elements){
        foreach($class_elements as $key => $value){
            $this->{$key} = ""; 
            $this->_methods["get".$key] = eval('function() {return \$this->$key;}');
            $this->_methods["set".$key] = eval('function(\$a){ \$this->$key = $a;}');
        }; 
    }
}
$ads = new Ads();
$ads->createClass($class_elements);
*/