<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/29/2023
 * Time: 7:34 PM
*/

$pageName = "Add Content";

require_once "header.php";
check_admin();

$ID = $_SESSION['ID'];

$show_form = 1;

// Local variables
$error_exists  = 0;
$error_genrename = "";
$error_genrecode = "";
$error_priority = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $genrecode = trim($_POST['genrecode']);
    $genrename = trim($_POST['genrename']);
    $priority  = $_POST['priority'];

    // Error checking
    if (empty($genrename)) {
        $error_exists = 1;
        $error_genrename = "Missing genre name.";
    } else {
        $sql = "SELECT genrename FROM genres WHERE genrename = :field";
        $dupegenrename = check_duplicates($pdo, $sql, $genrename);
        if ($dupegenrename) {
            $error_exists = 1;
            $error_genrename = "This genre already exists.";
        }
    }
    if (empty($genrecode)){
        $error_exists = 1;
        $error_genrecode = "Missing genre code.";
    } else {
        $sql = "SELECT genrecode FROM genres WHERE genrecode = :field";
        $dupegenrecode = check_duplicates($pdo, $sql, $genrecode);
        if ($dupegenrecode) {
            $error_exists = 1;
            $error_genrecode = "This genre code already exists.";
        }
    }
    if (empty($priority)){
        $error_exists = 1;
        $error_priority = "Missing priority.";
    }

    if ($error_exists == 1) {
        echo "<p class='error'>There was an error creating the category. Check below for details.</p>";
    } else {
        $sql = "INSERT INTO genres (genrename, genrecode, priority)
                VALUES (:genrename, :genrecode, :priority)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':genrename', $genrename);
        $stmt->bindValue(':genrecode', $genrecode);
        $stmt->bindValue(':priority', $priority);
        $stmt->execute();

        $show_form = 0;

        echo "<p class='success'>Category was added successfully!</p>";
    }

}

if($show_form == 1) {
    ?>
    <div class="form_medium">
        <p class="informative">Please fill out the form to add your category! All fields are required.</p>
        <form name="add" id="add" method="post" action="<?php echo $currentFile; ?>" enctype="multipart/form-data">
            <label class="label_text" for="genrename">Genre Name:</label><br>
            <?php if (!empty($error_genrename)) { echo "<br><span class='error'>$error_genrename</span><br><br>"; } ?>
            <input type="text" name="genrename" id="genrename"
                   maxlength="100" size="50" placeholder="Genre Name"
                   value="<?php if (isset($genrename)) { echo htmlspecialchars($genrename); } ?>">
            <br>
            <label class="label_text" for="genrecode">Genre Code:</label><br>
            <?php if (!empty($error_genrecode)) { echo "<br><span class='error'>$error_genrecode</span><br><br>"; } ?>
            <input type="text" name="genrecode" id="genrecode"
                   minlength="3" maxlength="3" size="50" placeholder="Genre Code (e.g. ABC)"
                   value="<?php if (isset($genrecode)) { echo htmlspecialchars($genrecode); } ?>">
            <br>
            <label class="label_text" for="priority">Priority Number:</label><br>
            <?php if (!empty($error_priority)) { echo "<br><span class='error'>$error_priority</span><br><br>"; } ?>
            <input type="text" name="priority" id="priority"
                   minlength="1" maxlength="3" size="50" placeholder="Genre Priority (e.g. 3)"
                   value="<?php if (isset($priority)) { echo htmlspecialchars($priority); } ?>">
            <br>
            <input type="submit" name="submit" id="submit" value="ADD CATEGORY">
        </form>
    </div>
    <?php
}

require_once "footer.php";