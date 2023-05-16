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
    echo "<p class='success'>You have been successfully logged out.</p>";
} elseif ($_GET['state'] == 2){
    echo "<p class='success'>Welcome " . $_SESSION['username'] . "! You are now logged in.</p>";
}

require_once "footer.php";