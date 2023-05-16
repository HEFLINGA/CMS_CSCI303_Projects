<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/27/2023
 * Time: 10:24 AM
*/

$pageName = "Update Book Review";
require_once "header.php";
check_login();

$show_form = 1;

// Local variables
$error_exists  = 0;
$error_title   = "";
$error_comments = "";

// Check to see if $_GET['q'] has been set
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['q'])) {
    $_SESSION['bID'] = $_GET['q'];
} elseif($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ID'])) {
    $_SESSION['bID'] = $_POST['ID'];
}

// Re-populate all fields from DB
$sql = "SELECT * FROM books WHERE ID = :ID";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':ID', $_SESSION['bID']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the requested book review exists
if ($row){
    // Check if it is the authorized user
    if ($_SESSION['ID'] == $row['userID'] || $_SESSION['admin'] == 1){
        $_SESSION['title'] = trim($row['title']);

        // Populate local variables.
        $title = trim($row['title']);
        $comments = trim($row['comments']);

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $title   = trim($_POST['title']);
            $comments = $_POST['comments'];

            if (empty($title)) {
                $error_exists = 1;
                $error_title = "Missing title.";
            }
            if (empty($comments)) {
                $error_exists = 1;
                $error_comments = "Missing review details.";
            }

            if ($error_exists == 1) {
                echo "<p class='error'>There was an error updating your review. Check below for details.</p>";
            } else {
                // Update the requested fields
                $sql = "UPDATE books 
                SET title = :title, comments = :comments
                WHERE ID = :ID";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':ID', $_SESSION['bID']);
                $stmt->bindValue(':title', $title);
                $stmt->bindValue(':comments', $comments);
                $stmt->execute();

                $show_form = 0;

                echo "<p class='success'>Review Updated Successfully!</p>";
            }

        }

        if($show_form == 1) {
            ?>
            <div class="form_medium">
                <p class="informative">Please update your content how you wish, and press update.</p>
                <form name="update" id="update" method="post" action="<?php echo $currentFile; ?>">
                    <label class="label_text" for="title">Title:</label><br>
                    <?php if (!empty($error_title)) { echo "<br><span class='error'>$error_title</span><br><br>"; } ?>
                    <input type="text" name="title" id="title"
                           maxlength="255" size="40" placeholder="Title"
                           value="<?php if (isset($title)) { echo htmlspecialchars($title); } ?>">
                    <br>
                    <label class="label_text" for="comments">Review Comments:</label><br>
                    <?php if (!empty($error_comments)) { echo "<br><span class='error'>$error_comments</span><br><br>"; } ?>
                    <textarea name="comments" id="comments" placeholder="Review Comments"><?php if (isset($comments)) { echo $comments; } ?></textarea>
                    <br>
                    <input type="submit" name="submit" id="submit" value="UPDATE">
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