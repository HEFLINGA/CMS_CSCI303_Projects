<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/27/2023
 * Time: 2:06 PM
*/

$pageName = "Update Profile";
require_once "header.php";
check_login();

// Re-populate all fields initially
$sql = "SELECT * FROM users WHERE ID = :ID";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':ID', $_SESSION['ID']);
$stmt->execute();
$row = $stmt->fetch();

$_SESSION['email'] = trim(strtolower($row['email']));
$_SESSION['username'] = trim($row['username']);

// Create local variables with initial values
$username = trim($row['username']);
$email = $row['email'];
$bio = $row['bio'];

// Local variables for error checking and form display
$show_form = 1;
$error_exists = 0;
$error_msg = "";
$error_username = "";
$error_email = "";

// Process the form when submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Local variables from form:
    $username = trim($_POST['username']);
    $email = trim(strtolower($_POST['email']));
    $bio = $_POST['bio'];

    // Error checking:
    if (empty($username)){
        $error_exists = 1;
        $error_username = "Missing username.";
    } else {
        if ($_SESSION['username'] != $username){
            $sql = "SELECT username FROM users WHERE username = :field";
            $dupeusername = check_duplicates($pdo, $sql, $username);
            if ($dupeusername) {
                $error_exists = 1;
                $error_username = "This username is already taken. Please try a different username.";
            }
        }
    }

    // Validation for email
    if (empty($email)) {
        $error_exists = 1;
        $error_email = "Missing email.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_exists = 1;
            $error_email = "Email is not valid.";
    } else {
        if($_SESSION['email'] != $email){
            $sql = "SELECT email FROM users WHERE email = :field";
            $dupemail = check_duplicates($pdo, $sql, $email);
            if ($dupemail) {
                $error_exists = 1;
                $error_email = "This email has already been registered.";
            }
        }
    }

    // Check if there was an error. If not, send the data to the database:
    if ($error_exists == 1) {
        $error_msg = "There are errors in the form.  Please make the necessary changes and re-submit.";
    } else {
        // Type your code to UPDATE the user in the database here
        $sql = "UPDATE users
                SET username = :username, email = :email, bio = :bio
                WHERE ID = :ID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('ID', $_SESSION['ID']);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':bio', $bio);
        $stmt->execute();

        //Displaying a success message to the user
        echo "<p class='success'>Thank you for completing the form, it has been successfully submitted. Have a nice day!</p>";

        $Subject = "Successfully Updated profile for Book Review website!";
        $Body = "<p style='color:darkred'>Your profile has been successfully updated. <br><br>Your username: $username.</p>";
        $AltBody = 'Successfully updated profile!';
        $EmailOkay = "A confirmation email has been sent to $email.";
        $EmailFail = "Oh no! There was an error during the emailing process.";

        //send email and check for errors
        $sent_email = send_email($Subject, $Body, $AltBody, $email, $username);
        if ($sent_email == 1) {
            echo "<p class='success'>$EmailOkay</p><br>";
        } else {
            echo "<p class='error'>$EmailFail</p>";
        }
        $show_form = 0;
    }
}

// Displaying the Sign-up form
if($show_form == 1){
    ?>
    <div class="form_signup">
        <?php if (!empty($error_exists)) echo "<p class='error'>$error_msg</p>"; ?>
        <p class="informative">Please fill out the below form to update your profile!</p>
        <form name="signup" id="signup" method="post" action="<?php echo $currentFile; ?>">
            <label class="label_text" for="username">Username:</label><br>
            <?php if (!empty($error_username)) { echo "<br><span class='error'>$error_username</span><br><br>"; } ?>
            <input type="text" name="username" id="username"
                   maxlength="30" size="40" placeholder="Enter Username"
                   value="<?php if (isset($username)) { echo htmlspecialchars($username); } ?>">
            <br>
            <label class="label_text" for="email">Email:</label><br>
            <?php if (!empty($error_email)) { echo "<br><span class='error'>$error_email</span><br><br>"; } ?>
            <input type="email" name="email" id="email"
                   size="40" placeholder="example@email.com"
                   value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
            <br>
            <label class="label_text" for="bio">Summary of Yourself:</label><br>
            <textarea name="bio" id="bio" placeholder="Optional: Personal Bio"><?php if (isset($bio)) { echo $bio; } ?></textarea>
            <br>
            <input type="submit" name="submit" id="submit" value="UPDATE">
        </form>
    </div>
    <?php
} //Closes the if statement for show_form
//Include the footer with require_once
require_once "footer.php";
?>