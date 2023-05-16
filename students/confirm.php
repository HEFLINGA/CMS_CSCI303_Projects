<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 3/20/2023
 * Time: 4:11 PM
*/ 

$pageName = "Confirmation";

require_once "header.php";

if($_GET['state'] == 1){
    echo "You have been successfully logged out.";
} elseif ($_GET['state'] == 2){
    echo "Welcome " . $_SESSION['fname'] . "! You are now logged in.";
}

require_once "footer.php";