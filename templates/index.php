<?php

if(isset($_SESSION['login'])){
    echo "Vous êtes bien connectés !<br>";
    ?>
    <a href='../disconnect'>Se déconnecter</a>
    <?php
}