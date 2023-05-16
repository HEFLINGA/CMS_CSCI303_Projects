<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/13/2023
 * Time: 10:50 AM
*/

$pageName = "Update Content";
require_once "header.php";
check_login();

$show_form = 1;

// Local variables
$error_exists  = 0;
$error_title   = "";
$error_details = "";

// Check to see if $_GET['q'] has been set
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['q'])) {
    $_SESSION['cID'] = $_GET['q'];
} elseif($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ID'])) {
    $_SESSION['cID'] = $_POST['ID'];
}

// Re-populate all fields initially
$sql = "SELECT * FROM content WHERE ID = :ID";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':ID', $_SESSION['cID']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row){
    if ($_SESSION['ID'] == $row['studentID']){
        $_SESSION['title'] = trim($row['title']);

        // Populate local variables.
        $title = trim($row['title']);
        $details = trim($row['details']);

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $title   = trim($_POST['title']);
            $details = $_POST['details'];

            if (empty($title)) {
                $error_exists = 1;
                $error_title = "Missing Title.";
            } elseif ($title != $_SESSION['title']) {
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
                // Update all fields with changes to data (except that password)
                $sql = "UPDATE content 
                SET title = :title, details = :details
                WHERE ID = :ID";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':ID', $_SESSION['cID']);
                $stmt->bindValue(':title', $title);
                $stmt->bindValue(':details', $details);
                $stmt->execute();

                $show_form = 0;

                echo "<p class='success'>Content Updated Successfully!</p>";
            }

        }

        if($show_form == 1) {
            ?>
            <div class="form_medium">
                <p class="informative">Please update your content how you wish, and press submit.</p>
                <form name="update" id="update" method="post" action="<?php echo $currentFile; ?>">
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
    }else {
        echo "<p class='error'>Error. Only the owner can modify this content.</p>";
    }
} else {
    echo "<p class='error'>Error. Content no longer exists.</p>";
}

require_once "footer.php";