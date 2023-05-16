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
    <h1>Auston Hefling - Project CMS</h1>
</header>
<nav class="main_nav">
    <?php
    echo ($currentFile == "index.php") ? "<a class='clicked'>Home</a>" : "<a href='index.php'>Home</a>";
    if (!isset($_SESSION['ID'])) { echo ($currentFile == "createuser.php") ? "<a class='clicked'>Sign Up</a>" : "<a href='createuser.php'>Sign Up</a>"; }
    echo ($currentFile == "displayusers.php") ? "<a class='clicked'>Reviewers</a>" : "<a href='displayusers.php'>Reviewers</a>";
    echo ($currentFile == "bookreviews.php") ? "<a class='clicked'>Book Reviews</a>" : "<a href='bookreviews.php'>Book Reviews</a>";
    echo (isset($_SESSION['ID'])) ? "<a class='login' href='logout.php'>Log Out</a>" : "<a class='login' href='login.php'>Login</a>";
    if(isset($_SESSION['ID'])) {
        echo ($currentFile == "addreview.php") ? "<a class='clicked'>Add Review</a>" : "<a href='addreview.php'>Add Review</a>";
        echo ($currentFile == "updateprofile.php") ? "<a class='clicked'>Update Profile</a>" : "<a href='updateprofile.php'>Update Profile</a>";
        echo ($currentFile == "updatepassword.php") ? "<a class='clicked'>Update Password</a>" : "<a href='updatepassword.php'>Update Password</a>";
    }
    if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        echo ($currentFile == "changeuserstatus.php") ? "<a class='clicked'>Admins</a>" : "<a href='changeuserstatus.php'>Admins</a>";
        echo ($currentFile == "addcategories.php") ? "<a class='clicked'>Add Categories</a>" : "<a href='addcategories.php'>Add Categories</a>";
    }
    ?>
</nav>
<main>
    <h2><?php echo $pageName;?></h2>