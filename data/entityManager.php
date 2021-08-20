<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>
require 'file.php';
<?php //work in progress
class entityManager{
    private $className;
    private $property;
    private $length;
    public function __construct($className){
        $this->className = $className;
        $this->length = 0;
        $this->property = array();
    }
    public function addProperty($name, $type, $length, $isNull, $isPrimary, $formType){
        $res = array(
            "type" => $type,
            "length" => $length,
            "null" => $isNull,
            "isPrimary" => $isPrimary,
            "form" => $formType
        );
        $this->property[$name] = $res;
        return $this;
    }
    public function generateClass(){
        $file = "data/". $this->className . "En.php";
        $content = "&lt;?php\ninclude 'config.php';\n\$class = '$this->className':\n";
        $content .= "public class $this->className{\n";//create class
        foreach($this->property as $key => $value){//add properties
            $content .= "\tprivate \$$key;\n";
        }
        $content .= "\tpublic \$dbh;\n";
        $content .= "\tpublic function __construct()\n\t{\n\t\t";//add construct
            $content .= "\$this->\$dbh = \$GLOBALS['dbh'];\n\t}\n" ;
        foreach($this->property as $key => $value){//add methods
            $uckey = ucfirst(strtolower($key)); 
            $content .= "\tpublic function set$uckey(\$$key)\n\t{\n\t\t\$this->$key = \$$key;\n\t}\n";
            $content .= "\tpublic function get$uckey()\n\t{\n\t\treturn \$this->$key;\n\t}\n";
        }
            $content .= "\tpublic function loadX(\$amount, \$offset)\n\t{\n\t\t
            \$res = array();\n\t\t
            \$query =  \"SELECT * FROM $this->className ORDER BY id DESC LIMIT \$amount\";\n\t\t
            if(\$offset != 0){\n\t\t\$query .= \" OFFSET \$offset\";\n\t\t}
            \n\t\tforeach (\$GLOBALS['dbh']->query(\$query) as \$row) \n\t\t
            {\n\t\t
                 \$res_ = new $this->className .();\n\t\t
                 \$res_->setId(\$row['id'])\n\t\t
                        ->
                 \$res[\$count++] = \$res_;\n\t\t
           }\n\t\t
           return $res;\n\t\t
         }\n\t\t";
/*
        
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
    
            return $this;
        }

*/

        $content .= "\n}";
        echo "<pre class='prettyprint'><code>".$content."</code></pre>";//echo it
    }
    public function test(){//just make sure everything works as intended
        echo "<pre>";
        print_r($this->property);
        $class_elements = array(
            'id' => array("type" => 'INTEGER', "length" => 15, "null" => false, "isPrimary" => true, "form" => 0),
            'title' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
            'pic' => array("type" => 'VARCHAR', "length" => 255, "null" => true, "isPrimary" => false, "form" => 1),
            'descr' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
            'cat' => array("type" => 'VARCHAR', "length" => 255, "null" => false, "isPrimary" => false, "form" => 1),
            'price' => array("type" => 'INTEGER', "length" => 10, "null" => false, "isPrimary" => false, "form" => 1),
            'userId' => array("type" => 'INTEGER', "length" => 10, "null" => false, "isPrimary" => false, "form" => 0)
        );
        echo "</pre><pre>";
        print_r($class_elements);
        echo "</pre>";
        //echo ($class_elements === $this->property);
        return $this;
    }
}
$cat = new entityManager("cat");
$cat->addProperty("id", "INTEGER", 15, false, true, 0)
    ->addProperty("name", "VARCHAR", 255, false, false, 1)
    ->addProperty("defaultPic", "VARCHAR", 255, false, false, 1)
    ->generateClass();
/*
$h = new entityManager("ads");
$h->addProperty("id", "INTEGER", 15, false, true, 0)
  ->addProperty("title", "VARCHAR", 255, false, false, 1)
  ->addProperty("pic", "VARCHAR", 255, true, false, 1)
  ->addProperty("descr", "VARCHAR", 255, false, false, 1)
  ->addProperty("cat", "VARCHAR", 255, false, false, 1)
  ->addProperty("price", "INTEGER", 10, false, false, 1)
  ->addProperty("userId", "INTEGER", 10, false, false, 0)
  ->generateClass();
$c = new entityManager("User");
$c->addProperty('id', 'INTEGER', 15, false, true, 0)
  ->addProperty('login', 'VARCHAR', 255, false, false, 1)
  ->addProperty('password', 'VARCHAR', 255, false, false, 1)
  ->addProperty('email', 'VARCHAR', 255, false, false, 2)
  ->addProperty('avatar', "VARCHAR", 255, true, false, 2)
  ->generateClass();*/