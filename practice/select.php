<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 2/27/2023
 * Time: 10:25 AM
*/ 

$pageName = "Select Practice - Page 1";
require_once "header.php";
?>

    <nav>
        <ul>
<!--        <li><a href="select.php">Main Select Practice Page</a></li>-->
            <li><a href="select1.php">PDO Q - Looping</a></li>
            <li><a href="select2.php">PDO Q - 'fetch()'</a></li>
            <li><a href="select3.php">PDO Q - PDO::FETCH_ASSOC</a></li>
            <li><a href="select4.php">PDO Q - 'fetchAll()'</a></li>
            <li><a href="select5.php">PDO Q - 'fetchAll()' improved</a></li>
            <li><a href="selectoptions.php">PDO Q - View/Delete/Update options</a></li>
            <li><a href="selectlist.php">PDO Q - List of employees</a></li>
            <li><a href="selectsearch.php">Search Tutorial</a></li>
            <li><a href="selectsort.php">Sorting Dynamically</a></li>
        </ul>
    </nav>

<?php
require_once "footer.php";