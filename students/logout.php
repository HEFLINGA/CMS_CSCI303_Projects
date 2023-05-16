<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 3/20/2023
 * Time: 4:12 PM
*/ 

session_start();
session_unset();
session_destroy();
header("location: confirm.php?state=1");