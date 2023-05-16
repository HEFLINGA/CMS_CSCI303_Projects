<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 3/20/2023
 * Time: 4:12 PM
*/

$pageName = "Login";

require_once "header.php";

// Local variables
$error_exists = 0;
$error_email = "";
$error_pwd   = "";
$error_msg = "";
$show_form = 1;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = trim(strtolower($_POST['email']));
    $pwd = $_POST['pwd'];

    if (empty($email)) {
        $error_exists = 1;
        $error_email = "Missing email.";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_exists = 1;
            $error_email = "Email is not valid.";
        }
    }
    if (empty($pwd)) {
        $error_exists = 1;
        $error_pwd = "Missing password.";
    }

    if ($error_exists == 1) {
        $error_msg = "We were not able to log you in! Please try again.";
    } else {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();
        if(!$row) {
            $error_msg =  "Your email and password combination did not match. Please try again.";
        } else {
            if (password_verify($pwd, $row['pwd'])) {
                $_SESSION['ID'] = $row['ID'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['admin'] = $row['admin'];

                header("location: confirm.php?state=2");
            } else {
                $error_msg = "Your email and password combination did not match. Please try again.";
            }
        }
    }
}

if($show_form == 1) {
    ?>
    <div class="form_small">
        <?php if (!empty($error_msg)) echo "<p class='error'>$error_msg</p>"; ?>
        <form name="login" id="login" method="post" action="<?php echo $currentFile; ?>">
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
            <input type="submit" id="submit" name="submit" value="SUBMIT">
        </form>
    </div>
    <?php
}

require_once "footer.php";