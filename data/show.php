<?php
if((isset($arg) && !empty($arg))){
    if(strlen($arg)>4){
        echo '<div class="toast-container position-absolute top-0 start-50 translate-middle-x"><div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex ">
          <div class="toast-body ">'
          .urldecode($arg).
          '</div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div></div>';
    

          }
    if(!is_int($arg)){
        $arg = intval($arg);
    }else{
        $arg = 1;
    }

}
else{
    $arg = 1;
}
if((isset($amount) && !empty($amount))){
    if(!is_int($amount)){
        $amount = intval($amount);
    }
}
else{
    $amount = 1;
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
            $offset = $amount*(intval($arg)-1);
            $ObjectS = $ce->loadX($amount, $offset);
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
        echo '<div class="card container" style="max-width: 750px;">';
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
                echo "<div class='col-sm-6 text-center'><div class='card  mt-2 mb-2' style=''>";
                $img = $names['Image'];
                $titre = $names["Titre"];
                $description = $names['Description'];
                eval("\$defaultImage = \$cat->getDefaultImg(\$el_->getCat());");
                echo '<img style="width:auto; height:250px;object-fit:scale-down; " src="';
                eval("if(\$el_->get$img() == null) echo \$defaultImage; else echo \$el_->get$img(); ");
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
                
                echo '" class="btn btn-primary m-4">Voir l\'annonce</a>';
                if(isset($_SESSION['login'])){
                    eval("\$id = \$el_->getUserId();");
                    if(intval($id) === $_SESSION['userId']){
                        echo "<a class='btn btn-success btn-sm m-2' href='$baseUrl/edit/";
                        eval("echo \$el_->getId();");
                        echo "'><i class='fas fa-edit'></i></a>";
                        echo "<a class='btn btn-danger btn-sm' href='$baseUrl/delete/";
                        eval("echo \$el_->getId();");
                        echo "'><i class='fas fa-trash'></i></a>";
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
        echo "<div class='container'>";
        eval('$ce = new '.ucfirst($show_class).'();$class_elements = $ce->class_elements;');
            $ObjectS = $ce->load(intval($arg));
                echo "<div class='col'>";
                foreach($class_elements as $keys => $cElms)
                {
                    if($cElms['form'] == 1)
                    {
                        $ucKeys = ucfirst($keys);
                        if($ucKeys != "Pic"){
                        echo "<div class='row'>";  
                        eval("echo \$ObjectS->getFormNames()['$keys'] . ': '; ");  
                        eval("echo \$ObjectS->get$ucKeys();");
                        echo "</div>";
                        }
                        else{
                            echo "<div class='row'>";  
                            //eval("echo \$ObjectS->getFormNames()['$keys'] . ': '; ");  
                            //eval("if(\$ObjectS->get$ucKeys() == 1) echo \$ObjectS->get$ucKeys(); else echo\$ObjectS->getCat();");
                            eval("\$defaultImage = \$cat->getDefaultImg(\$ObjectS->getCat());");
                            echo '<img style="width:auto; height:250px;object-fit:scale-down; " src="';
                            eval("if(\$ObjectS->get$ucKeys() == null) echo \$defaultImage; else echo \$el_->get$ucKeys(); ");
                            echo '" class="card-img-top" alt="...">';
                            
                            echo "</div>";
                        }
                    }
                }
                echo "<a href='#' class='btn btn-primary'>Contacte</a>";
                echo "</div>";
            }
            echo "</div>";
    }