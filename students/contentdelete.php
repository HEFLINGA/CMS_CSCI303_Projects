<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/14/2023
 * Time: 10:31 AM
*/ 

$pageName = "Delete Content";
require_once "header.php";
check_login();

$show_form = 1;

// Check to see if $_GET['q'] has been set
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['q'])) {
    $cID = $_GET['q'];
} elseif($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])) {
    $cID = $_POST['id'];
}

// Re-populate all fields initially
$sql = "SELECT * FROM content WHERE ID = :ID";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':ID', $cID);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row){
    if ($_SESSION['ID'] == $row['studentID']){
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $sql = "DELETE FROM content WHERE ID = :ID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':ID', $cID);
            $stmt->execute();

            // Give user a message about the deletion
            echo "<p>The content: <strong>" . $_POST['title'] . "</strong> has been deleted.</p>";
            echo "<p>Click <a href='contentmanage.php'>Here</a> to return to the Content Management page.</p>";

            $show_form = 0;
        }
        if($show_form == 1){
            // id/q == Content ID -- studentID/d == Student Creator ID -- title/t == Content Title
            ?>
                <div class="deletion">
                    <p>Are you sure you wish to delete <strong><?php echo $row['title']; ?></strong>?</p>
                    <form id="delete" name="delete" method="post" action="<?php echo $currentFile; ?>">
                        <input type="hidden" id="id" name="id" value="<?php echo $_GET['q']; ?>">
                        <input type="hidden" id="title" name="title" value="<?php echo $row['title']; ?>">
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