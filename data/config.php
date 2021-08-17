<?php
$dbname = "post_ads";
$dsn = 'mysql:dbname=' . $dbname . ';host=localhost';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e) {
    echo 'Exception -> ';
    var_dump($e->getMessage());
}
if (!function_exists('checkdatabase'))   {
    function checkdatabase($dbname){
        //todo
    }
}
if (!function_exists('setupClass'))   {
    function setupClass($class, $dbname, $dbh, $class_elements_str){
        //declare check query (does table $class exists ?)
        $checkQuery = "SELECT COUNT(*)
        FROM information_schema.tables 
        WHERE table_schema = '" . $dbname . "' 
        AND table_name = '" . $class . "'";
        //execute it !
        $exists = 0;
        foreach  ($dbh->query($checkQuery) as $row) {
            $exists = $row[0];
        }
        if($exists == 0){//la table n'existe pas ! On la créer !
            $createQuery = "CREATE TABLE " . $class . "
            (
                ".
                    $class_elements_str
                ."
            )";
            if($dbh->query($createQuery))  {
            echo "Table created";
            }
            else{
                echo "en error occured no table created";
            }
        }

    }
}
if (!function_exists('getClassStr'))   {
    function getClassStr($class_elements){//to make the database using $class_elements
        $res = "";
        $count = 0;
        foreach($class_elements as $key => $value){
            $res .= $count == 0 ? '':', ';
        $res .=   $key . " " . $value['type'] . "(" . $value['length'] . ")";
        if($value['null']){
            $res .= " NULL ";
        }else
            $res .= " NOT NULL ";
            if($value['isPrimary']){
                $res .= " PRIMARY KEY AUTO_INCREMENT";
            }
        $count++;
        }
        return $res;
    }
}