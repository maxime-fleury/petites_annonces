<?php
require "config.php";

$class_elements = array(
    'id' => array("type" => 'INTEGER', "length" => 15, "null" => false, "isPrimary" => true, "form" => 0),
    'title' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
    'pic' => array("type" => 'VARCHAR', "length" => 255, "null" => true, "isPrimary" => false, "form" => 1),
    'descr' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
    'cat' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
    'price' => array("type" => 'INTEGER', "length" => 10, "null" => false, "isPrimary" => false, "form" => 1),
    'userId' => array("type" => 'INTEGER', "length" => 10, "null" => false, "isPrimary" => false, "form" => 0)
);
$form_names = array(
    "title" => "Titre",
    "pic" => "Photo",
    "descr" => "Description",
    "cat" => "Categories",
    "price" => "Prix"
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
    public $class_elements;
    public $form_names;
    public function  __construct(){
        $this->dbh = $GLOBALS['dbh'];
        $this->class_elements = array(
            'id' => array("type" => 'INTEGER', "length" => 15, "null" => false, "isPrimary" => true, "form" => 0),
            'title' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
            'pic' => array("type" => 'VARCHAR', "length" => 255, "null" => true, "isPrimary" => false, "form" => 1),
            'descr' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
            'cat' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
            'price' => array("type" => 'INTEGER', "length" => 10, "null" => false, "isPrimary" => false, "form" => 1),
            'userId' => array("type" => 'INTEGER', "length" => 10, "null" => false, "isPrimary" => false, "form" => 0)
        );
        $this->form_names = array(
            "title" => "Titre",
            "pic" => "Photo",
            "descr" => "Description",
            "cat" => "Categories",
            "price" => "Prix"
        );
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
        $this->price = intval($price);
        return $this;
    }
    public function setId($id){
        $this->id = $id;
        return $this;
    }
    public function setPic($pic){
       $this->pic = $pic;
       return $this;
    }
    public function setCat($cat){
        $this->cat = $cat;
        return $this;
    }
    public function setDescr($descr){
        $this->descr = $descr;
        return $this;
    }
    public function setTitle($title){
        $this->title = $title;
        return $this;
    }
    public function setUserId($id){
        $this->userid = $id;
        return $this;
    }
    public function createAd($dbh){
        $this->id = "";
    }
    public function addToDb(){
        $this->setUserId(0);
        $query = "INSERT INTO ads VALUES(null, '". $this->getTitle()."', '".$this->getPic()."', '".$this->getDescr()."', '".$this->getCat()."', ".$this->getPrice().", ".$this->getUserId().")";
        $GLOBALS['dbh']->query($query);
    }
    public function load($id){
        //check if this element exists;
        $this->id = $id;
        $count = 0;
        $query = "SELECT * FROM ads WHERE id = $id";
        foreach ($GLOBALS['dbh']->query($query) as $row) {
            $this->setPrice($row["price"])
                 ->setTitle($row["title"])
                 ->setPic($row["pic"])
                 ->setDescr($row["descr"])
                 ->setUserId($row["userId"])
                 ->setCat($row["cat"]);
            $count++;
        }
        return $count;
    }

    public function loadX($amount, $offset){
       $count = 0;
        $res = array();
       $query =  "SELECT * FROM ads ORDER BY id DESC LIMIT $amount";
       if($offset != 0){
           $query .= " OFFSET $offset";
       }
       foreach ($GLOBALS['dbh']->query($query) as $row) 
       {
            $res_ = new Ads();
            $res_->setId($row['id'])
                 ->setPrice($row["price"])
                 ->setTitle($row["title"])
                 ->setPic($row["pic"])
                 ->setDescr($row["descr"])
                 ->setUserid($row["userId"])
                 ->setCat($row['cat']);
            $res[$count++] = $res_;
      }
      return $res;
    }
}

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