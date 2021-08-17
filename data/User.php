<?php
require 'config.php';
$class = "User";
$class_elements = array(
    'id' => array("type" => 'INTEGER', "length" => 15, "null" => false, "isPrimary" => true, "form" => 0),
    'login' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
    'password' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
    'email' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 2),
    'avatar' => array("type" => 'VARCHAR', "length" => 255, "null" => true, "isPrimary" => false, "form" => 2)
);
//'form' => 0, hidden from all forms
//'form' => 1, never hidden
//'form' => 2, not hidden when $form_type = edit | register 
$class_elements_str = getClassStr($class_elements);
setupClass($class, $dbname, $dbh, $class_elements_str); //check if table exist, else create it !
class User{
    private $id;
    private $password;
    private $login;
    private $email;
    private $avatar;
    public $dbh;
    public function __contruct($dbh){
        $this->dbh = $GLOBALS['dbh'];
        $this->avatar = null;
    }
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function loadUserFromDb($login, $password){
        $this->password = $password;
        $this->login = $login;
        $query = "SELECT * FROM User WHERE login='$this->login' AND password='$this->password'";
        $count = 0;
        foreach ($GLOBALS['dbh']->query($query) as $row) {
            $this->id = $row[0];
            $this->email = $row[3];
            $this->avatar = $row[4];
            $count++;
        }
        if($count == 0) {
            echo "Cette utilisateur n'existe pas ou le mot de passe est inccorect !";
            return 0;
        }
        else{
            echo "Vous vous êtes bien connecté !";
            return 1;
        }

    }
    public function getLogin(){
        return $this->login;
    }
    public function setLogin($login){
        $this->login = $login;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getAvatar(){
        return $this->avatar;
    }
    public function setAvatar($avatar){
        $this->avatar = $avatar;
    }
    public function loadFromDb(){

    }
    public function addToDb(){
        $query = "SELECT login, count(login) FROM USER where login='$this->login'";
        $exists = 0;
        foreach  ($GLOBALS['dbh']->query($query) as $row) {
            $exists = $row[1];
        }
        if($exists != 0){
            echo "Ce login est déjà pris, merci de bien vouloir en choisir un autre.";
            return 0;
        } 
        else{
            $query = "INSERT INTO USER(login, password, email, avatar) values('$this->login', '$this->password', '$this->email', '$this->avatar')";
            $exists = 0;
            if($GLOBALS['dbh']->query($query)){
                echo "Nouvelle Utilisateur créé !";
                return 1;
            }
        }
    }
}