<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 2/17/2023
 * Time: 11:47 AM
*/

    $pageName = "SUPERGLOBALS";
    include "header.php";
?>
    <h2>PHP Superglobals practice</h2>
    <h3>Command PHP_SELF output:</h3>
<?php
    echo "Full path: ";
    echo $_SERVER['PHP_SELF'];
    echo "<br>";
    echo "Using 'basename()': ";
    echo basename($_SERVER['PHP_SELF']);
?>
    <h3>Command SCRIPT_FILENAME output:</h3>
<?php
    echo "Full path: ";
    echo $_SERVER['SCRIPT_FILENAME'];
    echo "<br>";
    echo "Using 'basename()': ";
    echo basename($_SERVER['SCRIPT_FILENAME']);
?>
    <h3>Command SCRIPT_NAME output:</h3>
<?php
    echo "Full path: ";
    echo $_SERVER['SCRIPT_NAME'];
    echo "<br>";
    echo "Using 'basename()': ";
    echo basename($_SERVER['SCRIPT_NAME']);
?>
    <h3>Command SERVER_NAME output:</h3>
<?php
    echo "Full path: ";
    echo $_SERVER['SERVER_NAME'];
    echo "<br>";
    echo "Using 'basename()': ";
    echo basename($_SERVER['SERVER_NAME']);
?>
    <h3>Command DOCUMENT_ROOT output:</h3>
<?php
    echo "Full path: ";
    echo $_SERVER['DOCUMENT_ROOT'];
    echo "<br>";
    echo "Using 'basename()': ";
    echo basename($_SERVER['DOCUMENT_ROOT']);
?>
    <h3>Command REQUEST_URI output:</h3>
<?php
    echo "Full path: ";
    echo $_SERVER['REQUEST_URI'];
    echo "<br>";
    echo "Using 'basename()': ";
    echo basename($_SERVER['REQUEST_URI']);
    echo "<br><br>"
?>
<?php
    include "footer.php";
?>