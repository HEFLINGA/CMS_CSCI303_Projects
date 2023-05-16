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
session_start();  //LEAVE THIS COMMENTED OUT UNTIL INSTRUCTED

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
    <link rel="stylesheet" href="../styles.css">
    <script src="https://cdn.tiny.cloud/1/5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
<header>
    <h1>Auston Hefling</h1>
    <nav>
        <?php
        //YOU WILL BE ADDING TO YOUR NAVIGATION AS THE SEMESTER PROGRESSES
        echo ($currentFile == "index.php") ? "Home" : "<a href='index.php'>Home</a>";
        //add the next echo statement here
        ?>
        <a href="project/index.php">Project Directory</a>
        <a href="students/index.php">Students Directory</a>
        <a href="practice/index.php">Practice Directory</a>
    </nav>
</header>
<main>
    <h2><?php echo $pageName;?></h2>