<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 3/21/2023
 * Time: 11:19 AM
*/

$pageName = "Delete";
require_once "header.php";

$showform = 1;

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql = "DELETE FROM employees WHERE emp_no = :emp_no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':emp_no', $_POST['emp_no']);
    $stmt->execute();

    // Confirmation message
    echo "<p>The employee <strong>" . $_POST['last_name'] . "</strong> has been deleted.</p>";
    echo "<p>Click <a href='selectoptions.php'>Here</a> to return to Select Options page.</p>";

    $showform = 0;
}
if($showform == 1){
    ?>
    <p>Are you sure you wish to delete <strong><?php $_GET['l']; ?></strong>?</p>
    <form id="delete" name="delete" method="post" action="<?php echo $currentFile; ?>">
        <input type="hidden" id="emp_no" name="emp_no" value="<?php echo $_GET['q']; ?>">
        <input type="hidden" id="last_name" name="last_name" value="<?php echo $_GET['l']; ?>">
        <input type="submit" id="delete" name="delete" value="CONFIRM">
    </form>
    <?php
}

require_once "footer.php";