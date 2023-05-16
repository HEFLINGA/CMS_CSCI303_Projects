<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/11/2023
 * Time: 10:14 AM
*/ 

$pageName = "Add Content";

require_once "header.php";
check_login();

$ID = $_SESSION['ID'];

$show_form = 1;

// Local variables
$error_exists  = 0;
$error_title   = "";
$error_details = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $title   = trim($_POST['title']);
    $details = $_POST['details'];
    $added = date("Y-m-d H:i:s");

    if (empty($title)) {
        $error_exists = 1;
        $error_title = "Missing Title.";
    } else {
        $sql = "SELECT title FROM content WHERE title = :field";
        $dupe = check_duplicates($pdo, $sql, $title);
        if ($dupe) {
            $error_exists = 1;
            $error_title = "This title has already been used.";
        }
    }
    if (empty($details)) {
        $error_exists = 1;
        $error_details = "Missing Details.";
    }

    if ($error_exists == 1) {
        echo "<p class='error'>There was an error inserting your entry. Check below for details.</p>";
    } else {
        $sql = "INSERT INTO content (studentID, title, details, added)
                VALUES (:studentID, :title, :details, :added)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':studentID', $ID);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':details', $details);
        $stmt->bindValue(':added', $added);
        $stmt->execute();

        $show_form = 0;

        echo "<p class='success'>Content added successfully!</p>";
    }

}

if($show_form == 1) {
    ?>
    <div class="form_medium">
        <p class="informative">Please fill out the form to add your content! All fields are required.</p>
        <form name="add" id="add" method="post" action="<?php echo $currentFile; ?>">
            <label class="label_text" for="title">Title:</label><br>
            <?php if (!empty($error_title)) { echo "<span class='error'>$error_title</span><br>"; } ?>
            <input type="text" name="title" id="title"
                   maxlength="255" size="40" placeholder="Title"
                   value="<?php if (isset($title)) { echo htmlspecialchars($title); } ?>">
            <br>
            <label class="label_text" for="details">Details:</label><br>
            <?php if (!empty($error_details)) { echo "<span class='error'>$error_details</span><br>"; } ?>
            <textarea name="details" id="details" placeholder="Details"><?php if (isset($details)) { echo $details; } ?></textarea>
            <br>
            <input type="submit" name="submit" id="submit" value="submit">
        </form>
    </div>
    <?php
}

require_once "footer.php";