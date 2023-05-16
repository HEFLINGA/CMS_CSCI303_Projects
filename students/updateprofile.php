<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/11/2023
 * Time: 9:15 AM
*/ 

$pageName = "Update Profile";
require_once "header.php";
check_login();

// Re-populate all fields initially
$sql = "SELECT * FROM students WHERE ID = :ID";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':ID', $_SESSION['ID']);
$stmt->execute();
$row = $stmt->fetch();

$_SESSION['email'] = trim(strtolower($row['email']));

// Populate local variables.
$fname = trim($row['fname']);
$lname = trim($row['lname']);
$mi    = $row['mi'];
$age   = $row['age'];
$email = $row['email'];
$cyear = $row['cyear'];
$mlist = $row['mlist'];
$airport = $row['airport'];
$comments = $row['comments'];


$show_form = 1;
$error_exists = 0;
// Error variables for form fields.
$error_fname = "";
$error_lname = "";
$error_email = "";
$error_cyear = "";
$error_age   = "";
$error_mlist = "";
$error_airport = "";
$error_comments = "";

// Process the submitted data

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Populate local variables.
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim(strtolower($_POST['email']));
    $mi    = $_POST['mi'];
    $age   = $_POST['age'];
    if (isset($_POST['cyear'])){
        $cyear = $_POST['cyear'];
    }
    if (isset($_POST['mlist'])) {
        $mlist = $_POST['mlist'];
    }
    $airport = $_POST['airport'];
    $comments = $_POST['comments'];

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

    // Validation for email field
    if (empty($email)) {
        $error_exists = 1;
        $error_email = "Missing Email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_exists = 1;
            $error_email = "Email is Not Valid.";
    } else {
        // Check for duplicate email if the email is changed
        if($_SESSION['email'] != $email){
            $sql = "SELECT email FROM students WHERE email = :field";
            $dupemail = check_duplicates($pdo, $sql, $email);
            if ($dupemail) {
                $error_exists = 1;
                $error_email = "This email has already been registered.";
            }
        }
    }



    // Error checking and database work
    if ($error_exists == 1) {
        echo "<p class='error'>There are errors in the form.  Please make changes and re-submit.</p>";
    } else {

        // Update all fields with changes to data (except that password)
        $sql = "UPDATE students 
                SET fname = :fname, lname = :lname, mi = :mi, email = :email, cyear = :cyear,
                    airport = :airport, age = :age, mlist = :mlist, comments = :comments
                WHERE ID = :ID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':ID', $_SESSION['ID']);
        $stmt->bindValue(':fname', $fname);
        $stmt->bindValue(':mi', $mi);
        $stmt->bindValue(':lname', $lname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':cyear', $cyear);
        $stmt->bindValue(':airport', $airport);
        $stmt->bindValue(':age', $age);
        $stmt->bindValue(':mlist', $mlist);
        $stmt->bindValue(':comments', $comments);
        $stmt->execute();

        //Displaying a success message to the user
        echo "<p class='success'>Your profile has been successfully updated. Have a nice day!</p>";

        $show_form = 0; //Hiding the form
    } // else control code   if ($error_exists == 1) {  NOT USED IN VERSION 1.  UNCOMMENT IN VERSION 3
}//submit

// Form
if($show_form == 1){


    ?>
    <div class="form_reg">
        <p class="informative">Make any necessary changes to your profile below and submit!</p>
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
            <input type="submit" name="submit" id="submit" value="submit">
        </form>
    </div>
    <?php
} //Closes the if statement for show_form

require_once "footer.php";