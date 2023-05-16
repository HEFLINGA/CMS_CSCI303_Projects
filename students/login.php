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
$show_form = 1;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = trim(strtolower($_POST['email']));
    $pwd = $_POST['pwd'];

    if (empty($email)) {
        $error_exists = 1;
        $error_email = "Missing Email.";
    }
    if (empty($pwd)) {
        $error_exists = 1;
        $error_pwd = "Missing Password.";
    }

    if ($error_exists == 1) {
        echo "<p class='error'>We were not able to log you in! Please try again.</p>";
    } else {
        $sql = "SELECT * FROM students WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();
        if(!$row) {
            echo "<p class='error'>Your email and password combination did no match. Please try again.</p>";
        } else {
            if (password_verify($pwd, $row['pwd'])) {
                $_SESSION['ID'] = $row['ID'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['status'] = $row['adminstatus'];

                header("location: confirm.php?state=2");
            } else {
                echo "<p class='error'>Your email and password combination did no match. Please try again.</p>";
            }
        }
    }
}

if($show_form == 1) {
    ?>
    <div class="form_small">
        <form name="login" id="login" method="post" action="<?php echo $currentFile; ?>">
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
            <input type="submit" id="submit" name="submit" value="Submit">
        </form>
    </div>
    <?php
}

require_once "footer.php";