<?php

if (isset($_GET['p'])) {
    $page = $_GET['p'];
} else {
    $page = 'home';
}

if(file_exists("pages/$page.php")){
    include "pages/$page.php";
} else {
    include "pages/home.php";
}