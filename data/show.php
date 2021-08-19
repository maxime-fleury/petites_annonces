<?php
if((isset($arg) && !empty($arg))){
    if(is_int($arg)){
        $arg = intval($arg);
    }
}
else{
    $arg = "1";
}
if(isset($showby)){
    if($showby == "list"){
        echo "<table class=''><tr>";
        foreach($class_elements as $keys => $cElms){
            if($cElms['form'] == 1)
            echo "<th>" . $keys . "</th>";
        }
        echo "</tr>";
        //echo $arg . " ... " . gettype($arg);
        eval('$ce = new '.ucfirst($show_class).'();$class_elements = $ce->class_elements;');
            $offset = 10*(intval($arg)-1);
            $ObjectS = $ce->loadX(10, $offset);
        foreach($ObjectS as $el => $el_)
            {  
                echo "<tr>";
                foreach($class_elements as $keys => $cElms)
                {
                    if($cElms['form'] == 1)
                    {
                        $ucKeys = ucfirst($keys);
                        echo "<td>";
                        eval("echo \$el_->get$ucKeys();");
                        echo "</td>";
                    }
                }
                echo "</tr>";
            }
        echo "</table>";
    }
    if($showby == "cards"){
        echo '<div class="card container" style="width: 750px;">';
        $show_names = explode(";", $show_names);
        $i = 0;
        foreach($show_names as $sname){
            //$tmp_show[$i++] = explode("=", $sname);
            $tmp_show[$i++] = explode("=", $sname);
        }

            foreach($tmp_show as $Show => $cElms){//optimisations yes
                $show[$cElms[0]] = $cElms[1];
                $names[$cElms[1]] = $cElms[0];
            }
            $cElms = null;

        //echo $arg . " ... " . gettype($arg);
        eval('$ce = new '.ucfirst($show_class).'();$class_elements = $ce->class_elements;');
            $offset = intval(intval($amount)*(intval($arg)-1));
            $ObjectS = $ce->loadX(intval($amount), $offset);
            echo '<div class="row">';
        foreach($ObjectS as $el => $el_)
            {  
                echo "<div class='col-sm-6 text-center'><div class='card'>";
                $img = $names['Image'];
                $titre = $names["Titre"];
                $description = $names['Description'];

                echo '<img src="';
                eval("echo \$el_->get$img();");
                echo '" class="card-img-top" alt="...">';
                echo '<div class="card-body"><h5 class="card-title" style="min-height:75px">';
                eval("echo \$el_->get$titre();");
                echo '</h5><p class="card-text" style="min-height:75px">';
                eval("echo \$el_->get$description();");
                if($names["Prix"] != null){
                    $prix = $names["Prix"];
                    echo " <span class='text-secondary'>";
                    eval("echo \$el_->get$prix();");
                    echo "€</span>";
                }
                echo '</p><a href="'.$baseUrl.'/a/';
                eval("echo \$el_->getId();");
                
                echo '" class="btn btn-primary">Voir l\'annonce</a>';
                if(isset($_SESSION['login'])){
                    eval("\$id = \$el_->getUserId();");
                    if(intval($id) === $_SESSION['userId']){
                        echo "<a href='edit'>edit</a>";
                        echo "<a href='edit'>delete</a>";
                    }
                }
                echo '</div></div></div>';
            }
            echo "</div>";
    }
}
if($show_type != "details"){
    $show_class = strtolower($show_class);//make sure its lowercase
    $query ="SELECT count(id) as cnt from $show_class";
    $dbh = $GLOBALS['dbh'];
    $c = $dbh->query($query);
    $cnt = $c->fetch()['cnt'];
    echo "<div class='container'><div class='row justify-content-evenly'>";
    if($arg > 1){
        echo "<a href='$baseUrl/index/".(intval($arg)-1)."' class='col-4 btn btn-lg btn-primary '/><i class='fas fa-arrow-left'></i></a>'";
    }
    else{
        echo "<a href='#' disabled onclick='return false;' class='col-4 btn btn-lg btn-secondary '/><i class='fas fa-arrow-left'></i></a>'";
    }
    if($amount*$arg < $cnt){
        echo "<a href='$baseUrl/index/".(intval($arg)+1)."' class='col-4 btn btn-lg btn-primary'/><i class='fas fa-arrow-right'></i></a>'";
    }
    else{
        echo "<a href='#' disabled onclick='return false;' class='col-4 btn btn-lg btn-secondary '/><i class='fas fa-arrow-right'></i></a>'";
    }

    echo "</div>";
}
if(isset($show_type)){
    if($show_type === "details"){
        echo "<table class='table table-dark'>";echo "<tr>";
        eval('$ce = new '.ucfirst($show_class).'();$class_elements = $ce->class_elements;');
            $ObjectS = $ce->load(intval($arg));
                echo "<td>";
                foreach($class_elements as $keys => $cElms)
                {
                    if($cElms['form'] == 1)
                    {
                        $ucKeys = ucfirst($keys);
                        echo "<tr>";    
                        eval("echo \$ObjectS->get$ucKeys();");
                        echo "</tr>";
                    }
                }
                echo "</td>";
            }
            echo "</tr>";
            echo "</table>";
    }