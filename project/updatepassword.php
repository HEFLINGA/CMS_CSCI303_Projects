<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/29/2023
 * Time: 6:36 PM
*/

$pageName = "Update Password";

require_once "header.php";
check_login();

$show_form = 1;

// Local variables
$error_exists = 0;
$error_pwd1   = "";
$error_pwd2   = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $pwd1 = $_POST['pwd1'];
    $pwd2 = $_POST['pwd2'];
    $hash_pwd = "";
    $ID = $_SESSION['ID'];

    // Password error checking logic
    if (empty($pwd1)) {
        $error_exists = 1;
        $error_pwd1 = "Missing Password.";
    } elseif (strlen($pwd1) < 10) {
        $error_exists = 1;
        $error_pwd1 = "Password Must be at Least 10 Characters.";
    } else {
        if (empty($pwd2)) {
            $error_exists = 1;
            $error_pwd2 = "Please Confirm Your Password.";
        } elseif ($pwd1 != $pwd2) {
            $error_exists = 1;
            $error_pwd2 = "Passwords Do Not Match.";
        }
    }

    if ($error_exists == 1) {
        echo "<p class='error'>There was an error changing your password! Please try again.</p>";
    } else {
        $hash_pwd = password_hash($pwd2, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET pwd = :pwd WHERE ID = :ID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':pwd', $hash_pwd);
        $stmt->bindValue(':ID', $ID);
        $stmt->execute();

        $show_form = 0;

        header("location: logout.php");
    }

}

if($show_form == 1) {
    ?>
    <div class="form_small">
        <p class="informative">*Once the form is submitted, you will be logged out and be required to re-log in with your new password.</p>
        <form name="updatepwd" id="updatepwd" method="post" action="<?php echo $currentFile; ?>">
            <label class="label_text" for="pwd1">Password:</label><br>
            <?php if (!empty($error_pwd1)) { echo "<br><span class='error'>$error_pwd1</span><br><br>"; } ?>
            <input type="password" name="pwd1" id="pwd1"
                   size="40" placeholder="Enter Password">
            <br>
            <label class="label_text" for="pwd2">Confirm Password:</label><br>
            <?php if (!empty($error_pwd2)) { echo "<br><span class='error'>$error_pwd2</span><br><br>"; } ?>
            <input type="password" name="pwd2" id="pwd2"
                   size="40" placeholder="Re-Enter Password">
            <br>
            <input type="submit" id="submit" name="submit" value="Submit">
        </form>
    </div>
    <?php
}

require_once "footer.php";