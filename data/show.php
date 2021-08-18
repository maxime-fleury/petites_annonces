<?php
if((isset($arg) && !empty($arg))){
    if(is_numeric($arg)){
        $arg = "1";
    }
}else{
    $arg = "1";
}
//echo $arg . " ... " . gettype($arg);
eval('$ce = new '.ucfirst($show_class).'();$class_elements = $ce->class_elements;');
    $offset = 10*(intval($arg)-1);
    $ObjectS = $ce->loadX(10, $offset);
foreach($class_elements as $keys => $cElms){
    foreach($ObjectS as $el => $el_){
        eval("echo \$el->get$keys();");
    }
}