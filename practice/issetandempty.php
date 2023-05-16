<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 2/16/2023
 * Time: 11:36 AM
*/ 

require_once "header.php";

$pageName = "Comparing Empty & Isset";

$some_empty = "";
$some_zero  = 0;
$some_false = false;
echo "<br> Checking on Empty: <br>";
if(empty($some_empty)){
    echo "VALUE: \$some_empty - value is empty<br>";
}
if(empty($some_zero)){
    echo 'VALUE: $some_zero - value is zero<br>';
}
if(empty($some_false)){
    echo "VALUE: \$some_false - value is false<br>";
}

echo "<br><br> Checking on Isset: <br>";
if(isset($some_empty)) {
    echo "VALUE: \$some_empty - empty is considered set<br>";
}
if(isset($some_zero)){
    echo "VALUE: \$some_zero - 0 is considered set<br>";
}
if(isset($some_false)){
    echo "VALUE: \$some_false - false is considered set<br>";
}

require_once "footer.php";