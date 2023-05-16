<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/25/2023
 * Time: 11:06 AM
*/

$pageName = "Sign Up";
require_once "header.php";

// Local variables for error checking and form display
$show_form = 1;
$error_exists = 0;
$error_msg = "";
$error_username = "";
$error_email = "";
$error_pwd = "";

// Process the form when submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Local variables from form:
    $username = trim($_POST['username']);
    $email = trim(strtolower($_POST['email']));
    $pwd   = $_POST['pwd'];
    $bio = $_POST['bio'];
    $hash_pwd = "";

    // Error checking:
    if (empty($username)){
        $error_exists = 1;
        $error_username = "Missing username.";
    } else {
        $sql = "SELECT username FROM users WHERE username = :field";
        $dupe_username = check_duplicates($pdo, $sql, $username);
        if ($dupe_username) {
            $error_exists = 1;
            $error_username = "This username is already taken. Please try a different username.";
        }
    }

    // Validation for email
    if (empty($email)) {
        $error_exists = 1;
        $error_email = "Missing email.";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_exists = 1;
            $error_email = "Email is not valid.";
        }
    }
    $sql = "SELECT email FROM users WHERE email = :field";
    $dupe_email = check_duplicates($pdo, $sql, $email);
    if ($dupe_email) {
        $error_exists = 1;
        $error_email = "This email has already been registered.";
    }

    //Checking password length
    if (empty($pwd)){
        $error_exists = 1;
        $error_pwd = "Missing password.";
    } else {
        if (strlen($pwd) < 10) {
            $error_exists = 1;
            $error_pwd = "Password must be at least 10 characters.";
        } else {
            $hash_pwd = password_hash($pwd, PASSWORD_DEFAULT);
        }
    }

    // Check if there was an error. If not, send the data to the database:
    if ($error_exists == 1) {
        $error_msg = "There are errors in the form.  Please make the necessary changes and re-submit.";
    } else {
        $joined = date("Y-m-d H:i:s");

        // Type your code to INSERT into the database here
        $sql = "INSERT INTO users (username, email, pwd, bio, joined)
                VALUES (:username, :email, :hash_pwd, :bio, :joined)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':hash_pwd', $hash_pwd);
        $stmt->bindValue(':bio', $bio);
        $stmt->bindValue(':joined', $joined);
        $stmt->execute();

        //Displaying a success message to the user
        echo "<p class='success'>Thank you for completing the form, it has been successfully submitted. Have a nice day!</p>";

        $Subject = "Successfully signed up for Book Review website!";
        $Body = "<p style='color:darkred'>Thank you for signing up! <br><br>Your username: $username.</p>";
        $AltBody = 'Thank you for signing up!';
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
        <p class="informative">Please fill out the below form to sign-up!</p>
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
            <label class="label_text" for="pwd">Password:</label><br>
            <?php if (!empty($error_pwd)) { echo "<br><span class='error'>$error_pwd</span><br><br>"; } ?>
            <input type="password" name="pwd" id="pwd"
                   size="40" placeholder="Enter Password">
            <br>
            <label class="label_text" for="bio">Summary of Yourself:</label><br>
            <textarea name="bio" id="bio" placeholder="Optional: Personal Bio"><?php if (isset($bio)) { echo $bio; } ?></textarea>
            <br>
            <input type="submit" name="submit" id="submit" value="SUBMIT">
        </form>

    </div>
    <?php
} //Closes the if statement for show_form
//Include the footer with require_once
require_once "footer.php";
?>