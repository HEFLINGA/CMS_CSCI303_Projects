<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 2/2/2023
 * Time: 10:59 AM
*/

/*
 * Class Notes:
 * (1) For login page - Just check for empty, and compare stuff to database.
 *      Use Password varify.
 * (2) Use session variables like: ID, adminstatus, maybe lname.
 */

/* ***********************************************************************************************
 *  COPY THIS PAGE OF CODE RIGHT AFTER YOUR OPENING COMMENTS
 *  ******************************************************************************************** */
//USAGE:  ALL VERSIONS | Create a variable for a user-friendly name of the page
$pageName = "Student Registration";

//USAGE:  ALL VERSIONS | Include the header
require_once "header.php";

/* ***********************************************************************************************
*  SET INITIAL VARIABLES
*  ******************************************************************************************** */
//USAGE:  ALL VERSIONS | Flag to show form - this allows us to show (default) or hide the form as appropriate.
$show_form = 1;
//USAGE:  VERSION 2+ | Flag to track errors - initially, no errors.  Can comment out in Version 1.
$error_exists = 0;
//USAGE:  VERSION 2+ | Individual error message for some field.  Create as many as needed based on form. Can comment out in Version 1.
// Error variables for form fields.
$error_fname = "";
$error_lname = "";
$error_email = "";
$error_pwd   = "";
$error_cyear = "";
$error_age   = "";
$error_mlist = "";
$error_airport = "";
$error_comments = "";

// Hashed password variable
$hash_pwd = "";

/* ***********************************************************************
 * PROCESS THE FORM UPON SUBMIT
 * *********************************************************************** */

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    /* ***********************************************************************
    * TROUBLESHOOTING:
    *      Use print_r() or var_dump()
    * *********************************************************************** */
    //USAGE:  VERSION 1+ | Use in Version 1 then comment out when not needed for testing (after Version 1).
    //print_r($_POST);

    //USAGE:  VERSION 1+ | Use in Version 1 then comment out when not needed for testing (after Version 1).
    // var_dump($_POST); //Use in early versions. Comment out when not needed for testing (usually after Version 1).
    // echo '<br>';


    /* ***********************************************************************
    * CREATE LOCAL VARIABLES & SANITIZE USER DATA
    *    USAGE:  VERSION 2+ MAKE LOCAL VARIABLES FOR ALL FIELDS - REQUIRED OR NOT
    *    1.  Some user input need no changes
    *           Example:  $pwd = $_POST['pwd'];
    *    2.  Trim all typed in entries except passwords
    *           Example:  $fname = trim($_POST['fname']);
    *    2.  In class, we'll ALWAYS use strtolower for emails and usernames
    *           Example:  $email = strtolower(trim($_POST['email']));
    * *********************************************************************** */

    // type your code here to create your local variables  Examples above.
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim(strtolower($_POST['email']));
    $mi    = $_POST['mi'];
    $pwd   = $_POST['pwd'];
    $age   = $_POST['age'];
    if (isset($_POST['cyear'])){
        $cyear = $_POST['cyear'];
    }
    if (isset($_POST['mlist'])) {
        $mlist = $_POST['mlist'];
    }
    $airport = $_POST['airport'];
    $comments = $_POST['comments'];


    /* ***********************************************************************
     * ERROR CHECKING - USAGE:  VERSION 2+
     * ***********************************************************************
       -----------------------------------------------------------------------
       ERROR CHECKING STEP 1 - CHECK EMPTY FIELDS (ONLY FOR REQUIRED FIELDS)
       CHECK EMPTY FIELDS
           Use if statement with empty() except for radio buttons use isset()
           If empty, update error flag & individual message.
      ---------------------------------------------------------------------- */

    // Error checking for empty-ness on required fields
    if (empty($fname)){
        $error_exists = 1;
        $error_fname = "Missing First Name.";
    }
    if (empty($lname)){
        $error_exists = 1;
        $error_lname = "Missing Last Name.";
    }
    if (empty($airport)){
        $error_exists = 1;
        $error_airport = "Missing Airport Selection.";
    }
    if (empty($age)){
        $error_exists = 1;
        $error_age = "Missing Age Selection.";
    }
    if (empty($comments)) {
        $error_exists = 1;
        $error_comments = "Missing Comments.";
    }
    if (!isset($cyear)) {
        $error_exists = 1;
        $error_cyear = "Missing School Year.";
    }
    if (!isset($mlist)){
        $error_exists = 1;
        $error_mlist = "Missing Mailing List Selection.";
    }


    /* -----------------------------------------------------------------------
       ERROR CHECKING STEP 2 - VALIDATE EMAILs or URLs
          Use if statement with filter_var
          If not valid, update error flag & individual message.
       --------------------------------------------------------------------- */

    // Validation for email field
    if (empty($email)) {
        $error_exists = 1;
        $error_email = "Missing Email.";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_exists = 1;
            $error_email = "Email is Not Valid.";
        }
    }

    /* ----------------------------------------------------------------------
       ERROR CHECKING STEP 3 - CHECKING MATCHING FIELDS
          Use  if statement to compare two variables.
          If not equal, update flag & individual message.
       --------------------------------------------------------------------- */

    //  Type your code here to validate necessary fields
    //  We will omit this if we are not asking to confirm information - Follow your particular directions.

    /* ***********************************************************************
     * ERROR CHECKING STEP 4 - CHECK PASSWORD LENGTH
     *     Use if statement with strlen to check (Must be minimum of 10
     *     If doesn't meet requirements, update flag & individual message.
     * ***********************************************************************
     */

    //Checking password length
    if (empty($pwd)){
        $error_exists = 1;
        $error_pwd = "Missing Password.";
    } else {
        if (strlen($pwd) < 10) {
            $error_exists = 1;
            $error_pwd = "Password Must be at Least 10 Characters.";
        } else {
            $hash_pwd = password_hash($pwd, PASSWORD_DEFAULT);
        }
    }


    /* ***********************************************************************
     * ERROR CHECKING STEP 5 - CHECK EXISTING DATA
     *     Use a function to see if duplicates exist.
     *     We usually check emails and usernames.
     *     For any duplicate, update the flag & individual message.
     * BE SURE YOU HAVE THE CORRECT FIELD NAMES AND DATABASE TABLE NAME!!!!
     * ***********************************************************************
     */

    $sql = "SELECT email FROM students WHERE email = :field";
    $dupemail = check_duplicates($pdo, $sql, $email);
    if ($dupemail) {
        $error_exists = 1;
        $error_email = "This email has already been registered.";
    }

    /* ***********************************************************************
     * CONTROL CODE USAGE:  VERSION 2+
     * (We are still within submit code)
     * You will have a style sheet with the class 'error'
     * ***********************************************************************
     */
    if ($error_exists == 1) {  // NOT USED IN VERSION 1.  UNCOMMENT IN VERSION 2+
        echo "<p class='error'>There are errors in the form.  Please make changes and re-submit.</p>";
     } else {

        /* ***********************************************************************
         * INSERT INTO THE DATABASE
         * USAGE:  VERSION 3
         * Not ALL data comes from the form - Watch for this!
         *    Example:  Date/Time to indicate when the record was created.
         * ***********************************************************************
         */
        // CREATE a variable here to hash the user's password.  THis is often called $hashed, $hashedpwd, etc.
        // ---- Hashed above!! ----

        // CREATE a variable here to reflect the date the record is created.  Use date("Y-m-d H:i:s").  It should match your database field name.
        $joined = date("Y-m-d H:i:s");

        // Type your code to INSERT into the database here
        $sql = "INSERT INTO students (fname, mi, lname, email, pwd, cyear, airport, age, mlist, comments, joined)
                VALUES (:fname, :mi, :lname, :email, :hash_pwd, :cyear, :airport, :age, :mlist, :comments, :joined)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fname', $fname);
        $stmt->bindValue(':mi', $mi);
        $stmt->bindValue(':lname', $lname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':hash_pwd', $hash_pwd);
        $stmt->bindValue(':cyear', $cyear);
        $stmt->bindValue(':airport', $airport);
        $stmt->bindValue(':age', $age);
        $stmt->bindValue(':mlist', $mlist);
        $stmt->bindValue(':comments', $comments);
        $stmt->bindValue(':joined', $joined);
        $stmt->execute();

        //Displaying a success message to the user
        echo "<p class='success'>Thank you for completing the form, it has been successfully submitted. Have a nice day!</p>";
//        echo "First Name: $fname<br>";
//        echo "Middle Initial: $mi<br>";
//        echo "Last Name: $lname<br>";
//        echo "Email: $email<br>";
//        echo "Password: $pwd<br>";
//        echo "Password Hashed: $hash_pwd<br>";
//        echo "School Year: $cyear<br>";
//        echo "Airport: $airport<br>";
//        echo "Age: $age<br>";
//        echo "Mailing List: $mlist<br>";
//        echo "Comments: $comments<br>";
//        echo '<br>';

//        $Subject = "Successful Student CMS Registration";
//        $Body = "<p style='color:darkred'>Thank you for registering!</p>";
//        $AltBody = 'Thank you for registering!';
//        $EmailOkay = "An email has been sent to $email and should arrive shortly.";
//        $EmailFail = "Oh no! There was an error during the emailing process.";
//
//        //send email and check for errors
//        $sent_email = send_email($Subject, $Body, $AltBody, $email, $fname);
//        if ($sent_email == 1) {
//            echo "<span class='success'>$EmailOkay</span><br>";
//        } else {
//            echo "<span class='error'>$EmailFail</span><br>";
//        }
        $show_form = 0; //Hiding the form
    } // else control code   if ($error_exists == 1) {  NOT USED IN VERSION 1.  UNCOMMENT IN VERSION 3
}//submit

/* ***********************************************************************
* DISPLAY FORM
* USAGE:  ALL VERSIONS
* ***********************************************************************
*/
if($show_form == 1){
    ?>
    <div class="form_reg">
        <p class="informative">Please fill out the below form to the best of your ability!</p>
        <!--Create your form below this line -->
        <form name="register" id="register" method="post" action="<?php echo $currentFile; ?>">
            <label class="label_text" for="fname">First Name:</label><br>
                <?php if (!empty($error_fname)) { echo "<span class='error'>$error_fname</span><br>"; } ?>
                <input type="text" name="fname" id="fname"
                       maxlength="30" size="40" placeholder="First Name"
                       value="<?php if (isset($fname)) { echo htmlspecialchars($fname); } ?>">
            <br>
            <label class="label_text" for="mi">Middle Initial:</label><br>
                <input type="text" name="mi" id="mi"
                       maxlength="1" size="10" placeholder="Middle Initial"
                       value="<?php if (isset($mi)) { echo htmlspecialchars($mi); } ?>">
            <br>
            <label class="label_text" for="lname">Last Name:</label><br>
                <?php if (!empty($error_lname)) { echo "<span class='error'>$error_lname</span><br>"; } ?>
                <input type="text" name="lname" id="lname"
                       maxlength="50" size="40" placeholder="Last Name"
                       value="<?php if (isset($lname)) { echo htmlspecialchars($lname); } ?>">
            <br>
            <label class="label_text" for="email">Email:</label><br>
                <?php if (!empty($error_email)) { echo "<span class='error'>$error_email</span><br>"; } ?>
                <input type="email" name="email" id="email"
                       size="40" placeholder="example@email.com"
                       value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
            <br>
            <label class="label_text" for="pwd">Password:</label><br>
            <?php if (!empty($error_pwd)) { echo "<span class='error'>$error_pwd</span><br>"; } ?>
            <input type="password" name="pwd" id="pwd"
                       size="40" placeholder="Enter Password">
            <br>
            <label class="label_text" for="airport">Select an Airport:</label><br>
            <?php if (!empty($error_airport)) { echo "<span class='error'>$error_airport</span><br>"; } ?>
            <select name="airport" id="airport"><?php
                    $sql = "SELECT airname, aircode FROM airports ORDER BY priority";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($results as $row){
                        ?><option value="<?php echo $row['aircode']; ?>" <?php if (isset($airport) && $airport == $row['aircode']) { echo " selected "; } ?>><?php echo $row['airname']?></option><?php
                    }
                ?>
                </select>
            <br>
            <label class="label_text" for="age">Please Select Your Age Range:</label><br>
                <?php if (!empty($error_age)) { echo "<span class='error'>$error_age</span><br>"; } ?>
                <select name="age" id="age">
                    <option value="" <?php if (isset($age) && $age == "") { echo " selected "; } ?>>Select An Option</option>
                    <option value="Under 18" <?php if (isset($age) && $age == "Under 18") { echo " selected "; } ?>>Under 18</option>
                    <option value="Between 18 and 20" <?php if (isset($age) && $age == "Between 18 and 20") { echo " selected "; } ?>>Between 18 and 20</option>
                    <option value="At Least 21" <?php if (isset($age) && $age == "At Least 21") { echo " selected "; } ?>>At Least 21</option>
                </select>
            <br>
            <fieldset>
                <legend class="label_text">Choose a Class Year:</legend>
                <?php if (!empty($error_cyear)) { echo "<span class='error'>$error_cyear</span><br>"; } ?>
                <input type="radio" name="cyear" id="cyear-fr" value="fr" <?php if (isset($cyear) && $cyear == "fr") { echo " checked "; } ?>>
                <label for="cyear-fr">Freshmen</label><br>
                <input type="radio" name="cyear" id="cyear-so" value="so" <?php if (isset($cyear) && $cyear == "so") { echo " checked "; } ?>>
                <label for="cyear-so">Sophomore</label><br>
                <input type="radio" name="cyear" id="cyear-jr" value="jr"<?php if (isset($cyear) && $cyear == "jr") { echo " checked "; } ?>>
                <label for="cyear-jr">Junior</label><br>
                <input type="radio" name="cyear" id="cyear-sr" value="sr"<?php if (isset($cyear) && $cyear == "sr") { echo " checked "; } ?>>
                <label for="cyear-sr">Senior</label><br>
            </fieldset><br>
            <fieldset>
                <legend class="label_text">Mailing List:</legend>
                <?php if (!empty($error_mlist)) { echo "<span class='error'>$error_mlist</span><br>"; } ?>
                <input type="radio" name="mlist" id="mlist-yes" value="1"<?php if (isset($mlist) && $mlist == 1) { echo " checked "; } ?>>
                <label for="mlist-yes">Yes</label><br>
                <input type="radio" name="mlist" id="mlist-no" value="0"<?php if (isset($mlist) && $mlist == 0) { echo " checked "; } ?>>
                <label for="mlist-no">No</label><br>
            </fieldset> <br>
            <label class="label_text" for="comments">Comments:</label><br>
            <?php if (!empty($error_comments)) { echo "<span class='error'>$error_comments</span><br>"; } ?>
            <textarea name="comments" id="comments" placeholder="Additional Comments."><?php if (isset($comments)) { echo $comments; } ?></textarea>
            <br>
<!--            <label for="submit">Submit:</label> Do we need a 'submit' word here? -->
            <input type="submit" name="submit" id="submit" value="submit">
        </form>

    </div>
    <?php
} //Closes the if statement for show_form

//Include the footer with require_once
require_once "footer.php";
?>















