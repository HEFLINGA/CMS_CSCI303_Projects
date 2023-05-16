<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/12/2023
 * Time: 10:25 AM
*/ 

$pageName = "View Content";
require_once "header.php";

// Check to see if $_GET['q'] has been set
if (!isset($_GET['q']) || !is_numeric($_GET['q'])) {
    ?>
    <p class="error">There was an error viewing this content.</p>
    <p>Back to the content manager: <a href="contentmanage.php">Content Manager</a></p>
    <?php
} else {

    // Query the data
    $sql = "SELECT * FROM content LEFT JOIN students 
            ON students.ID = content.studentID
            WHERE content.ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ID', $_GET['q']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Display the stuff to the screen for the user to view
    if (empty($row['fname'])) {
        $row['fname'] = "[DELETED USER]";
    }
    ?>

    <table class="view_content">
        <tr><th>Title: </th><td class="title"><h4><?php echo $row['title']; ?></h4></td></tr>
        <tr><th>Creator: </th><td><?php echo $row['fname'] . " " . $row['lname']; ?></td></tr>
        <tr><th>Date: </th><td><?php echo date("F d, y", strtotime($row['added'])); ?></td></tr>
        <tr><th>Details: </th><td><?php echo $row['details']; ?></td></tr>
    </table>

    <?php

} // End of ifelse statement


require_once "footer.php";