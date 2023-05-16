<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 1/26/2023
 * Time: 11:33 AM
*/ 

require_once "header.php";
?>

<form name="myform" id="myform" method="post">
    <label for="fname">First name:</label><br>
    <input type="text" id="fname" name="fname" placeholder="First Name"><br>

    <label for="mname">Middle initial:</label><br>
    <input type="text" maxlength="1" name="mname" placeholder="Middle Initial"><br>

    <label for="lname">Last name:</label><br>
    <input type="text" id="lname" name="lname" placeholder="Last Name"><br>
</form>

<?php
require_once "footer.php";
?>
