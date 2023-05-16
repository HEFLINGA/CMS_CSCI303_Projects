<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 1/29/2023
 * Time: 4:31 PM
*/

//COPY ALL OF THE CODE ON THIS PAGE *AFTER* YOUR INITIAL COMMENTS
$pageName = "Home";
require_once "header.php";
?>
    <?php
    // Query the data
    $sql = "SELECT title, ID FROM content ORDER BY title";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row) {
        ?>
        <a href="contentview.php?q=<?php echo $row['ID']?>"><?php echo $row['title']; ?></a><br>
        <?php
    }

require_once "footer.php";
