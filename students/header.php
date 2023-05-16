<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 1/29/2023
 * Time: 4:26 PM
*/

//COPY THIS ENTIRE CODE EXAMPLE ***AFTER YOUR INITIAL COMMENTS***.  DO NOT CLOSE THE PHP AFTER YOUR INITIAL COMMENTS.
//This is the header include file for Spring 2023

//start the session - used for login
session_start();

//Error Reporting
error_reporting(E_ALL);
ini_set('display_errors','1');

//Include Files
require_once "connect.php";
require_once "functions.php";

//Initial Variables
//When using,  watch for capitalization of variable names.  Make changes as necessary.
$currentFile = basename($_SERVER['SCRIPT_FILENAME']);
$rightNow = time();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>amhefling</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.tiny.cloud/1/5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
<header>
    <h1>Auston Hefling - Students CMS</h1>
    <nav class="main">
        <?php
        //YOU WILL BE ADDING TO YOUR NAVIGATION AS THE SEMESTER PROGRESSES
        echo ($currentFile == "index.php") ? "<p class='active'>Home</p>" : "<a class='inactive' href='index.php'>Home</a>";
        echo ($currentFile == "register.php") ? "<p class='active'>Student Registration</p>" : "<a class='inactive' href='register.php'>Student Registration</a>";
        if(isset($_SESSION['ID'])) {
            echo ($currentFile == "updatepassword.php") ? "<p class='active'>Update Password</p>" : "<a class='inactive' href='updatepassword.php'>Update Password</a>";
            echo ($currentFile == "updateprofile.php") ? "<p class='active'>Update Profile</p>" : "<a class='inactive' href='updateprofile.php'>Update Profile</a>";
            echo ($currentFile == "contentadd.php") ? "<p class='active'>Add Content</p>" : "<a class='inactive' href='contentadd.php'>Add Content</a>";
            echo ($currentFile == "contentmanage.php") ? "<p class='active'>Manage Content</p>" : "<a class='inactive' href='contentmanage.php'>Manage Content</a>";
        }
        echo (isset($_SESSION['ID'])) ? "<a class='inactive' href='logout.php'>Log Out</a>" : "<a class='inactive' href='login.php'>Login</a>";
        ?>
    </nav>
</header>
<main>
    <h2><?php echo $pageName;?></h2>