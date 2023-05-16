<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 2/17/2023
 * Time: 12:15 PM
*/ 

$pageName = "Comparison Practice";
require_once "header.php";


/* **************************************************
* STRING COMPARISON PART I
* COPY ALL OF THIS CODE AFTER YOUR INITIAL COMMENTS
* (or you can make a new PHP file in your practice directory)
*
* Step 1:  Copy the Code AS-IS, UPLOAD, AND TEST THE RESULTS
* Step 2:  Change the values of $var1 and $var2 to the same value
*          (For example, change $var2 to 10)
* Step 3:  Likewise, make the values of $var3 and $var4 the same.
* Step 4:  Upload and test the code again.
*
* We can use SIMPLE if statements to determine if we have matching values.
* If the value is not the same, we can let the user know there is an error.
*/
echo '<h3>Compare Part 1:  Compare with IF</h3>';
$var1 = 11;
$var2 = 11;
$var3 = "Auston";
$var4 = "austoN";

echo 'The value of $var1 is ' . $var1 . '<br>';
echo 'The value of $var2 is ' . $var2 . '.<br>';


if ($var1 == $var2) {
    echo 'The variables $var1 and $var2 are the same.<br>';
}

if ($var1 != $var2) {
    echo 'The variables $var1 and $var2 are not the same.<br>';
}

echo '<hr>';
echo 'The value of $var3 is ' . $var3 . '<br>';
echo 'The value of $var4 is ' . $var4 . '.<br>';

if ($var3 == $var4) {
    echo 'The variables $var3 and $var4 are the same.<br>';
}

if ($var3 != $var4) {
    echo 'The variables $var3 and $var4 are not the same.<br>';
}

/* **************************************************
 * STRING COMPARISON PART 2
 * COPY ALL OF THIS CODE AFTER THE LAST LINE OF YOUR PART 1 CODE
 * (or you can make a new PHP file in your practice directory)
 * In the last lesson you changed all of the values to be the same.
 * IF YOU HAVEN'T DONE SO ALREADY, CHANGE $var3 and $var4 to your name with DIFFERENT capitalization.
*/
echo '<h3>Compare Part 2:  Changing Case</h3>';

echo '<p>$var3 is ' . $var3 . ' and $var4 is ' . $var4. '.</p>';
if ($var3 == $var4) {
    echo '<p>The variables $var3 and $var4 are the same.</p>';
} else {
    echo '<p>The variables $var3 and $var4 are NOT the same.</p>';
}
echo '<p>The uppercase version of $var3 is '. strtoupper($var3) . ' and the uppercase version of $var4 is ' . strtoupper($var4) . '.</p>';
if (strtoupper($var3) == strtoupper($var4)) {
    echo '<p>The variables $var3 and $var4 are the same if we change them both to strtoupper.</p>';
}else {
    echo '<p>The variables $var3 and $var4 are NOT the same.</p>';
}
echo '<hr>';

// *Pause to Practice*
echo '<h3>Compare Part 3: Pause to Practice</h3>';

echo '<p>$var3 is ' . $var3 . ' and $var4 is ' . $var4 . '</p>';
if (strcasecmp($var3, $var4) == 0){
    echo '<p>The strings $var3 and $var4 are equal with strcasecmp() function</p>';
} else {
    echo '<p>The strings $var3 and $var4 are not equal using strcasecmp() function</p>';
}

require_once "footer.php";
