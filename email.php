<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 3/27/2023
 * Time: 3:35 PM
*/

require_once "functions.php";

/* ***********************************************************************
 * MODIFY THE FOLLOWING VARIABLE VALUES
 * ********************************************************************** */
// 1 - Subject
$Subject = "Emailing TEST";
// 2 - Body of email - See how you can add HTML?  See how I added a little style?  MODIFY!
$Body = "<p style='color:darkred'>This is the body to the email I am sending from PHP, sent from Auston's code!</p>";
// 3 - Alt Body - Body of email without HTML
$AltBody = 'This is the body to the email I am sending from PHP, sent from Auston\'s code!';
// 4 - You need a variable called $email for the email recipient.  This should already be created in your form.
$email = "jennis@coastal.edu";
// 5 - You need a variable called $first_name that will have the first name of the person receiving the email
$fname= "Auston";
// 6 - Success Message to the user - You can modify to have a span tag and a success class.
$EmailOkay = "An email has been sent to $email and should arrive shortly.";
// 7 - Error Message to the user - You can modify to have a span tag and an error class.
$EmailFail = "Oh no! There was an error during the emailing process.";

/* ***********************************************************************
 * DO NOT MAKE CHANGES BELOW THIS LINE!
 * ********************************************************************** */

//send the message, check for errors
$sent_email = send_email($Subject, $Body, $AltBody, $email, $fname);
if ($sent_email == 1) {
    echo $EmailOkay;
} else {
    echo $EmailFail;
}

