<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/27/2023
 * Time: 10:25 AM
*/

$pageName = "Delete Book Review";
require_once "header.php";
check_login();

$show_form = 1;

// Check to see if $_GET['q'] has been set
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['q'])) {
    $bID = $_GET['q'];
} elseif($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])) {
    $bID = $_POST['id'];
}

$sql = "SELECT * FROM books LEFT JOIN users 
            ON users.ID = books.userID
            WHERE books.ID = :ID";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':ID', $bID);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row){
    if ($_SESSION['ID'] == $row['userID'] || $_SESSION['admin'] == 1){
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $sql = "DELETE FROM books WHERE ID = :ID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':ID', $bID);
            $stmt->execute();

            // Give user a message about the deletion
            echo "<p>The Review for the book <strong>" . $_POST['title'] . "</strong> by <strong>" . $_POST['username'] . "</strong> has been deleted.</p>";
            echo "<p>Click <a href='bookreviews.php'>Here</a> to return to all Book Reviews page.</p>";

            $show_form = 0;
        }
        if($show_form == 1){
            ?>
            <div class="deletion">
                <p>Are you sure you wish to delete the review of <strong><?php echo $row['title']; ?></strong> written by <strong><?php echo $row['username']; ?></strong>?</p>
                <form id="delete" name="delete" method="post" action="<?php echo $currentFile; ?>">
                    <input type="hidden" id="id" name="id" value="<?php echo $_GET['q']; ?>">
                    <input type="hidden" id="title" name="title" value="<?php echo $row['title']; ?>">
                    <input type="hidden" id="username" name="username" value="<?php echo $row['username']; ?>">
                    <input type="submit" id="delete" name="delete" value="DELETE">
                </form>
            </div>
            <?php
        }
    } else {
        echo "<p class='error'>The deletion of this content can only be done by the creator.</p>";
    }
} else {
    echo "<p class='error'>Error. This content does not exist.</p>";
}

require_once "footer.php";